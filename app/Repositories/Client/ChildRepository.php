<?php

namespace App\Repositories\Client;

use App\Repositories\AbstractRepository;

use App\Models\Child as Model;
use App\Models\Child;
use App\Models\Client;

class ChildRepository extends AbstractRepository
{
    private $child;
    private $client;

   public function getModelClass()
   {
       return Model::class;

        $this->child = new Child();
        $this->client = new Client();

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

   public function saveForAddChild($request)
   {   
        if($request->age <= 6){
            $group = 1;
        }else{
            $group = 2; 
        }   
        
        $data = [
            'fio' => $request->fio,
            'age' => $request->age,
            'group_id' => $group,
            'procreator_id' => $request->procreator_id
        ];

       $child = Child::create($data);

        Client::create([
            'child_id' => $child->id,
            'procreator_id' => $request->procreator_id
        ]);
   }

   public function getAsParentId($id)
   {
       $result = $this->start()->where('procreator_id',$id)->get();

       return $result;
   }

}