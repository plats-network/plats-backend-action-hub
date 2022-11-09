<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Company, Branch};

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        print "==========> Tạo company\n";
        $companies = [
            [
                "id" => "64fb16a9-c635-4b9a-99dc-a9538c966cce",
                "name" => "CÔNG TY CỔ PHẦN TMDV 30SHINE",
                "logo_path" => "icon/30shine.png",
                "address" => "82 Trần Đại Nghĩa, P. Đồng Tâm, Q. Hai Bà Trưng, Hà Nội"
            ],
            [
                "id" => "490af31d-e5c4-4844-a065-42c72f165cc5",
                "name" => "Công ty TNHH Cộng Cà Phê",
                "logo_path" => "icon/cong_caffe.png",
                "address" => "Số 101 Hoàng Cầu, phường Ô Chợ Dừa, quận Đống Đa, Hà Nội"
            ],
            [
                "id" => "a1346f6c-8b36-4232-8bdd-b7ed8ad8473c",
                "name" => "Achicklet",
                "logo_path" => "icon/achicklet.png",
                "address" => "62A phố Yên Phụ, Tây Hồ, Hà Nội"
            ],
            [
                "id" => "d4572f39-f2c9-4421-b293-73f2a2ff4c12",
                "name" => "Ốc Điếc Sài Gòn",
                "logo_path" => "icon/oc.jpeg",
                "address" => "72 Ng. 8 Đ. Lê Quang Đạo, Mễ Trì, Từ Liêm, Hà Nội"
            ],
            [
                "id" => "245ff0af-a90a-4ea3-8351-5790e146cc6a",
                "name" => "Highlands Coffee",
                "logo_path" => "icon/Highlands_Coffee.png",
                "address" => "TTC Building, 19 P. Duy Tân, Dịch Vọng Hậu, Cầu Giấy, Hà Nội"
            ],
            [
                "id" => "edccdebd-9485-426a-988e-5400e1ae838a",
                "name" => "McDonalds Việt Nam",
                "logo_path" => "icon/mcds.png",
                "address" => "2-6 Bis Điện Biên Phủ, P.Đa Kao, Quận 1, Tp Hồ Chí Minh"
            ],
            [
                "id" => "329c270e-14ae-4174-bec9-acf641e39ab9",
                "name" => "Thẻ điện toại",
                "logo_path" => "icon/card_mobile.png",
                "address" => "Hà Nội, Việt Nam"
            ],
            [
                "id" => "81005390-60b8-431e-bd02-b00a5c58407d",
                "name" => "W3 - Token - NFTs",
                "logo_path" => "icon/token-nft.png",
                "address" => "Hà Nội, Việt Nam"
            ],
        ];

        foreach ($companies as $company) {
            $com = Company::firstOrNew(['id' => $company['id']]);
            $com->name = $company['name'];
            $com->logo_path = $company['logo_path'];
            $com->address = $company['address'];
            $com->save();

            $br = Branch::firstOrNew(['company_id' => $company['id']]);
            $br->name = $company['name'];
            $br->address = $company['address'];
            $br->phone = "0909". random_int(100000, 999999);
            $br->open_time = "08:00";
            $br->close_time = "21:00";
            $br->work_today = "Thứ 2 - Chủ nhật";
            $br->save();
        }
    }
}
