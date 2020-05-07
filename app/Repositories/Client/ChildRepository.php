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
        $model->procreator_id = $id;

        $model->save();

        return $model->id;
   }

   public function getAsParentId($id)
   {
       $result = $this->start()->where('procreator_id',$id)->get();

       return $result;
   }

}