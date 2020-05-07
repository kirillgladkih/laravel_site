<?php

namespace App\Repositories\Record;

use App\Repositories\AbstractRepository;

use App\Models\Record as Model;
use App\Repositories\Client\ProcreatorRepository;

class RecordRepository extends AbstractRepository
{
   public function getModelClass()
   {
       return Model::class;
   }

   public function getParent()
   {
       $procreatorRepository = new ProcreatorRepository(); 

       $result = $procreatorRepository->getAll();

       return $result;
   }
}