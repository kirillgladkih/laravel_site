<?php

namespace App\Repositories\Record;

use App\Repositories\AbstractRepository;

use App\Models\Record as Model;
use App\Repositories\Client\ProcreatorRepository;
use App\Repositories\Place\PlaceRepository;

class RecordRepository extends AbstractRepository
{

    protected $place;

    public function __construct()
    {
        parent::__construct();

        $this->place = new PlaceRepository();
    }

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

    public function save($data)
    {
        $model = Model::where('child_id', $data->child_id)
        ->where('record_date', $data->record_date)->get();
        
        $result = 'fff';

        if (count($model) != 0) {
            foreach ($model as $item) {
                $item->delete();
            }
        }
            foreach ($data['record_time'] as $value) {
                $data_ = [
                    'record_time' => $value,
                    'child_id' => $data->child_id,
                    'record_date' => $data->record_date];
            
                $result = Model::create($data_);
                
                $this->place->save($result);
            }
       

            return $result;
        
    }

    public function getAll()
    {
        $result = Model::all()->sortBy('record_date');

        return $result;
    }

    public function delete($id)
    {
        $model = $this->start()->find($id);

        $this->place->minus($model);

        $model->delete();
        
    }
}