<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\{Http, Log, Storage};
use App\Models\{DetailReward, TaskUser, UserTaskReward};

class CalcUserBonusCheckIn extends Command
{
    public function __construct(
        private DetailReward $detailReward,
        private TaskUser $taskUser,
        private UserTaskReward $userTaskReward
    ) {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:user-bonus-checkin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tính phần thưởng cho user khi thực hiện checkin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Test update proccess is false
        // $this->detailReward->whereProccess(true)->update(['proccess' => false]);
        $icon = Storage::disk('s3')->url('icon/hidden_box.png');

        // Get user task done
        $userIds = $this->taskUser
            ->whereStatus(USER_COMPLETED_TASK)
            ->pluck('user_id')->toArray();

        // Get bonus
        $bonus = $this->detailReward
            ->whereProccess(false)
            ->get();

        print('=====> count: '. $bonus->count(). "\n");

        foreach($bonus as $item) {
            $checkBonus = $this->userTaskReward
                ->whereDetailRewardId($item->id)
                ->first();

            if ($checkBonus) {
                print("======> Đã trao: " . $item->id . "\n");
                continue;
            }

            $userId = $userIds[array_rand($userIds, 1)];

            print("======> USER ID: " . $userId . "\n");
            
            // User done task random bonus
            $this->userTaskReward->create([
                'user_id' => $userId,
                'detail_reward_id' => $item->id,
                'type' => $item->type ?? null,
                'amount' => $item->amount ?? null
            ]);

            // Những item đã đc sử lý
            $item->update(['proccess' => true]);
            print("======> BONUS ID: " . $item->id . "\n");


            // Push notices
            print("======>  Push notice for USER ID: " . $userId . "\n");
            $response = Http::withHeaders([
                'X-NOTICE' => config('app.notice_code'),
            ])->post(config('app.api_url_notice') . '/api/push_notice', [
                'title' => '💥💥Bạn vừa nhận được hidden box 💥💥',
                'desc' => '💥💥💥💥Chúc mừng bạn nhận được hidden box💥💥💥💥',
                'type' => 'box',
                'icon' => $icon ?? null,
                'type_id' => $item->id,
                'user_id' => $userId
            ]);

            Log::info('Call api service noti', [
                'code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents()
            ]);
        }

        return Command::SUCCESS;
    }
}
