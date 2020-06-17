<?php

namespace App\Repositories\Schedule;

use App\Models\Day as Model;

use Illuminate\Support\Facades\DB;
use App\Repositories\AbstractRepository;

class DayRepository extends AbstractRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    public function __construct()
    {
        parent::__construct();
        setlocale(LC_ALL, 'ru_RU', 'ru_RU.UTF-8', 'ru', 'russian');
    }

    public function getForCalendar()
    {

        $days = $this->getAll();

        function serchDay($days, $ref)
        {
            foreach ($days as $item) {
                if ($item->day == $ref)
                    return $item;
            }
        }

        $tmp = [];


        for ($i = 0; $i <= 6; $i++) {
            $ref  = strftime("%a", strtotime("+$i day"));
            $date = strftime("%d %b %a", strtotime("+$i day"));

            $day = serchDay($days, $ref);
            $day['date'] = $date;

            $tmp[] = $day;
        }

        return $tmp;
    }

    public function getValidDate($group)
    {
        $data = DB::table('days')
            ->join('hours', 'days.id', '=', 'hours.day_id')
            ->select('days.id', 'days.day')
            ->where('hours.status', 1)
            ->where('group_id', $group)
            ->distinct()
            ->get();

        foreach ($data as $item) {
            $day = $item->day;
            for ($i = 0; $i <= 6; $i++) {
                $ref  = strftime("%a", strtotime("+$i day"));
                $date = strftime("%Y-%m-%d", strtotime("+$i day"));

                if ($day == $ref) {
                    $item->date[] = [
                        $date,
                        strftime("%Y-%m-%d", strtotime('+7 day', strtotime($date)))
                    ];
                }
            }
        }

        return $data;
    }

    public function getForClosed()
    {
        $data = DB::table('days')
            ->join('hours', 'days.id', '=', 'hours.day_id')
            ->select('days.id', 'days.day')
            ->where('hours.status', 1)
            ->distinct()
            ->get();



        foreach ($data as $item) {
            $day = $item->day;
            for ($i = 0; $i <= 6; $i++) {
                $ref  = strftime("%a", strtotime("+$i day"));
                $date = strftime("%Y-%m-%d", strtotime("+$i day"));

                if ($day == $ref) {
                    $item->date[] = [
                        $date,
                        strftime("%Y-%m-%d", strtotime('+7 day', strtotime($date)))
                    ];
                }
            }
        }

        return $data;
    }

    public function getForApi($group)
    {
        $data = DB::table('days')
            ->join('hours', 'days.id', '=', 'hours.day_id')
            ->select('days.id', 'days.day')
            ->where('hours.status', 1)
            ->where('group_id', $group)
            ->distinct()
            ->get();



        foreach ($data as $item) {
            $day = $item->day;
            for ($i = 0; $i <= 6; $i++) {
                $ref  = strftime("%a", strtotime("+$i day"));
                $date = strftime("%Y-%m-%d", strtotime("+$i day"));

                if ($day == $ref) {
                    $item->date[] = [
                        $date,
                        strftime("%Y-%m-%d", strtotime('+7 day', strtotime($date)))
                    ];
                }
            }
        }

        $result = [
            'code' => 200,
            'data' => $data
        ];

        return response()->json($result);
    }

    public function getHours($day, $group)
    {
        $day_   = strftime("%a", strtotime($day));

        $day_id = $this->start()
            ->where('day', $day_)
            ->get()[0]
            ->hours
            ->where('status', '1')
            ->where('group_id', $group);

        return $day_id;
    }
}
