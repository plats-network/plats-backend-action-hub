<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Http};
use Carbon\Carbon;
use App\Models\{
    TaskUser,
    Company,
    Branch,
    Reward,
    DetailReward,
    UserTaskReward,
    CodeVoucher
};

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

        print "1. Xoa du lieu cac bang\n";
        DB::table('companies')->delete();
        DB::table('branches')->delete();
        DB::table('rewards')->delete();
        DB::table('detail_rewards')->delete();
        DB::table('user_task_rewards')->delete();

        // $userIds =  TaskUser::pluck('user_id')->toArray();
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        print "==========> Tạo Reward \n";
        Reward::create([
            'name' => 'My box',
            'description' => 'Desc my box',
            'image' => 'icon/hidden_box.png',
            'type' => 0,
            'region' => 0,
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addDays(100)
        ]);

        // Create company
        print "==========> Tạo company\n";
        $companies = [
            [
                "id" => "64fb16a9-c635-4b9a-99dc-a9538c966cce",
                "name" => "30Shine",
                "logo_path" => "icon/30shine.png",
                "address" => "Hanoi",
                "phone" => "093242423423",
                "hotline" => "9029304234"
            ],
            [
                "id" => "490af31d-e5c4-4844-a065-42c72f165cc5",
                "name" => "Cộng caffe",
                "logo_path" => "icon/cong_caffe.png",
                "address" => "Hanoi",
                "phone" => "09".random_int(100,999) ."9893",
                "hotline" => "09".random_int(100,999) ."9893"
            ],
            [
                "id" => "a1346f6c-8b36-4232-8bdd-b7ed8ad8473c",
                "name" => "Achicklet",
                "logo_path" => "icon/achicklet.png",
                "address" => "Hanoi",
                "phone" => "09".random_int(100,999) ."9893",
                "hotline" => "09".random_int(100,999) ."9893"
            ],
            [
                "id" => "d4572f39-f2c9-4421-b293-73f2a2ff4c12",
                "name" => "Ốc điếc sài gòn",
                "logo_path" => "icon/oc.jpeg",
                "address" => "Hanoi",
                "phone" => "09".random_int(100,999) ."9893",
                "hotline" => "09".random_int(100,999) ."9893"
            ],
            [
                "id" => "329c270e-14ae-4174-bec9-acf641e39ab9",
                "name" => "Thẻ điện toại",
                "logo_path" => "icon/card_mobile.png",
                "address" => "Hanoi",
                "phone" => "09".random_int(100,999) ."9893",
                "hotline" => "09".random_int(100,999) ."9893"
            ],
            [
                "id" => "81005390-60b8-431e-bd02-b00a5c58407d",
                "name" => "W3 - Token - NFTs",
                "logo_path" => "icon/card_mobile.png",
                "address" => "Hanoi",
                "phone" => "09".random_int(100,999) ."9893",
                "hotline" => "09".random_int(100,999) ."9893"
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }

        // Create branch
        print "==========> Tạo Branch \n";
        foreach(Company::all() as $company) {
            Branch::create([
                "company_id" => $company->id,
                "name"  => "Branch name - " . $company->name,
                "address" => "Address " . random_int(1,111),
                "phone" => "09". random_int(100, 999). "43423",
                "hotline" => random_int(0, 9)."23409024",
                "open_time" => "08:00",
                "close_time" => "22:00",
                "work_today" => "Thứ 2 - Chủ nhật"
            ]);
        }

        // DetailReward
        print "=========> Tạo DetailReward \n";
        $j = 0;
        do {
            $names = [
                'Data test - Tưng bừng mua 3 tặng 1 tại 30shine store',
                'Data test - Giảm 50% cho hoá đơn mua mang về',
                'Data test - Mua 3 sản phẩm freeship',
                'Data test - Giảm 50% hoá đơn cho mọi dịch vụ tại salon',
                'Data test - Giảm 50% cho hoá đơn mua mang về'
            ];

            $logoss = [
                'icon/30shine.png',
                'icon/achicklet.png',
                'icon/cong_caffe.png',
                'icon/oc.jpeg',
            ];

            $type = random_int(0, 2);
            $name = $type == 0 ? 'Token name' . random_int(0, 1000) : ($type == 1 ? 'NFTs ' . random_int(0, 1000) : $names[array_rand($names, 1)]);
            $desc = $type == 0 ? 'Token desc' . random_int(0, 1000) : ($type == 1 ? 'NFTs desc '. random_int(0, 1000) : 'Vouchers desc ' . random_int(0, 1000));
            $qr_code = $type == 2 ? substr(str_shuffle(str_repeat($pool, 5)), 0, 6) : null;
            $amount = $type == 0 ? random_int(100, 200) : ($type == 1 ? 1 : null);

            if ($type == 0 || $type == 1) {
                $branch = Branch::whereCompanyId('81005390-60b8-431e-bd02-b00a5c58407d')->first();
            } elseif ($type == 2) {
                $branch = Branch::whereCompanyId('64fb16a9-c635-4b9a-99dc-a9538c966cce')->first();
            }

            DetailReward::create([
                'branch_id' => $branch->id,
                'reward_id' => Reward::first()->id,
                'type' => $type, // 0: token, 1: NFTs, 2: vouchers
                'name' => $name,
                'description' => $desc,
                'url_image' => $logoss[array_rand($logoss, 1)],
                'qr_code' => $qr_code,
                'amount' => $amount,
                'status' => 1,
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(random_int(-10, 10))
            ]);
            
            $j = $j + 1;
        } while($j < 10000);

        $b = $branch = Branch::whereCompanyId('329c270e-14ae-4174-bec9-acf641e39ab9')->first();
        DetailReward::create([
            'branch_id' => $b->id,
            'reward_id' => Reward::first()->id,
            'type' => 3, // 0: token, 1: NFTs, 2: vouchers, 3: card mobile
            'name' => 'Thẻ cào 500K',
            'description' => 'Thẻ cào 500K',
            'url_image' => 'icon/card_mobile.png',
            'amount' => 500000,
            'status' => 1,
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addDays(random_int(-10, 10))
        ]);

        for($i = 0; $i < 3; $i ++) {
            DetailReward::create([
                'branch_id' => $b->id,
                'reward_id' => Reward::first()->id,
                'type' => 3, // 0: token, 1: NFTs, 2: vouchers, 3: card mobile
                'name' => 'Thẻ cào 200K',
                'description' => 'Thẻ cào 200K',
                'url_image' => 'icon/card_mobile.png',
                'amount' => 200000,
                'status' => 1,
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(random_int(-10, 10))
            ]);
        }

        for($i = 0; $i < 5; $i ++) {
            DetailReward::create([
                'branch_id' => $b->id,
                'reward_id' => Reward::first()->id,
                'type' => 3, // 0: token, 1: NFTs, 2: vouchers, 3: card mobile
                'name' => 'Thẻ cào 100K',
                'description' => 'Thẻ cào 100K',
                'url_image' => 'icon/card_mobile.png',
                'amount' => 100000,
                'status' => 1,
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(random_int(-10, 10))
            ]);
        }

        for($i = 0; $i < 10; $i ++) {
            DetailReward::create([
                'branch_id' => $b->id,
                'reward_id' => Reward::first()->id,
                'type' => 3, // 0: token, 1: NFTs, 2: vouchers, 3: card mobile
                'name' => 'Thẻ cào 50K',
                'description' => 'Thẻ cào 50K',
                'url_image' => 'icon/card_mobile.png',
                'amount' => 50000,
                'status' => 1,
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(random_int(-10, 10))
            ]);
        }

        for($i = 0; $i < 30; $i ++) {
            DetailReward::create([
                'branch_id' => $b->id,
                'reward_id' => Reward::first()->id,
                'type' => 3, // 0: token, 1: NFTs, 2: vouchers, 3: card mobile
                'name' => 'Thẻ cào 20K',
                'description' => 'Thẻ cào 20K',
                'url_image' => 'icon/card_mobile.png',
                'amount' => 20000,
                'status' => 1,
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(random_int(-10, 10))
            ]);
        }

        for($i = 0; $i < 50; $i ++) {
            DetailReward::create([
                'branch_id' => $b->id,
                'reward_id' => Reward::first()->id,
                'type' => 3, // 0: token, 1: NFTs, 2: vouchers, 3: card mobile
                'name' => 'Thẻ cào 10K',
                'description' => 'Thẻ cào 10K',
                'url_image' => 'icon/card_mobile.png',
                'amount' => 10000,
                'status' => 1,
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(random_int(-10, 10))
            ]);
        }

        print "==========> Tạo UserTaskReward \n";
        $vochers = DetailReward::all();
        foreach($vochers as $item) {
            $is_tray = $item->end_at <= Carbon::now() ? true : false;
            $is_tray = random_int(0, 1);
            $utr = UserTaskReward::where('detail_reward_id', $item->id)->first();
            if ($utr) { continue; }

            $userId = $datas[array_rand($datas, 1)];
            UserTaskReward::create([
                'user_id' => $userId,
                'detail_reward_id' => $item->id,
                'type' => $item->type, // 0: tokens, 1: NFTs, 2: Vouchers, 3: Card mobile
                'is_tray' => $is_tray
            ]);
        }

        print "=========> End seed!";
    }
}
