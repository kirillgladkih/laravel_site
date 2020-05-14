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

   public function saveForApi($data)
   {
        $model = $this->start()->create($data);

        return $model->id;
   }

   public function getModelPhone($phone)
   {
        $model = $this->start();

        $model = $model->where('phone', $phone)->first();

      
            
        $model = $model->children;
        $result = [
            'code' => 200,
            'data' => $model
        ];
        

        return response()->json($result);
   }
}