<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        switch (App()->environment()) {
            case 'local':
            case 'testing':
            case 'staging':
                $this->call([
                    CompanySeeder::class,
                    RewardSeeder::class,
                    TaskSeeder::class,
                    LocationSeeder::class
                ]);

                break;
            case 'production':
                $this->call([
                    CompanySeeder::class,
                    RewardSeeder::class,
                    TaskSeeder::class,
                    LocationSeeder::class
                ]);

                break;
        }
    }
}
