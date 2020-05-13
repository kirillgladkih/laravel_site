<?php

namespace App\Repositories\Schedule;

use App\Repositories\AbstractRepository;

use App\Models\Day as Model;

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
        
        function serchDay($days, $ref){
            foreach ($days as $item) {
                if ($item->day == $ref)
                    return $item;
            }
        }  

        $tmp = [];

        
        for($i = 0; $i <= 6; $i++){
            $ref  = strftime("%a", strtotime("+$i day"));
            $date = strftime("%d %b %a", strtotime("+$i day"));

            $day = serchDay($days, $ref);
            $day['date'] = $date; 

            $tmp[] = $day;
        }
       
        return $tmp;
   }

   public function getHours($day, $group)
   {
       $day_   = strftime("%a", strtotime($day));

       $day_id = $this->start()->where('day',$day_)
       ->get()[0]
       ->hours
       ->where('status', '1')
       ->where('group_id', $group);

       return $day_id;
   }
}