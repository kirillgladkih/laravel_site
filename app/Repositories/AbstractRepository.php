<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
/**
 * Для использования класса нужно подключить модель
 * as Model
 */
abstract class AbstractRepository
{   
    protected $model;

    /**
     * Функция для начала работы
     *
     * @return Model
     */
    public function start()
    {
        return clone $this->model;
    }

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    public function getEdit($id)
    {
        $result = $this->start()->find($id);

        return $result;
    }

    abstract function getAll();
    abstract function getModelClass();
}