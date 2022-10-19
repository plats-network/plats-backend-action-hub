<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{
    DetailReward,
    TaskUser,
    UserTaskReward
};

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
        // Get user task done
        $userIds = $this->taskUser
            ->whereStatus(USER_COMPLETED_TASK)
            ->pluck('user_id')->toArray();
        // Get bonus
        $bonus = $this->detailReward
            ->whereProccess(false)
            ->get();

        foreach($bonus as $item) {
            
            
            // User done task random bonus
            // $this->userTaskReward->create([
            //     'user_id' => 2,
            //     'detail_reward_id' => $item->id,
            //     'type' => $item->type ?? null,
            //     'amount' => $item->amount ?? null
            // ]);



            // Những item đã đc sử lý
            // $item->update(['proccess' => true]);
        }

        return Command::SUCCESS;
    }
}
