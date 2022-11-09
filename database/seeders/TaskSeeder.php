<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
    TaskLocation, Task,
    TaskGuide, TaskReward,
    Reward, TaskGallery
};

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        printf("=======> Create Task \n");
        $reward = Reward::first();
        $imgs = [
            ['id' => 'ea5392d5-261d-49b7-909a-7bcdb9f74eb2', 'num' => 7, 'name' => '30shines'],
            ['id' => '2d7558aa-89b2-4727-a390-2d7eda56bcba', 'num' => 7, 'name' => '30shines'],
            ['id' => '6e9ec837-1763-49dc-9e1f-b2c9ba7372f4', 'num' => 5, 'name' => 'cong-cafe'],
            ['id' => '1725a0a8-34a7-4070-ad72-bb08907f3276', 'num' => 5, 'name' => 'cong-cafe'],
            ['id' => '9fa83d3e-4e47-4424-8c3a-6bcae9cd1b46', 'num' => 5, 'name' => 'oc-diec-sai-gon'],
            ['id' => 'bb2c996b-e394-4733-a700-b9c19e339357', 'num' => 5, 'name' => 'achicklet'],
            ['id' => '7a79e528-9e90-442d-aac8-6c61ec05f171', 'num' => 5, 'name' => 'mc-donald'],
            ['id' => '1145481a-d16a-421e-8392-01776f73b134', 'num' => 5, 'name' => 'highlands-coffee'],
        ];
        $tasks = [
            [
                'id' => 'ea5392d5-261d-49b7-909a-7bcdb9f74eb2',
                'name' => '30 Shine Hà Nội',
                'description' => 'Là một trong những chuỗi cửa hàng salon tóc nam uy tín nhất Việt Nam, 30Shine cung cấp đầy đủ các dịch vụ làm tóc, chăm sóc tóc. Thông qua chiến dịch lần này, \n\n30Shine tri ân khách hàng thông qua chương trình ưu đãi lên đến 50% cho các dịch vụ/ sản phẩm chăm tóc tóc.',
                'image' => 'tasks/30shines/30shines-01.png'
            ],
            [
                'id' => '2d7558aa-89b2-4727-a390-2d7eda56bcba',
                'name' => '30 Shine HCM',
                'description' => 'Là một trong những chuỗi cửa hàng salon tóc nam uy tín nhất Việt Nam, 30Shine cung cấp đầy đủ các dịch vụ làm tóc, chăm sóc tóc. Thông qua chiến dịch lần này, \n\n30Shine tri ân khách hàng thông qua chương trình ưu đãi lên đến 50% cho các dịch vụ/ sản phẩm chăm tóc tóc.',
                'image' => 'tasks/30shines/30shines-04.png'
            ],
            [
                'id' => '6e9ec837-1763-49dc-9e1f-b2c9ba7372f4',
                'name' => 'Cộng Cafe HCM',
                'description' => 'Cộng cà phê là một trong những chuỗi cửa hàng cà phê thành công nhất ở Hà Nội. Cộng cà phê được ca sĩ Linh Dung cho ra đời lần đầu tiên là một tiệm giải khát nhỏ trên con phố Triệu Vương vào năm 2007. Cái tên “Cộng” đơn giản của quán được lấy từ chữ đầu tiên trong câu quốc hiệu “Cộng hoà Xã hội Chủ nghĩa Việt Nam”.',
                'image' => 'tasks/cong-cafe/cong-cafe-01.png'
            ],
            [
                'id' => '1725a0a8-34a7-4070-ad72-bb08907f3276',
                'name' => 'Cộng Cafe Hà Nội',
                'description' => 'Cộng cà phê là một trong những chuỗi cửa hàng cà phê thành công nhất ở Hà Nội. Cộng cà phê được ca sĩ Linh Dung cho ra đời lần đầu tiên là một tiệm giải khát nhỏ trên con phố Triệu Vương vào năm 2007. Cái tên “Cộng” đơn giản của quán được lấy từ chữ đầu tiên trong câu quốc hiệu “Cộng hoà Xã hội Chủ nghĩa Việt Nam”.',
                'image' => 'tasks/cong-cafe/cong-cafe-01.png'
            ],
            
            [
                'id' => '9fa83d3e-4e47-4424-8c3a-6bcae9cd1b46',
                'name' => 'Ốc Điếc Sài Gòn',
                'description' => 'Bạn là tín đồ về ốc? Với đầu bếp hơn 10 năm kinh nghiệm đến từ Sài Gòn, Ốc Điếc không chỉ phục vụ ốc ngon mà còn có vô vàn những thực đơn hải sản, lẩu chất lượng đi kèm. Cùng người thân và bạn bè ghé Ốc Điếc, hoàn thành nhiệm vụ Check-in và nhận nhiều ưu đãi bất ngờ!!!',
                'image' => 'tasks/oc-diec-sai-gon/oc-diec-sai-gon-01.png'
            ],
            [
                'id' => 'bb2c996b-e394-4733-a700-b9c19e339357',
                'name' => 'Cửa hàng quần áo Achicklet',
                'description' => 'Achicklet đồng hành cùng Plats Network trong chiến dịch ra mắt người dùng ứng dụng Mobile có tên Plats. Achicklet là thương hiệu thời trang mới nổi cùng thiết kế độc đáo, trang nhã mang lại cảm giác hài hoà cho phái nữ và phong cách cho các em bé. \n\nNhà Achicklet hiện đã có mặt tại Plats để đến gần hơn với khách hàng, siêu ưu đãi dành cho tín đồ mê thời trang lên đến 20% dành cho khách hàng tải và check in tại App. Ngoài ra, các chương trình "Ngày sinh nhật" và vô vàn ưu đãi khác đang đón chờ.',
                'image' => 'tasks/achicklet/achicklet-01.png'
            ],
            [
                'id' => '7a79e528-9e90-442d-aac8-6c61ec05f171',
                'name' => 'McDonald’s Việt Nam',
                'description' => 'McDonald’s sẽ thiết lập một chuẩn mực mới cho ngành công nghiệp nhà hàng phục vụ thức ăn nhanh tại Việt Nam, mang đến cho khách hàng những trải nghiệm độc nhất chỉ có tại chuỗi nhà hàng của mình. \n\nMcDonald’s Việt Nam cam kết áp dụng tiêu chuẩn của McDonald’s toàn cầu, đó là: Quality - Chất lượng, Service - Dịch vụ, Cleanliness - Vệ Sinh & Values - Giá trị.',
                'image' => 'tasks/mc-donald/mc-donald-05.png'
            ],
            [
                'id' => '1145481a-d16a-421e-8392-01776f73b134',
                'name' => 'Highland Coffee',
                'description' => 'Highlands Coffee, tự hào là thương hiệu Việt Nam, lan tỏa, kết nối triệu khách hàng Việt và là nơi để tất mọi người cùng thuộc về. \n\nBằng việc sử dụng nguồn nguyên liệu sạch, thuần Việt kết hợp với công thức pha phin độc đáo, Highlands Coffee nhanh chóng chinh phục được những khách hàng khó tính nhất bằng hương vị đậm đà, “chuẩn gu” theo đúng chất cà phê Việt.',
                'image' => 'tasks/highlands-coffee/highlands-coffee-03.png'
            ]
        ];

        foreach($tasks as $task) {
            $t = Task::firstOrNew(['id' => $task['id']]);
            $t->name = $task['name'];
            $t->description = $task['description'];
            $t->image = $task['image'];
            $t->duration = 30;
            $t->order = random_int(1, 10);
            $t->total_reward = 1;
            $t->valid_amount = 1;
            $t->valid_radius = random_int(100, 200);
            $t->type = 1;
            $t->status = true;
            $t->checkin_type = 1;
            $t->save();

            $taskReward = TaskReward::firstOrNew(['task_id' => $task['id']]);
            $taskReward->reward_id = $reward->id;
            $taskReward->save();

            foreach($imgs as $img) {
                if ($img['id'] == $task['id']) {
                    for ($i = 0; $i < (int)$img['num']; $i++) {
                        print('\n===> i = ' . $i + 1);
                        $imgUrl = 'tasks/' . $img['name'] . '/' . $img['name'] . '-0' . $i + 1 . '.png';
                        $taskGallery = TaskGallery::firstOrNew([
                            'task_id' => $task['id'],
                            'url' => $imgUrl

                        ]);
                        $taskGallery->save();
                    }
                }
            }
        }
    }
}
