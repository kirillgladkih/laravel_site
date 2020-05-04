<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 2; $i++){
           $group = $i;
           for($n = 1; $n <= 7; $n++){
            $day = $n;
              for($j = 9; $j <= 19; $j++){
                $hour = $j.':00';
                DB::table('hours')->insert([
                    'hour' => $hour,
                    'group_id' => $group,
                    'day_id' => $day
                ]);
              } 
           }
        }
    }
}
