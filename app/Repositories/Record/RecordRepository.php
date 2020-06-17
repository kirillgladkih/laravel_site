<?php

namespace App\Repositories\Record;

use App\Models\Child;
use App\Repositories\AbstractRepository;

use App\Models\Record as Model;
use App\Repositories\Client\ChildRepository;
use App\Repositories\Client\ProcreatorRepository;
use App\Repositories\Place\PlaceRepository;
use App\Repositories\Schedule\DayRepository;

class RecordRepository extends AbstractRepository
{

    protected $place;
    protected $child;

    public function __construct()
    {
        parent::__construct();

        $this->place = new PlaceRepository();
        $this->child = new ChildRepository();
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

                $this->place->saveForRecord($result);
            }


            return $result;

    }

    public function validDate($date, $group)
    {
        $day = new DayRepository();

        $data = $day->getForApi($group)->getData()->data;

        foreach($data as $item){
            foreach($item->date as $value){
                foreach($value as $val){
                    if($val == $date)
                        return true;
                }
            }
        }

        return false;
    }

    public function saveForApi($data)
    {
        $group_id = $this->child->getEdit($data->child_id)->group_id;

        if(!$this->validDate($data->date, $group_id)){
            return response()->json([
                'code' => 500,
                'data' => ['errors' => ['date' => ['на этот день нет записей']]]
            ]);
        }

        $day = new DayRepository();

        $hours = $day->getHours($data->date, $group_id)->toArray();
        $tmp  = [];
        $tmp1 = [];

        foreach($hours as $item){
            $tmp [] = $item['hour'];
            $tmp1 []  = (int) preg_replace('/\:00\:00$/','', $item['hour']);
        }

        $error = response()->json([
            'code' => 500,
            'data' => ['errors' => ['begin and end' => ['неверное время записи']]]
        ]);

        if(in_array($data->begin, $tmp) && in_array($data->end, $tmp)){



            $begin_ = (int) preg_replace('/\:00\:00$/','', $data->begin);
            $end_   = (int) preg_replace('/\:00\:00$/','', $data->end);

            $index = array_search($begin_, $tmp1);

            $endIndex = array_search($end_, $tmp1);

            if($begin_ > $end_)
            {
                return $error;
            }

            for($i = $index; $i <= $endIndex; $i++){

                if($begin_ == $tmp1[$i]){
                    $begin_++;
                }else{
                    return $error;
                }
            }
        }else{
            return $error;
        }


        $model = Model::where('child_id', $data->child_id)
        ->where('record_date', $data->date)->get();

        if (count($model) != 0) {
            foreach ($model as $item) {
                $item->delete();
            }
        }

        $begin_ = (int) preg_replace('/\:00\:00$/','', $data->begin);
        $end_   = (int) preg_replace('/\:00\:00$/','', $data->end);

        $tmp2 = [];

        for($i = $begin_; $i<= $end_; $i++){

            $time = $i.':00:00';

            $data_ = [
                'record_time' => $time,
                'child_id' => $data->child_id,
                'record_date' => $data->date];

            $result = Model::create($data_);
            $tmp2[] = $result;
            $this->place->saveForRecord($result);
        }

        return response()->json([
            'code' => 200,
            'data' => $model
        ]) ;

    }

    public function checkForClosed($id, $value)
    {
        $record = $this->getEdit($id);

        $client = $record->child->client;

        if($value == '1'){
            $client->count_hour += 1;
            $client->last_record = $record->record_date;
        }else{
            $client->discount_hour += 1;
        }

        $client->save();

        $this->delete($id);
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
