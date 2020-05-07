<?php

namespace App\Repositories\Client;

use App\Repositories\AbstractRepository;

use App\Models\Procreator as Model;

class ProcreatorRepository extends AbstractRepository
{
   public function getModelClass()
   {
       return Model::class;
   }

   public function save($data)
   {
        $model = new Model();

        $model->fio   = $data->parent_fio;
        $model->phone = $data->phone; 

        $model->save();

        return $model->id;
   }
}