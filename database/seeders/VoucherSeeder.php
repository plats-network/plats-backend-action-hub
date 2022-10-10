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

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
            'image' => 'https://i.imgur.com/UuCaWFA.png',
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
            DetailReward::create([
                'branch_id' => Branch::all()->random(1)->first()->id,
                'reward_id' => Reward::first()->id,
                'type' => random_int(0,3), // 0: token plats, 1: vouchers 30shine, 2: vouchers xem phim, 3: thẻ điện thoại...
                'name' => 'Name voucher '. random_int(0, 90000),
                'description' => 'description '. random_int(0, 90000),
                'url_image' => 'https://i.imgur.com/UuCaWFA.png',
                'qr_code' => substr(str_shuffle(str_repeat($pool, 5)), 0, 6),
                'status' => 1,
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDays(random_int(-2, 30))
            ]);
            
            $j = $j + 1;
        } while($j < 3000);

        $userIds = [
            "9602c7e7-9e83-49b6-b177-d035b8ad09ac",
            "9603470a-6a83-4d8b-9f11-3a8b415c4a25",
            "96034abc-5488-4be4-9fe8-1ef49167b636",
            "96034cd4-9f94-4daf-bcf2-80d17c4aac4c",
            "960ef6d0-1541-4a6e-8214-f9ae97b8a535",
            "9612c3ef-6993-43f5-b374-3b204fa469f9",
            "961b6b0e-e265-4380-a51e-3a639d0e8347",
            "961df0df-66ed-4853-bf39-fa7ac3abc1fc",
            "962108f6-28a0-45d0-839c-20149664f2f2",
            "96215e6f-0995-41fb-97b3-3406e06837c4",
            "962387d4-80d3-4f7f-b0fd-bf62255aab39",
            "96250758-ac1b-4bad-b899-6911f3aad4f2",
            "962d57ac-cc8b-4cab-a242-5fef55b0bc60",
            "962de229-ac5c-450c-bd4b-e6073e459a12",
            "962df080-329d-41a1-9bb8-3a377d63bd86",
            "963824b9-3139-4418-bf70-bd3d8e721423",
            "96393b4d-745a-4f3c-a92b-94e21e1224c1",
            "96397a15-ff88-4346-9e4e-e60f7968ee7a",
            "96399b39-4849-4035-bef9-0efa6dfe1aa7",
            "9639a010-5ef4-4889-b4c9-3a038a5d0fdc",
            "9639a121-5cfd-46a3-86cf-bf7f902aee75",
            "9639b1f5-40b8-4107-a272-7a701bcf15bc",
            "9639b621-4bf9-4afb-b5c5-24e575f1903e",
            "965139ff-d068-4936-9d67-0019bb1d9837",
            "96513eb6-d29f-4555-a86e-f10dc999e4fb",
            "96514baa-8eac-4804-b27b-fccbbd399072",
            "965158f1-7252-4ef7-885c-07f0f9db89b4",
            "965321d2-cf09-4b3d-8080-b003759a4f3e",
            "96537b62-6fc1-4c39-a231-7afe43b6b7ee",
            "96607b23-7390-4f76-9ac4-4bfe67b25230",
            "966a8725-5dfb-4007-ad9e-d96a55c81adc",
            "9671d60d-d747-4c74-9fbf-303657964160",
            "9672acd8-2e09-4544-86de-d8f0915449f7",
            "9673cd3a-dfa1-431d-9693-3a805fd065b5",
            "9673dad1-7436-4136-8734-5c2328a040fb",
            "9673db2b-573a-4f48-b329-08cf06557b70",
            "967b44d0-f698-4dff-b537-57776326ebd7",
            "9685d408-331b-4c40-af3c-a560f748b4a2",
            "96ba2550-03ac-4e60-ba1b-99e0827c5426",
            "96babad6-e38b-438d-b23c-d804722033e3",
            "96bc7e2b-4e52-4430-818d-e6933e057ee3",
            "96be31fb-804e-4660-a031-e3ed294bc8f3",
            "96be320e-f1fd-4745-bb0b-98a67b175a65",
            "96be321e-296b-469e-bc2e-3f977c8bdf3a",
            "96be3232-38b6-4591-82ea-1dd528824bc1",
            "96be323f-3eb6-4b40-89f6-b32856c93055",
            "96be324c-da79-4de4-93e4-ed451d796229",
            "96ebfa8e-881d-4985-aea3-8423a909a95b",
            "96ec0623-3499-4b9e-b4e9-662252dda8a6",
            "96ec997a-85ba-4d18-ab05-9996006d59c2",
            "96ed082b-3bdf-4d56-840f-cee5f6b756c9",
            "96f283de-990d-46e6-b648-9c5932d4cc8c",
            "96f2a954-26e4-4b24-8ffd-a2610f1b21e0",
            "96f31677-77da-471a-8299-26f47c52a2bf",
            "96f329b9-4a5d-4a3e-baa6-ef5b1c1685ea",
            "96f819bc-f217-441b-8029-17d2ad64d97e",
            "96f824b7-e168-4549-b312-b6d59d7f5a85",
            "96fcc039-11a0-4289-9cc3-73e6bc8b0e33",
            "96fd36db-dcd3-4459-8b8f-4b79bfe88ba7",
            "96febf98-c90e-41c7-b6c5-62a6ec259b59",
            "96fec059-c0c2-4a60-a6ea-5755212ee679",
            "96fec37e-e1f4-4ef1-a3bf-7d3edf1e7fa3",
            "96fec3db-c5dd-4cb9-a208-9b19484489bd",
            "96fec3f9-fdfd-4645-ae3c-056bcb26cd08",
            "96fec411-3d53-4a87-92bd-495f40192a58",
            "96fec43d-af2d-4152-88b1-0c369d6d6c3b",
            "96fec4a8-591b-4fb2-b521-54f88a34ba39",
            "96fec511-a485-498f-b425-cae4e77de924",
            "96fec52d-10df-4a23-868d-c6677c311a87",
            "96fec564-6068-412e-a511-c2fac56c5661",
            "96fec57e-e1ce-45ed-879c-bd71c0c63356",
            "96fec5b5-d024-442d-b860-97ca7615848b",
            "96fec5ce-f3e2-4b96-a0c5-73ebd70e2039",
            "96fec5eb-8e5a-45f7-90d6-97e8cf7d52a5",
            "96fec634-327e-4536-ba03-852ce4be3e1b",
            "9700c383-c802-4d80-9e8a-281bd5c04eb6",
            "9700c3a0-1179-4298-844f-f4e703fccaf7",
            "97011df5-f47e-42d3-8ac4-194b7d25d104",
            "97011e11-21d0-4bdd-a977-2d84b0441be5",
            "97076463-f7d5-4dc9-beb2-e863c0035efd",
            "9707646a-c025-412c-9101-890f81c3b5e6",
            "97076472-1ed1-451d-b566-1d5412132427",
            "970c6f1e-3cd2-4164-a6bf-777bd4fe45e6",
            "970c87f3-2223-4483-b081-a14777adf996",
            "97104c45-45d5-49db-a061-c0aa9e9c77b2",
            "97166388-36d3-490a-8215-5b9e7c6b8161",
            "971673ae-2734-45e2-9248-8c3a7082f3b9",
            "97167c26-f790-4fbb-b460-7c44c41455bf",
            "97174f3b-cafe-47c8-b69b-057b24762b6f",
            "971cd592-11d1-4a93-b869-a61fbfe485fb",
            "971d659e-962d-473a-9b84-47fbc5dcf2a6",
            "971d6cbe-b157-4a15-a96c-c9d59fed3e72",
            "971d6dcd-2c77-45a9-bf29-fd3db838cf16",
            "9769ce83-14ad-4c00-a2c1-3d62f82e95b8",
            "9769d052-63ce-4ce9-88ee-5b77c00ac750",
            "9769d241-3a27-4bd4-aeef-895eb8485bf5",
            "9769e2ca-e80d-4fc8-bd30-4b834875e140",
            "9769e311-dd59-4e02-bd14-14f9b130376d",
            "976aff4a-af45-409e-9907-84b86fe09e12",
            "976b0e96-36ae-43c7-8d76-4115f4ed2301",
            "976b2969-394e-460c-aec9-7a675b81df38",
            "976b335a-8987-4e6e-b5aa-56502117d8b6",
            "976bc17e-be51-4624-8400-53cb315b4ec4",
            "976bc1c6-08c6-4f79-92f5-58c109549656",
            "976bc708-fec7-4c85-bc6e-c2e74eb03f10",
            "976bc8e2-3698-4b3f-9a7d-43ffc98530ae",
            "976bc9a2-3e0a-414f-bbb0-5b53fc69be08",
            "976f23d9-79fb-49ce-89fe-e61410d5f7b1",
            "976f2577-2ac8-4755-956a-092ef4674ee3",
            "976f8252-c42d-44df-b88a-cdad61fb325a",
            "976f82c4-aa97-4556-bcf4-17aea6ab0d37",
            "976fb097-d7d3-440b-a5ce-2c337138b9d6",
            "976fb28a-07c6-494f-866e-40f4807dc201",
            "976fb71f-dd33-43f2-bb86-c34315a57209"
        ];
        print "6. Tạo UserTaskReward \n";
        print "6.1 Total user: ".count($userIds)."\n";

        foreach(array_unique($userIds) as $userId) {
            $k = 0;
            do {
                $detail_reward_id = null;
                $a = 0;
                while(true) {
                    $id = DetailReward::all()->random(1)->first()->id;
                    $utr = UserTaskReward::where('detail_reward_id', $id)->first();

                    if (!$utr) {
                        $detail_reward_id = $id;
                        break;
                    }

                    $a = $a + 1;
                }
                if ($detail_reward_id == null && $a == 50) {
                    break;
                }
                $irand = random_int(0,1) == 0 ? 2  : 3;
                UserTaskReward::create([
                    'user_id' => $userId,
                    'detail_reward_id' => $detail_reward_id,
                    'type' => $irand // 0: tokens, 1: NFTs, 2: Vouchers, 3: boxs, 4: Wallet
                ]);

                $k = $k + 1;
            } while($k < 10);

            $aa = UserTaskReward::where('user_id', $userId)->count();
            print "\nTotal UserTaskReward: ".$aa;
            print "\n6.2 Process user id: ". $userId;
        }

        print "\n7. End seed!";
    }
}
