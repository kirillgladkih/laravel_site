<?php

namespace App\Repositories\Client;

use App\Repositories\AbstractRepository;

use App\Models\Client as Model;

class ClientRepository extends AbstractRepository
{
   public function getModelClass()
   {
       return Model::class;
   }

   public function save($data)
   {
        $childRepository = new ChildRepository();
        $procreatorRepository = new ProcreatorRepository();

        $procreator_id = $procreatorRepository->save($data);
        $child_id      =  $childRepository->save($data, $procreator_id);

        $model = new Model();

        $model->child_id = $child_id;
        $model->client_status = 1;

        $model->save();
   }

}