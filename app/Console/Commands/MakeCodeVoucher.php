<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CodeVoucher;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CodeExport;

class MakeCodeVoucher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:code_voucher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // GENRAGE voucher gửi đối tác

        // $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // for($i=0; $i < 1000; $i++) {
        //     CodeVoucher::create([
        //         'code' => substr(str_shuffle(str_repeat($pool, 5)), 0, 6),
        //     ]);
        // }

        // for($i=0; $i < 25; $i++) {
        //     CodeVoucher::create([
        //         'code' => substr(str_shuffle(str_repeat($pool, 5)), 0, 6),
        //         'type' => 1
        //     ]);
        // }

        // for($i=0; $i < 25; $i++) {
        //     CodeVoucher::create([
        //         'code' => substr(str_shuffle(str_repeat($pool, 5)), 0, 6),
        //         'type' => 2
        //     ]);
        // }


        Excel::store(new CodeExport(), 'users_3.xlsx', 's3');
        // Excel::store($b, 'users_2.xlsx', 's3');
        // Excel::store($c, 'users_3.xlsx', 's3');

        return Command::SUCCESS;
    }
}
