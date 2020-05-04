<?php

namespace App\Repositories\Schedule;

use App\Repositories\AbstractRepository;

use App\Models\Hour as Model;

class HourRepository extends AbstractRepository
{
   public function getModelClass()
   {
       return Model::class;
   }

   public function getGroup($group)
   {
        $result = $this->start()->where('group_id', $group)->get();

        return $result;
   }

   public function getAll()
   {
       $result = $this->start()->all()->sortBy('id');

       return $result;
   }

   public function update($id, $status)
   {
        $model = $this->getEdit($id);
        $model->status = $status;
        $model->save();

        return $model;
   }
}