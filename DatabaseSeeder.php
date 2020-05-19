<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

      DB::table('users')->insert([
          'phone'   => '79028081653',
          'password'  => Hash::make('12345678')
      ]);

    //   DB::table('statuses')->insert([
    //     'about'   => 'лид',
    //     'status'  => 0
    //   ]);

    //   DB::table('statuses')->insert([
    //     'about' => 'клиент',
    //     'status' => 1
    //   ]);

    //   DB::table('groups')->insert([
    //     'about' => '4-6 лет'
    //   ]);

    //   DB::table('groups')->insert([
    //     'about' => '7-14 лет'
    //   ]);
      
    //     $days = ["",
    //       "Пн","Вт","Ср",
    //       "Чт","Пт","Сб","Вс"];

    //       for($n = 1; $n <= 7; $n++){
    //         DB::table('days')->insert([
    //           'day' => $days[$n]
    //         ]);
            
    //     for($i = 1; $i <= 2; $i++){
    //        $group = $i;
    //         $day = $n;
    //           for($j = 9; $j <= 19; $j++){
    //             $hour = $j.':00';
    //             DB::table('hours')->insert([
    //                 'hour' => $hour,
    //                 'group_id' => $group,
    //                 'day_id' => $day
    //             ]);
    //           } 
    //        }
    //     }
     }
}
