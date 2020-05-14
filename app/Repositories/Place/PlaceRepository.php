<?php

namespace App\Repositories\Place;

use App\Repositories\AbstractRepository;

use App\Models\Place as Model;


class PlaceRepository extends AbstractRepository
{
    public function getModelClass()
    {
       return Model::class;
    }

    public function getAll(){
        $date = date('Y-m-d');

        $result = $this->start()
        ->where('place_date', '>=', $date)->get();

        return $result;
    }

    public function getGroup($age)
    {
        if($age < 7){
            $group = 1; 
        }else{
            $group = 2;
        }

        return $group;
    }

    public function saveForRecord($data)
    {
        $group = $this->getGroup($data->child->age);

        $model = Model::where('group_id',$group)
        ->where('place_date',$data->record_date)
        ->where('place_time',$data->record_time)->first();

        if (!empty($model)) {
            $model->count += 1;
            
            return $model->save();
        }   

        $model = $this->start();

        $model->group_id = $group;
        $model->count   = 1;
        $model->place_date = $data->record_date;
        $model->place_time = $data->record_time;

        $model->save();        

    }   

    public function minus($data)
    {
        $group = $this->getGroup($data->child->age);

        $model = $this->start()
        ->where('place_date', $data->record_date)
        ->where('place_time', $data->record_time)
        ->where('group_id', $group)->first();

        $model->count -= 1;

        $model->save();

    }

    public function save($data)
    {
        $model = $this->start()->where('place_date',$data->place_date)
        ->where('place_time', $data->place_time)
        ->where('group_id',$data->group_id)
        ->first();

        if( ! empty($model)){
            
            $model->max_count = $data->max_count;
            $model = $model->save();

        }else{
            $model = $this->start();
            $model->create($data->all());
        }

        return $model;
    }

    public function deleteId($id, $date)
    {
        
    }

    public function update($data)
    {

    }
}