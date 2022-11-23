<?php
namespace App\Services;

use App\Services\Concerns\BaseService;
use App\Services\Twitter\TwitterApiService;
use App\Repositories\{LocationHistoryRepository, TaskUserRepository};
use Carbon\Carbon;
use App\Helpers\ActionHelper;
use App\Models\{DetailReward, Branch, Reward, UserTaskReward};
use Illuminate\Support\Str;

class SocialService extends BaseService
{
    /**
     * @param $twitterApiService
     * @param $locationHistoryRepository
     */
    public function __construct(
        private TwitterApiService $twitterApiService,
        private TaskUserRepository $taskUserRepository
    ) {}

    /**
     * User start task at location
     *
     * @param string $taskId Task ID
     * @param string $socialId Task Social ID
     * @param string $user User
     * @param string $type {FOLLOW, LIKE, RETWEET, TWEET, HASHTAG}
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function performTwitter($user, $twitterUserId, $type = LIKE, $taskId, $userSocial)
    {
        $socialRes = [false, 'Bạn chưa ' . ActionHelper::getTypeStr($type)[1]];

        if (empty($user) || ($user && (is_null($user->twitter) || $user->twitter == ''))) {
            return $socialRes;
        }

        $key = ($userSocial && $userSocial->url) ? last(explode('/', $userSocial->url)) : null;

        switch((int) $type) {
            case LIKE:
                // url demo: https://twitter.com/NEARProtocol/status/1586347120872808448
                // params {userTweetId, tweetId(1586347120872808448)}
                $socialRes = $this->twitterApiService->isLikes($twitterUserId, $key);
                break;
            case FOLLOW:
                // url demo: https://twitter.com/NEARProtocol
                // params {userTweetId, pageID(NEARProtocol)}
                $socialRes = $this->twitterApiService->isFollowing($twitterUserId, $key);
                break;
            case RETWEET:
                // url demo: https://twitter.com/NEARProtocol/status/1586347120872808448
                // params: {userTweetId}
                $socialRes = $this->twitterApiService->isUserRetweet($twitterUserId, $key);
                break;
            case HASHTAG:
                // params {userTweetId, $key: string | array }
                $text = $userSocial->name . ' ' . $userSocial->description;
                $textArrs = explode(' ', $text);
                $keys = [];
                foreach($textArrs as $txt) {
                    if (Str::contains($txt, '#')) { $keys[] = $txt; }
                }
                $socialRes = $this->twitterApiService->isHashTag($twitterUserId, $keys);
                break;
            default:
                $socialRes = $socialRes;
        }

        if ($socialRes[0]) {
            $user = $this->taskUserRepository->firstOrNewSocial($user->id, $taskId, $userSocial->id);
            $user->fill(['status' => USER_COMPLETED_TASK]);
            $user->save();
        }

        return $socialRes;
    }


    /**
     * Start social task
     *
     * @param string $userId
     * @param object $task
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function startTaskSocial($userId, $task)
    {
        foreach($task->taskSocials()->get() as $taskSocial) {
            $user = $this->taskUserRepository
                ->firstOrNewSocial($userId, $task->id, $taskSocial->id);

            if (is_null($user->id) || !$user->id) {
                $user->fill([
                    'status' => USER_PROCESSING_TASK,
                    'started_at' => Carbon::now(),
                    'activity_log' => null
                ]);

                $user->save();
            }
        }

        return;
    }

    public function saveDetailReward($user)
    {
        try {
            $reward = Reward::first();
            $branch = Branch::first();
            $amount = random_int(10, 20);

            $data = DetailReward::create([
                'branch_id' => $branch->id,
                'reward_id' => $reward->id,
                'type' => 0,
                'name' => 'Plats point token',
                'amount' => $amount,
                'description' => "Plats point",
                'url_image' => 'icon/token-nft.png',
                'status' => true,
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()
            ]);

            $rewardUser = UserTaskReward::create([
                'user_id' => $user->id,
                'detail_reward_id' => $data->id,
                'type' => 0,
                'amount' => $amount,
                'is_open' => false,
                'is_tray' => false
            ]);
        } catch (\Exception $e) {
            $rewardUser = null;
        }

        return $rewardUser;
    }
}
