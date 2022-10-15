<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{
    TaskUser,
    Company,
    Branch,
    Reward,
    DetailReward,
    UserTaskReward
};
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $res = Http::get(config('app.api_user_url') . '/api/test_user');
        $content = $res->getBody()->getContents();
        $datas = json_decode($content)->data;

        $logos = [
            'https://30shine.com/static/media/log-30shine-white.9945e644.jpg',
            'https://i.imgur.com/UuCaWFA.png',
            'https://global.toyota/pages/global_toyota/mobility/toyota-brand/emblem_001.jpg',
            'https://www.highlandscoffee.com.vn/vnt_upload/weblink/1200px-Highlands_Coffee_logo.svg.png',
            'https://tocotocotea.com/wp-content/uploads/2021/04/Logo-ngang-01.png'
        ];

        print "1. Xoa du lieu cac bang\n";
        DB::table('companies')->delete();
        DB::table('branches')->delete();
        DB::table('rewards')->delete();
        DB::table('detail_rewards')->delete();
        DB::table('user_task_rewards')->delete();

        // $userIds =  TaskUser::pluck('user_id')->toArray();
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // Create company
        print "2. Tạo company\n";
        $companies = [
            [
                "name" => "Highlands Coffee",
                "logo_path" => "https://upload.wikimedia.org/wikipedia/vi/thumb/c/c9/Highlands_Coffee_logo.svg/1200px-Highlands_Coffee_logo.svg.png",
                "address" => "Hanoi",
                "phone" => "093242423423",
                "hotline" => "9029304234"
            ],
            [
                "name" => "Toyota Vietnam",
                "logo_path" => "https://global.toyota/pages/global_toyota/mobility/toyota-brand/emblem_ogp_001.png",
                "address" => "Hanoi",
                "phone" => "09".random_int(100,999) ."9893",
                "hotline" => "09".random_int(100,999) ."9893"
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }

        print "3. Tạo Reward \n";
        Reward::create([
            'name' => 'My box',
            'description' => 'Desc my box',
            'image' => $logos[array_rand($logos, 1)],
            'type' => 0,
            'region' => 0,
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addDays(random_int(10, 20))
        ]);

        // Create branch
        print "4. Tạo Branch \n";
        foreach(Company::all() as $company) {
            $i = 0;

            do {
                Branch::create([
                    "company_id" => $company->id,
                    "name"  => "Branch name - " . $company->name . " - " .$i,
                    "address" => "Address ". $i,
                    "phone" => "0".$i."093043423",
                    "hotline" => random_int(0, 9)."23409024",
                    "open_time" => "08:00",
                    "close_time" => "22:00",
                    "work_today" => "Thứ 2 - Chủ nhật"
                ]);

                $i = $i + 1;
            } while ($i < 10);
        }

        // DetailReward
        print "5. Tạo DetailReward \n";
        $j = 0;


        do {
            $names = [
                'Data test - Tưng bừng mua 3 tặng 1 tại 30shine store',
                'Data test - Giảm 50% cho hoá đơn mua mang về',
                'Data test - Mua 3 sản phẩm freeship',
                'Data test - Giảm 50% hoá đơn cho mọi dịch vụ tại salon',
                'Data test - Giảm 50% cho hoá đơn mua mang về'
            ];

            $type = random_int(0,1);
            $name = $type == 0 ? 'Open the box now!' : $names[array_rand($names, 1)];
            $desc = $type == 0 ? 'Mô tả box '. $i : "Mô tả vouchers" . $i;
            $qr_code = $type == 0 ? null : substr(str_shuffle(str_repeat($pool, 5)), 0, 6);
            $amount = $type == 0 ? random_int(100, 200) : null;

            DetailReward::create([
                'branch_id' => Branch::all()->random(1)->first()->id,
                'reward_id' => Reward::first()->id,
                'type' => $type, // 0: token plats, 1: vouchers 30shine, 2: vouchers xem phim, 3: thẻ điện thoại...
                'name' => $name,
                'description' => $desc,
                'url_image' => $logos[array_rand($logos, 1)],
                'qr_code' => $qr_code,
                'amount' => $amount,
                'status' => 1,
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(random_int(-10, 20))
            ]);
            
            $j = $j + 1;
        } while($j < 10000);

        print "6. Tạo UserTaskReward \n";
        $vochers = DetailReward::all();
        foreach($vochers as $item) {
            $utr = UserTaskReward::where('detail_reward_id', $item->id)->first();
            if ($utr) { continue; }

            $userId = $datas[array_rand($datas, 1)];
            $type = $item->type == 0 ? 3 : 2;

            UserTaskReward::create([
                'user_id' => $userId,
                'detail_reward_id' => $item->id,
                'type' => $type // 0: tokens, 1: NFTs, 2: Vouchers, 3: boxs, 4: Wallet
            ]);
        }

        print "\n7. End seed!";
    }
}
