<?php

namespace App\Repositories\Client;

use App\Repositories\AbstractRepository;

use App\Models\Child as Model;

class ChildRepository extends AbstractRepository
{
   public function getModelClass()
   {
       return Model::class;
   }

   public function save($data, $id)
   {
        $model = new Model();

        $model->fio   = $data->child_fio;
        $model->age   = $data->age;

        if($data->age <= 6){
            $group = 1;
        }else{
            $group = 2; 
        }

        $model->group_id = $group;

        $model->procreator_id = $id;

        $model->save();

        return $model->id;
   }

   public function saveForApi($data)
   {
        $model = $this->start()->create($data);

        return $model;
   }

   public function getAsParentId($id)
   {
       $result = $this->start()->where('procreator_id',$id)->get();

       return $result;
   }

}