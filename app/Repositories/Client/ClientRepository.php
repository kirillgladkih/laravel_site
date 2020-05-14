<?php

namespace App\Repositories\Client;

use App\Models\Child;
use App\Models\Client;

use App\Models\Procreator;
use App\Models\Client as Model;
use App\Repositories\AbstractRepository;

class ClientRepository extends AbstractRepository
{

    private $child;
    private $procreator;

    public function __construct()
    {
        parent::__construct();

        $this->child = new Child();
        $this->procreator = new Procreator();
    }

    public function save($data)
    {
        $childRepository = new ChildRepository();
        $procreatorRepository = new ProcreatorRepository();

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
 

}