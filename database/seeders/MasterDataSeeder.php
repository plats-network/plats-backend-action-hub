<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
    Reward, Task, TaskGallery,
    TaskLocation, TaskLocationJob, TaskSocial
};
use Carbon\Carbon;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        print('Create rewards \n');
        $rewards = ['$PSP', '$PLATS', '$NFT', '$ETH', '$BTC', '$USDT'];
        foreach($rewards as $reward) {
            $reward = Reward::where('symbol', $reward)->first();
            if ($reward) { continue; }

            Reward::create([
                'name' => "Reward $reward",
                'description' => "Description $reward",
                'image' => 'https://www.shutterstock.com/image-photo/surreal-image-zebra-two-black-260nw-729088339.jpg',
                'order' => random_int(1, 100),
                'status' => true
            ]);
        }

        print("Create task \n");
        $uuids = [
            'c519af43-1349-46bb-ab52-de6b53981d8c',
            '101ed251-5b3c-4c66-80a7-82782476b687',
            'c96b6066-c90c-45ed-aea3-3f74ca2a15b6',
            'b507e645-1f63-48b6-b279-bc90aef65369',
            '8f079b77-ad94-4875-b940-7a253666bd09'
        ];

        foreach($uuids as $k => $uuid) {
            if (Task::find($uuid)) {continue;}

            Task::create([
                'id' => $uuid,
                'name' => 'Task '. $k,
                'description' => 'Desc '. $k,
                'banner_url' => 'https://www.shutterstock.com/image-photo/surreal-image-zebra-two-black-260nw-729088339.jpg',
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(100),
                'order' => random_int(1, 100),
                'status' => true,
                'type' => 0,
                'creator_id' => '96be321e-296b-469e-bc2e-3f977c8bdf3a',
            ]);

            $checkin = TaskLocation::create([
                'task_id' => $uuid,
                'reward_id' => Reward::inRandomOrder()->first()->id,
                'name' => 'Checkin ' . random_int(1, 10),
                'description' => 'Description ' . random_int(1, 100),
                'amount' => random_int(1, 100),
                'job_num' => 1,
                'order' => random_int(1, 100),
                'status' => true,
            ]);

            $rewardId = Reward::first()->id;
            $params = [
                'task_id' => $uuid,
                'reward_id' => $rewardId,
                'name' => 'Flow',
                'description' => 'Description',
                'url' => 'https://demo.com',
                'amount' => random_int(1,10),
                'order' => random_int(1,10),
                'lock' => false,
                'status' => true
            ];

            // Twittwer
            TaskSocial::create(array_merge($params, ['platform' => TWITTER,'type' => TWITTER_FOLLOW]));
            TaskSocial::create(array_merge($params, ['platform' => TWITTER,'type' => TWITTER_LIKE]));
            TaskSocial::create(array_merge($params, ['platform' => TWITTER,'type' => TWITTER_RETWEET]));
            TaskSocial::create(array_merge($params, ['platform' => TWITTER,'type' => TWITTER_TWEET]));

            // FB
            TaskSocial::create(array_merge($params, ['platform' => FACEBOOK,'type' => FACEBOOK_SHARE]));
            TaskSocial::create(array_merge($params, ['platform' => FACEBOOK,'type' => FACEBOOK_LIKE]));
            TaskSocial::create(array_merge($params, ['platform' => FACEBOOK,'type' => FACEBOOK_POST]));
            TaskSocial::create(array_merge($params, ['platform' => FACEBOOK,'type' => FACEBOOK_JOIN_GROUP]));

            // Telegram
            TaskSocial::create(array_merge($params, ['platform' => TELEGRAM,'type' => TELEGRAM_JOIN]));
            TaskSocial::create(array_merge($params, ['platform' => DISCORD,'type' => DISCORD_JOIN]));

            for($i = 0; $i < 5; $i++) {
                TaskGallery::create([
                    'task_id' => $uuid,
                    'url_image' => 'https://www.shutterstock.com/image-photo/surreal-image-zebra-two-black-260nw-729088339.jpg',
                    'status' => true
                ]);

                TaskLocationJob::create([
                    'task_location_id' => $checkin->id,
                    'name' => 'Check-In: Location ' . random_int(1, 100),
                    'address' => "Addredd ". random_int(1, 100),
                    'lat' => random_int(1, 180),
                    'lng' => random_int(1, 90),
                    'status' => true,
                    'order' => random_int(1,100),
                ]);
            }
        }

        print("End Seed!");
    }
}
