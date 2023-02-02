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
        $rewards = [
            [
                'symbol' => '$PSP',
                'name' => 'Point',
                'img' => 'icon/psp-icon.png'
            ],
            [
                'symbol' => '$PLATS',
                'name' => 'Plats',
                'img' => 'icon/psp-icon.png'
            ]
        ];

        $datas = [
            [
                'id' => 'c519af43-1349-46bb-ab52-de6b53981d8c',
                'name' => 'Check in at 30 Shine Hà Nội',
                'description' => 'Là một trong những chuỗi cửa hàng salon tóc nam uy tín nhất Việt Nam, 30Shine cung cấp đầy đủ các dịch vụ làm tóc, chăm sóc tóc. Thông qua chiến dịch lần này, 30Shine tri ân khách hàng thông qua chương trình ưu đãi lên đến 50% cho các dịch vụ/ sản phẩm chăm tóc tóc.',
                'banner_url' => 'tasks/checkin-01.png',
                'local_name' => '30 Shine quận Hoàn Kiếm',
                'locals' => [
                    [
                        'name' => 'Salon 163 Hàng Bông',
                        'address' => '163 P. Hàng Bông, Hàng Bông, Hoàn Kiếm, Hà Nội',
                        'lat' => '21.02927913',
                        'lng' => '105.8452339'
                    ],
                    [
                        'name' => 'Salon 82 Trần Đại Nghĩa, p. Đồng Tâm',
                        'address' => '82 P. Trần Đại Nghĩa, Đồng Tâm, Hai Bà Trưng, Hà Nội',
                        'lat' => '21.00023575',
                        'lng' => '105.8451843'
                    ],
                    [
                        'name' => 'Salon 391 Trương Định, P. Tân Mai',
                        'address' => '391 Trương Định, Tân Mai, Hoàng Mai, Hà Nội ',
                        'lat' => '20.96572476',
                        'lng' => '105.823963'
                    ]
                ]
            ],
            [
                'id' => '101ed251-5b3c-4c66-80a7-82782476b687',
                'name' => 'Check in at 30 Shine HCM',
                'description' => 'Là một trong những chuỗi cửa hàng salon tóc nam uy tín nhất Việt Nam, 30Shine cung cấp đầy đủ các dịch vụ làm tóc, chăm sóc tóc. Thông qua chiến dịch lần này, 30Shine tri ân khách hàng thông qua chương trình ưu đãi lên đến 50% cho các dịch vụ/ sản phẩm chăm tóc tóc.',
                'banner_url' => 'tasks/checkin-02.png',
                'local_name' => '30 Shine Quận Thủ Đức',
                'locals' => [
                    [
                        'name' => 'Salon 168 Đặng Văn Bi, P. Bình Thọ',
                        'address' => '168 Đặng Văn Bi Phường Bình Thọ Thành phố Thủ Đức Thành phố Hồ Chí Minh',
                        'lat' => '10.84731304',
                        'lng' => '106.7606336'
                    ],
                    [
                        'name' => 'Salon 1172 Kha Vạn Cân , KP1, P. Linh Chiểu',
                        'address' => '1172 Đ. Kha Vạn Cân, KP1, Thủ Đức, Thành phố Hồ Chí Minh',
                        'lat' => '10.86026575',
                        'lng' => '106.7604501'
                    ]
                ]
            ],
            [
                'id' => 'c96b6066-c90c-45ed-aea3-3f74ca2a15b6',
                'name' => 'Check in at McDonald',
                'description' => 'McDonald’s sẽ thiết lập một chuẩn mực mới cho ngành công nghiệp nhà hàng phục vụ thức ăn nhanh tại Việt Nam, mang đến cho khách hàng những trải nghiệm độc nhất chỉ có tại chuỗi nhà hàng của mình. McDonald’s Việt Nam cam kết áp dụng tiêu chuẩn của McDonald’s toàn cầu, đó là: Quality - Chất lượng, Service - Dịch vụ, Cleanliness - Vệ Sinh & Values - Giá trị.',
                'banner_url' => 'tasks/checkin-03.png',
                'local_name' => 'McDonald',
                'locals' => [
                    [
                        'name' => 'Mc Donald Tràng Tiền',
                        'address' => '2 P. Hàng Bài, Tràng Tiền, Hoàn Kiếm, Hà Nội, Việt Nam',
                        'lat' => '21.02537',
                        'lng' => '105.85305'
                    ],
                    [
                        'name' => 'Mc Donald Trung Liệt',
                        'address' => '1 P. Thái Hà, Trung Liệt, Đống Đa, Hà Nội 100000, Việt Nam',
                        'lat' => '21.00921',
                        'lng' => '105.82374'
                    ]
                ]
            ]
        ];


        foreach($rewards as $reward) {
            $rewardCheck = Reward::whereSymbol($reward['symbol'])->first();
            if ($rewardCheck) { continue; }

            Reward::create([
                'name' => $reward['name'],
                'description' => "Description",
                'image' => $reward['img'],
                'symbol' => $reward['symbol'],
                'order' => random_int(1, 10),
                'status' => true
            ]);
        }

        print("Create task \n");

        foreach($datas as $data) {
            if (Task::find($data['id'])) {continue;}

            Task::create([
                'id' => $data['id'],
                'name' => $data['name'],
                'description' => $data['description'],
                'banner_url' => $data['banner_url'],
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(100),
                'order' => random_int(1, 100),
                'status' => true,
                'type' => 0,
                'creator_id' => '96be321e-296b-469e-bc2e-3f977c8bdf3a',
            ]);

            $checkin = TaskLocation::create([
                'task_id' => $data['id'],
                'reward_id' => Reward::inRandomOrder()->first()->id,
                'name' => $data['local_name'],
                'description' => $data['description'],
                'amount' => random_int(1, 100),
                'job_num' => 1,
                'order' => random_int(1, 100),
                'status' => true,
            ]);

            $rewardId = Reward::first()->id;
            $names = [
                'Accelerator Appchain Showcase Series #1',
                'It is the art of choosing specific words and sounds that will make the user reach the goal we want while fulfilling their task.',
                'Who is making dope music, has low cost editions available and is committed to community building?',
                'Drumroll please 🥁🥁 🥁... these are the 5 lucky winners who will be sharing a total prize of 500',
                'Thanks to these pros you can concentrate on the process of NFTs creation and growing your community. 🤝🎉',
                'Are you ready for the new month? But lets look over the previous one!',
                'Allowing users to farm AURORA tokens while demonstrating their solution in action 😎'
            ];

            $params = [
                'task_id' => $data['id'],
                'reward_id' => $rewardId,
                'name' => $names[array_rand($names, 1)],
                'description' => $data['description'],
                'url' => 'https://plats.network',
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

            foreach($data['locals'] as $local) {
                TaskLocationJob::create([
                    'task_location_id' => $checkin->id,
                    'name' => $local['name'],
                    'address' => $local['address'],
                    'lat' => $local['lat'],
                    'lng' => $local['lng'],
                    'status' => true,
                    'order' => random_int(1,100),
                ]);
            }

            for($i = 0; $i < 5; $i++) {
                TaskGallery::create([
                    'task_id' => $data['id'],
                    'url_image' => $data['banner_url'],
                    'status' => true
                ]);
            }
        }

        print("End Seed!");
    }
}
