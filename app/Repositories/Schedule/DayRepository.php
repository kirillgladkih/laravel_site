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

   public function getAll()
   {
       $result = $this->start()->all()->sortBy('id');

       return $result;
   }
}