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

class ProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        print "1 ====> Xoa du lieu cac bang\n";
        DB::table('companies')->delete();
        DB::table('branches')->delete();
        DB::table('rewards')->delete();
        DB::table('detail_rewards')->delete();
        DB::table('user_task_rewards')->delete();

        $vochers = CodeVoucher::all();

        

        
    }
}
