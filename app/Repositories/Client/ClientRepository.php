<?php

namespace App\Repositories\Client;

use App\Models\Child;
use App\Models\Client;

use App\Models\Procreator;
use App\Models\Client as Model;
use App\Models\Record;
use App\Repositories\AbstractRepository;

class ClientRepository extends AbstractRepository
{
    private $record;
    private $child;
    private $procreator;

    public function __construct()
    {
        parent::__construct();

        $this->record = new Record();
        $this->child = new Child();
        $this->procreator = new Procreator();
    }

    public function save($data)
    {
        $childRepository = new ChildRepository();
        $procreatorRepository = new ProcreatorRepository();

        $res = preg_replace('/^\+*/i','', $data->phone);
    
        $data->phone  = preg_replace('/^7/i','8', $res);

        $procreator_id =  $procreatorRepository->save($data);
        $child_id      =  $childRepository->save($data, $procreator_id);

        $model = new Model();

        $model->child_id = $child_id;
        $model->client_status = 1;

        $model->save();

        $result = [
            'code' => 200,
            'data' => $model
        ];

        return response()->json($result);
    }
    
    public function getModelClass()
    {
        return Model::class;
    }
    
    public function delete($id)
    {
        $client = $this->getEdit($id);
        $child  = $client->child;
        $procreator = $client->child->parent;
        $children = $this->child
        ->where('procreator_id', $procreator->id);
        
        $this->record->where('child_id', 
        $child->id)->delete();
        
        $child->delete();
        $client->delete();

        if(count($children->get()) <= 1)
            $procreator->delete();

    }

}