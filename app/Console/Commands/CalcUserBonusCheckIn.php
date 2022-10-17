<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DetailReward;

class CalcUserBonusCheckIn extends Command
{
    public function __construct() {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:user-bonus-checkin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tính phần thưởng cho user khi thực hiện checkin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get buonus
        $bonus = DetailReward::where();

        return Command::SUCCESS;
    }
}
