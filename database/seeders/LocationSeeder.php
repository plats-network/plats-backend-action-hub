<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{TaskLocation, Task};

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        printf("=======> Create Location \n");
        // 'id' => 'ea5392d5-261d-49b7-909a-7bcdb9f74eb2',
        // 'name' => '30 Shine Hà Nội'
        $l1 = [
            ['name' => 'Salon 163 Hàng Bông', 'addr' => '163 P. Hàng Bông, Hàng Bông, Hoàn Kiếm, Hà Nội', 'lat' => '21.02927913', 'lng' => '105.8452339'],
            ['name' => 'Salon 82 Trần Đại Nghĩa, p. Đồng Tâm', 'addr' => '82 P. Trần Đại Nghĩa, Đồng Tâm, Hai Bà Trưng, Hà Nội', 'lat' => '21.00023575', 'lng' => '105.8451843'],
            ['name' => 'Salon 12 Lạc Trung, P. Thanh Lương', 'addr' => '12 P. Lạc Trung, Thanh Lương, Hai Bà Trưng, Hà Nội', 'lat' => '21.00337674', 'lng' => '105.8618058'],
            ['name' => 'Salon 391 Trương Định, P. Tân Mai', 'addr' => '391 Trương Định, Tân Mai, Hoàng Mai, Hà Nội ', 'lat' => '20.96572476', 'lng' => '105.823963'],
            ['name' => 'Salon 50BT4 X2 Nguyễn Phan Chánh', 'addr' => '50BT4 X2, Phố Nguyễn Phan Chánh, Bắc Linh Đàm Hoàng Mai Hanoi City', 'lat' => '20.96573478', 'lng' => '105.8239201'],
            ['name' => 'Salon 346 Khâm Thiên', 'addr' => '346 P. Khâm Thiên, Thổ Quan, Đống Đa, Hà Nội', 'lat' => '21.01979857', 'lng' => '105.8323208'],
            ['name' => 'Salon 702 Đường Láng', 'addr' => '702 Đ. Láng, Láng Thượng, Đống Đa, Hà Nội ', 'lat' => '21.01647904', 'lng' => '105.8042728'],
            ['name' => 'Salon 235 Đội Cấn', 'addr' => '235 Đội Cấn, Ngọc Hồ, Ba Đình, Hà Nội', 'lat' => '21.03533041', 'lng' => '105.8216516'],
            ['name' => 'Salon 151 Cầu Giấy', 'addr' => '151 Đ. Cầu Giấy, Quan Hoa, Cầu Giấy, Hà Nội', 'lat' => '21.03243917', 'lng' => '105.7989292'],
            ['name' => 'Salon 109 Trần Quốc Hoàn', 'addr' => '109 P. Trần Quốc Hoàn, Dịch Vọng Hậu, Cầu Giấy, Hà Nội', 'lat' => '21.04150582', 'lng' => '105.7859013'],
            ['name' => 'Salon 111 Lạc Long Quân, P. Nghĩa Đô', 'addr' => '111 Đ. Lạc Long Quân, Nghĩa Đô, Cầu Giấy, Hà Nội', 'lat' => '21.05163535', 'lng' => '105.8080282'],
            ['name' => 'Salon 382 Nguyễn Trãi, P. Thanh Xuân Trung', 'addr' => '382 Nguyễn Trãi, Thanh Xuân Trung, Thanh Xuân, Hà Nội', 'lat' => '20.99397537', 'lng' => '105.8060194'],
            ['name' => 'Salon 407 Trường Chinh, P. Khương Trung', 'addr' => '407 Đ. Trường Chinh, Ngã Tư Sở, Thanh Xuân, Hà Nội', 'lat' => '21.00260791', 'lng' => '105.8205044'],
            ['name' => 'Salon 56 Nguyễn Huy Tưởng, P. TX Trung', 'addr' => '56 Nguyễn Huy Tưởng, Thanh Xuân Trung, Thanh Xuân, Hà Nội ', 'lat' => '20.99918842', 'lng' => '105.8068229'],
            ['name' => 'Salon 168 Nguyễn Văn Cừ', 'addr' => '168 Đ. Nguyễn Văn Cừ, Ngọc Lâm, Long Biên, Hà Nội ', 'lat' => '21.043236', 'lng' => '105.8716885'],
            ['name' => 'Salon 175 Phùng Hưng, P. Phúc La', 'addr' => '175 Đ. Phùng Hưng, P. Phúc La, Hà Đông, Hà Nội ', 'lat' => '20.96885519', 'lng' => '105.7857739'],
            ['name' => 'Salon 10 Trần Phú, P. Mộ Lao', 'addr' => 'Số 10 Trần Phú, P. Mộ Lao, Hà Đông, Hà Nội', 'lat' => '20.98372785', 'lng' => '105.7913736'],
        ];

        // 'id' => '2d7558aa-89b2-4727-a390-2d7eda56bcba',
        // 'name' => '30 Shine HCM'
        $l2 = [
            ['name' => 'Salon 103 Trần Não, P. Bình An', 'addr' => '103 Trần Não, P. Bình An, Quận 2, Thành phố Hồ Chí Minh', 'lat' => '10.79375919', 'lng' => '106.7309412'],
            ['name' => 'Salon 149 Nguyễn Duy Trinh, P. Bình Trưng Tây', 'addr' => '149 Đ. Nguyễn Duy Trinh, Phường Bình Trưng Tây, Quận 2, Thành phố Hồ Chí Minh', 'lat' => '10.78806927', 'lng' => '106.7598459'],
            ['name' => 'Salon 25 Tôn Đản, Phường 13', 'addr' => '25 Tôn Đản Phường 13 Quận 4 Thành phố Hồ Chí Minh', 'lat' => '10.76119789', 'lng' => '106.7076855'],
            ['name' => 'Salon 8 Châu Văn Liêm, Phường 10', 'addr' => '08 Châu Văn Liêm Phường 10 Quận 5 Thành phố Hồ Chí Minh', 'lat' => '10.75134007', 'lng' => '106.659283'],
            ['name' => 'Salon 955 Trần Hưng Đạo, Phường 1', 'addr' => '955 Trần Hưng Đạo, Phường 1, Quận 5, Thành phố Hồ Chí Minh', 'lat' => '10.75407967', 'lng' => '106.6770987'],
            ['name' => 'Salon 927 Hậu Giang, Phường 11', 'addr' => '909 Đ. Hậu Giang, Phường 11, Quận 6, Thành phố Hồ Chí Minh', 'lat' => '10.74542133', 'lng' => '106.6273204'],
            ['name' => 'Salon 330 Nguyễn Thị Thập, P. Tân Quy', 'addr' => '330 Nguyễn Thị Thập, Tân Quy, Quận 7, Thành phố Hồ Chí Minh', 'lat' => '10.73861166', 'lng' => '106.713013'],
            ['name' => 'Salon 420 Huỳnh Tấn Phát, P. Bình Thuận', 'addr' => '420 Huỳnh Tấn Phát, Bình Thuận, Quận 7, Thành phố Hồ Chí Minh', 'lat' => '10.74608545', 'lng' => '106.7289611'],
            ['name' => 'Salon 237 Nguyễn Thị Thập, P. Tân Phú', 'addr' => '237 Nguyễn Thị Thập Phường Tân Phú Quận 7 Thành phố Hồ Chí Minh', 'lat' => '10.73829711', 'lng' => '106.7175151'],
            ['name' => '236 Dương Bá Trạc, Phường 2', 'addr' => '236 Dương Bá Trạc, Phường 1, Quận 8, TPHCM', 'lat' => '10.7460658', 'lng' => '106.6890678'],
            ['name' => 'Salon 356 Đỗ Xuân Hợp', 'addr' => '356 Đỗ Xuân Hợp, Phước Long B, Quận 9, Thành phố Hồ Chí Minh', 'lat' => '10.82235086', 'lng' => '106.7711222'],
            ['name' => 'Salon 194 Lê Văn Việt, P. Tăng Nhơn Phú B', 'addr' => '194 Đ. Lê Văn Việt, Tăng Nhơn Phú B, Quận 9, Thành phố Hồ Chí Minh', 'lat' => '10.84391233', 'lng' => '106.7825801'],
            ['name' => 'Salon 300 Đường 3/2, Phường 12', 'addr' => 'TP, 300 Đ. 3/2, Phường 12, Quận 10, Thành phố Hồ Chí Minh', 'lat' => '10.77027744', 'lng' => '106.6713852'],
            ['name' => 'Salon 193 Tô Hiến Thành, Phường 13', 'addr' => '193 Tô Hiến Thành, Phường 13, Quận 10, Thành phố Hồ Chí Minh', 'lat' => '10.7800234', 'lng' => '106.6681925'],
            ['name' => 'Salon 405A Lê Đại Hành, Phường 11', 'addr' => '405A Đ. Lê Đại Hành, Phường 11, Quận 11, Thành phố Hồ Chí Minh', 'lat' => '10.76741038', 'lng' => '106.6531478'],
            ['name' => 'Salon 8 Nguyễn Ảnh Thủ, P. Hiệp Thành', 'addr' => 'số 8 Đ. Nguyễn Ảnh Thủ, Hiệp Thành, Quận 12, Thành phố Hồ Chí Minh', 'lat' => '10.87651314', 'lng' => '106.6460307'],
            ['name' => 'Salon 36 Nguyễn Ảnh Thủ, P. Trung Mỹ Tây', 'addr' => '36 Đ. Nguyễn Ảnh Thủ, Trung Mỹ Tây, Quận 12, Thành phố Hồ Chí Minh', 'lat' => '10.86497707', 'lng' => '106.61375'],
            ['name' => 'Salon 76 Phan Văn Hớn, P. Tân Thới Nhất', 'addr' => '76 Phan Văn Hớn, Tân Thới Nhất, Quận 12, Thành phố Hồ Chí Minh', 'lat' => '10.82827902', 'lng' => '106.6216992'],
            ['name' => 'Salon 130 Tân Sơn Nhì, P. Tân Sơn Nhì', 'addr' => '130 Tân Sơn Nhì Phường Tân Sơn Nhì Quận Tân Phú Thành phố Hồ Chí Minh', 'lat' => '10.80203456', 'lng' => '106.6339128'],
            ['name' => 'Salon 189 Hòa Bình, P. Hiệp Tân', 'addr' => '189 Hòa Bình, Hiệp Tân, Tân Phú, Thành phố Hồ Chí Minh', 'lat' => '10.77141123', 'lng' => '106.628238'],
            ['name' => 'Salon 99 Tân Sơn Nhì, P. Tân Sơn Nhì', 'addr' => '99, Tân Sơn Nhì, Tân Phú, Thành phố Hồ Chí Minh', 'lat' => '10.80201525', 'lng' => '106.6339031'],
            ['name' => 'Salon 12 Lê Đức Thọ, Phường 7', 'addr' => '12 Lê Đức Thọ, Phường 7, Gò Vấp, Thành phố Hồ Chí Minh', 'lat' => '10.83098027', 'lng' => '106.6824323'],
            ['name' => 'Salon 1180 Quang Trung, Phường 8', 'addr' => '1180 Quang Trung Phường 8 Quận Gò Vấp Thành phố Hồ Chí Minh', 'lat' => '10.84451522', 'lng' => '106.6433221'],
            ['name' => 'Salon 483 Thống Nhất, Phường 16', 'addr' => '483 Thống Nhất, Phường 16, Gò Vấp, Thành phố Hồ Chí Minh', 'lat' => '10.84626137', 'lng' => '106.6647974'],
            ['name' => 'Salon 168 Đặng Văn Bi, P. Bình Thọ', 'addr' => '168 Đặng Văn Bi Phường Bình Thọ Thành phố Thủ Đức Thành phố Hồ Chí Minh', 'lat' => '10.84731304', 'lng' => '106.7606336'],
            ['name' => 'Salon 1172 Kha Vạn Cân , KP1, P. Linh Chiểu', 'addr' => '1172 Đ. Kha Vạn Cân, KP1, Thủ Đức, Thành phố Hồ Chí Minh', 'lat' => '10.86026575', 'lng' => '106.7604501'],
            ['name' => 'Salon 29 Hiệp Bình, P. Hiệp Bình Chánh', 'addr' => '29 Đ. Hiệp Bình, Hiệp Bình Chánh, Thủ Đức, Thành phố Hồ Chí Minh', 'lat' => '10.8420533', 'lng' => '106.7311981'],
            ['name' => 'Salon 323 Xô Viết Nghệ Tĩnh, Phường 25', 'addr' => '323 Xô Viết Nghệ Tĩnh Phường 25 Quận Bình Thạnh Thành phố Hồ Chí Minh', 'lat' => '11.80342643', 'lng' => '107.7112336'],
            ['name' => 'Salon 449 Bạch Đằng, Phường 2', 'addr' => '449 Bạch Đằng Phường 2 Quận Bình Thạnh Thành phố Hồ Chí Minh', 'lat' => '10.81584088', 'lng' => '106.6695832'],
            ['name' => 'Salon 359 Lê Quang Định, Phường 5', 'addr' => '359 Lê Quang Định, Phường 5, Bình Thạnh, Thành phố Hồ Chí Minh', 'lat' => '10.8127008', 'lng' => '106.6899741'],
            ['name' => 'Salon 708 Lê Trọng Tấn, P. Bình Hưng Hòa', 'addr' => '708 Lê Trọng Tấn, Bình Hưng Hoà, Bình Tân, Thành phố Hồ Chí Minh', 'lat' => '10.81525333', 'lng' => '106.6047894'],
            ['name' => 'Salon 730 Tỉnh lộ 10, P. Bình Trị Đông A', 'addr' => '730 TL10, Bình Trị Đông, Bình Tân, Thành phố Hồ Chí Minh', 'lat' => '10.75854404', 'lng' => '106.6116691'],
            ['name' => 'Salon 758 Âu Cơ, Phường 14', 'addr' => '758 Âu Cơ, Phường 14, Tân Bình, Thành phố Hồ Chí Minh', 'lat' => '10.78949501', 'lng' => '106.6405919'],
            ['name' => 'Salon 312 Lễ Văn Sỹ, Phường 1', 'addr' => '312 Lê Văn Sỹ, Phường 1, Tân Bình, Thành phố Hồ Chí Minh', 'lat' => '10.79691361', 'lng' => '106.6650516'],
            ['name' => 'Salon 36 Phan Huy Ích, Phường 15', 'addr' => '36 Phan Huy Ích, Phường 15, Tân Bình, Thành phố Hồ Chí Minh', 'lat' => '10.82595047', 'lng' => '106.6309237'],
            ['name' => 'Salon 150 Trường Chinh, Phường 12', 'addr' => '150 Trường Chinh, Phường 12, Tân Bình, Thành phố Hồ Chí Minh', 'lat' => '10.7951762', 'lng' => '106.6497652'],
            ['name' => 'Salon 49 Phan Đình Phùng, Phường 17', 'addr' => '112 Đ. P. Quang, Phường 2, Phú Nhuận, Thành phố Hồ Chí Minh', 'lat' => '10.80849975', 'lng' => '106.6711343'],
            ['name' => 'Salon 112 Phổ Quang, Phường 9', 'addr' => '49 Phan Đình Phùng, Phường 17, Phú Nhuận, Thành phố Hồ Chí Minh', 'lat' => '10.79328653', 'lng' => '106.6849881'],
            ['name' => 'Salon 872 Quốc Lộ 22, TT. Củ Chi', 'addr' => '872 QL22, TT. Củ Chi, Củ Chi, Thành phố Hồ Chí Minh', 'lat' => '11.97031955', 'lng' => '107.4833274']
        ];

        // 'id' => '9fa83d3e-4e47-4424-8c3a-6bcae9cd1b46',
        // 'name' => 'Ốc Điếc Sài Gòn'
        $l3 = [
            ['name' => 'Ốc Điếc Sài Gòn', 'addr' => '68 Hong Do, Phu Do, Nam Tu Liem, Ha Noi', 'lat' => '21.00987836', 'lng' => '105.7652469']
        ];

        // 'id' => 'bb2c996b-e394-4733-a700-b9c19e339357',
        // 'name' => 'Cửa hàng quần áo Achicklet'
        $l4 = [
            ['name' => 'Cửa hàng quần áo Achicklet', 'addr' => '62A Yen Phu, Tay Ho, Ha Noi', 'lat' => '21.00987836', 'lng' => '105.7652469']
        ];

        // 'id' => '7a79e528-9e90-442d-aac8-6c61ec05f171',
        // 'name' => 'McDonald’s Việt Nam'
        $l5 = [
            ['name' => 'Mc Donald Tràng Tiền', 'addr' => '2 P. Hàng Bài, Tràng Tiền, Hoàn Kiếm, Hà Nội, Việt Nam', 'lat' => '21.02537', 'lng' => '105.85305'],
            ['name' => 'Mc Donald Trung Liệt', 'addr' => '1 P. Thái Hà, Trung Liệt, Đống Đa, Hà Nội 100000, Việt Nam', 'lat' => '21.00921', 'lng' => '105.82374'],
            ['name' => 'Mc Donald Dương Nội', 'addr' => 'T169 - 170, Dương Nội, Hà Đông, Hà Nội, Việt Nam', 'lat' => '20.98953', 'lng' => '105.75116'],
            ['name' => 'Mc Donald Tây Mỗ', 'addr' => 'Tầng 1 Vincom Megamall Smart City, Tây Mỗ, Từ Liêm, Hà Nội, Việt Nam', 'lat' => '21.00618', 'lng' => '105.75337'],
            ['name' => 'Mc Donald Thanh Xuân', 'addr' => '2 P. Hoàng Đạo Thúy, Nhân Chính, Thanh Xuân, Hà Nội 100000, Việt Nam', 'lat' => '21.0055', 'lng' => '105.804'],
            ['name' => 'Mc Donald Nguyễn Ngọc Vũ', 'addr' => 'Số 103 Ng. 189 Đ. Nguyễn Ngọc Vũ, Trung Hoà, Cầu Giấy, Hà Nội, Việt Nam', 'lat' => '21.01076', 'lng' => '105.80697'],
            ['name' => 'Mc Donald Trần Duy Hưng', 'addr' => 'Tầng 5, Vincom center, 119 Trần Duy Hưng, Trung Hoà, Cầu Giấy, Hà Nội 100000, Việt Nam', 'lat' => '21.0059', 'lng' => '105.79509']
        ];

        // 'id' => '1145481a-d16a-421e-8392-01776f73b134',
        // 'name' => 'Highland Coffee'
        $l6 = [
            ['name' => 'Highland Coffee Mễ Trì', 'addr' => 'Handico Tower, Phạm Hùng, Mễ Trì, Từ Liêm, Hà Nội, Việt Nam', 'lat' => '21.01661', 'lng' => '105.78216'],
            ['name' => 'Highland Coffee Trung Kính', 'addr' => 'Trung Kinh Ward Chelsea Park, 2Q9V+H63, P. Trung Kính, Yên Hoà, Cầu Giấy, Hà Nội, Việt Nam', 'lat' => '21.01877', 'lng' => '105.79303'],
            ['name' => 'Highland Coffee Trung Hoà', 'addr' => '119 Trần Duy Hưng, Trung Hoà, Đống Đa, Hà Nội 100000, Việt Nam', 'lat' => '21.00681', 'lng' => '105.79617'],
            ['name' => 'Highland Coffee Lê Văn Lương', 'addr' => 'Starcity Apartment, 81 Đ. Lê Văn Lương, Nhân Chính, Thanh Xuân, Hà Nội, Việt Nam', 'lat' => '21.00613', 'lng' => '105.80648']
        ];

        // 'id' => '1725a0a8-34a7-4070-ad72-bb08907f3276',
        // 'name' => 'Cộng Cafe Hà Nội'
        $l7 = [
            ['name' => 'Cộng Cafe Mỹ Đình', 'addr' => '29 Lê Đức Thọ, Mỹ Đình, Hà Nội', 'lat' => '21.02991542', 'lng' => '105.7691124'],
            ['name' => 'Cộng Cafe Hoàn Kiếm', 'addr' => '4 Lý Thường Kiệt, Hoàn Kiếm, Hà Nội', 'lat' => '21.02169422', 'lng' => '105.8570034'],
            ['name' => 'Cộng Cafe Đống Đa', 'addr' => '94 Đường Láng, Thịnh Quang, Đống Đa, Hà Nội', 'lat' => '21.00433323', 'lng' => '105.8185399']
        ];

        // 'id' => '6e9ec837-1763-49dc-9e1f-b2c9ba7372f4',
        // 'name' => 'Cộng Cafe HCM',
        $l8 = [
            ['name' => 'Cộng Cafe Hồ Con Rùa', 'addr' => 'Lầu 2, 08 Bis, Công Trường Quốc Tế, Q.3, Thành phố Hồ Chí Minh (Hồ Con Rùa)', 'lat' => '10.78321398', 'lng' => '106.6958004'],
            ['name' => 'Cộng Cafe Q.1', 'addr' => 'B3 Vincom Đồng Khởi, Q.1, Thành phố Hồ Chí Minh', 'lat' => '10.77803375', 'lng' => '106.701921'],
            ['name' => 'Cộng Cafe Q.6', 'addr' => '152 Chợ Lớn, Phường 11, Q.6, Thành phố Hồ Chí Minh', 'lat' => '10.74572948', 'lng' => '106.6312183']
        ];


        $tasks = Task::pluck('id')->toArray();

        foreach($tasks as $taskId) {
            if ($taskId == '6e9ec837-1763-49dc-9e1f-b2c9ba7372f4') {
                $locals = $l8;
            } elseif($taskId == '1725a0a8-34a7-4070-ad72-bb08907f3276') {
                $locals = $l7;
            } elseif($taskId == '1145481a-d16a-421e-8392-01776f73b134') {
                $locals = $l6;
            } elseif($taskId == '7a79e528-9e90-442d-aac8-6c61ec05f171') {
                $locals = $l5;
            } elseif($taskId == 'bb2c996b-e394-4733-a700-b9c19e339357') {
                $locals = $l4;
            } elseif($taskId == '9fa83d3e-4e47-4424-8c3a-6bcae9cd1b46') {
                $locals = $l3;
            } elseif($taskId == '2d7558aa-89b2-4727-a390-2d7eda56bcba') {
                $locals = $l2;
            } else {
                $locals = $l1;
            }

            foreach ($locals as $local) {
                $taskLoca = TaskLocation::firstOrNew(['name' => $local['name']]);
                $taskLoca->task_id = $taskId;
                $taskLoca->address = $local['addr'];
                $taskLoca->long = $local['lng'];
                $taskLoca->lat = $local['lat'];
                $taskLoca->sort = random_int(1, 10);
                $taskLoca->status = true;
                $taskLoca->phone_number = '0983' . random_int(100000, 999999);
                $taskLoca->open_time = '08:00';
                $taskLoca->close_time = '22:00';
                $taskLoca->save();
            }
        }
    }
}
