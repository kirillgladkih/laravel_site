<?php

namespace App\Repositories\Client;

use App\Models\Child;
use App\Models\Client;

use App\Models\Record;
use App\Models\Procreator;
use App\Models\Client as Model;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\Validator;

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

        $procreator_id =  $procreatorRepository->save($data);
        $child_id      =  $childRepository->save($data, $procreator_id);

        $model = new Model();

        $model->child_id = $child_id;

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
        $client     = $this->start()->find($id);
        $child      = $this->child->find($client->child_id);
        $record     = $this->record->where('child_id', $child->id);
        $procreator = $this->procreator->find($child->procreator_id);
        $children   = $this->child->where('procreator_id', $procreator->id);

        $record->delete();
        $client->delete();
        $child->delete();

        if(count($children->get()) < 1){
            $procreator->delete();
        }

    }

    public function edit($id, $request)
    {
        $client     = $this->start()->find($id);

        $child      = $this->child->find($client->child_id);
        $procreator = $this->procreator->find($child->procreator_id);

        $procreator->update([
            'fio' => $request->parent_fio,
            'phone' => $request->phone
        ]);

        $child->update([
            'fio' => $request->child_fio,
            'age' => $request->age
        ]);

    }

}
