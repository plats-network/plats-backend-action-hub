<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Reward};
use Carbon\Carbon;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        printf("=======> Create Reward \n");
        $reward = Reward::firstOrNew(['id' => '6040d2f3-c5c7-4ebd-8400-4331a429c4a9']);
        $reward->name = 'My box';
        $reward->description = 'Desc my box';
        $reward->image = 'icon/hidden_box.png';
        $reward->type = 0;
        $reward->region = 0;
        $reward->start_at = Carbon::now();
        $reward->end_at = Carbon::now()->addDays(360);
        $reward->save();
    }
}
