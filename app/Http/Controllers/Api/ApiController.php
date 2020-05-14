<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Schedule\DayRepository;
use App\Repositories\Client\ClientRepository;
use App\Http\Requests\Client\ClientSaveRequest;
use App\Models\Procreator;
use App\Repositories\Client\ProcreatorRepository;
use App\Repositories\Record\RecordRepository;

class ApiController extends Controller
{

    private $procreator;
    private $client;
    private $days;
    private $record;

    public function __construct()
    {
        $this->procreator = new ProcreatorRepository();
        $this->client     = new ClientRepository();
        $this->days       = new DayRepository();
        $this->record     = new RecordRepository();
    
    }


    public function search($phone)
    {
        $rules = [
            'phone'      => 'regex:/^\+*[0-9]{11}$/|required|exists:procreators',
        ];

        $messages = [
            'phone.regex'      => ':attribute введен неверно',
            'phone.exists'     => 'Такого телефона нет в базе данных'
        ];

        $attr = [
            'phone'      => 'номер телефона',  
        ];

        $res = preg_replace('/^\+/i','', $phone);       
        $phone  = preg_replace('/^7/i','8', $res);

        $validator = Validator::make(['phone' => $phone],
        $rules, $messages, $attr);

        if ($validator->fails()) {
            $errors = $validator->errors();
                return response()->json([
                    'code' => 500,
                    'data' => ['errors'=>$errors],
                ]);
        }

        $result = $this->procreator->getModelPhone($phone);
    
        return $result;
    }
    
    public function getdays($group)
    {
        $rules = [
            
            'group'        => 'numeric|required|min:1|max:2',
        ];

        $messages = [
            'group'              => '',
        ];

        $attr = [
            'group'        => 'группа',
        ];

        $validator = Validator::make(['group' => $group],
        $rules, $messages, $attr);

        if ($validator->fails()) {
            $errors = $validator->errors();
                return response()->json([
                    'code' => 500,
                    'data' => ['errors'=>$errors],
                ]);
        }

        $result = $this->days->getForApi($group);

        return $result;

    }

    public function gethours($group, $day)
    {
        $rules = [
            'date'         => 'required|regex:/^20[0-9]{2}\-[0-9]{2}-[0-9]{2}$/i',
            'group'        => 'numeric|required|min:1|max:2|required',
        ];

        $messages = [
            'group'              => '',
            'date'              => '',
        ];

        $attr = [
            
            'group'        => 'группа',
            'date'              => 'дата',
        ];
        
        $validator = Validator::make([
            'group' => $group,
            'date'  => $day,
        ],
        $rules, $messages, $attr);

        if ($validator->fails()) {
            $errors = $validator->errors();
                return response()->json([
                    'code' => 500,
                    'data' => ['errors'=>$errors],
                ]);
        }
  
        $data = $this->days->getHours($day,$group);

        $result = [
            'code' => 200,
            'data' => $data,
        ];


        return response()->json($result);
    }

    public function record(Request $request)
    {
        $rules = [
            'child_id'   => 'numeric|exists:children,id|required',
            'date'       => 'required|regex:/^20[0-9]{2}\-[0-9]{2}-[0-9]{2}$/i',
            'begin'      => 'regex:/^[0-9]{2}\:[0-9]{2}\:[0-9]{2}$/|required', 
            'end'        => 'regex:/^[0-9]{2}\:[0-9]{2}\:[0-9]{2}$/|required', 
        ];

        $messages = [
            'child_id'   => '',
            'date'   => '',
            'begin'   => '',
            'end'   => ''
        ];

        $attr = [
            'child_id'   => 'ид ребенка',
            'date'   => 'дата',
            'begin'   => 'время начала записи',
            'end'   => 'время конца записи'
        ];



        $validator = Validator::make($request->all(),
        $rules, $messages, $attr);

        if ($validator->fails()) {
            $errors = $validator->errors();
                return response()->json([
                    'code' => 500,
                    'data' => ['errors'=>$errors],
                ]);
        }
    
        return $this->record->saveForApi($request);
    }

    public function reg(Request $request)
    {        
        $rules = [
            'parent_fio' => 'regex:/^[А-Яа-я]{3,}\s[А-Яа-я]{3,}\s[А-Яа-я]{3,}$/u|required',
            'child_fio'  => 'regex:/^[А-Яа-я]{3,}\s[А-Яа-я]{3,}\s[А-Яа-я]{3,}$/u|required',
            'phone'      => 'unique:procreators|regex:/^\+?[0-9]{11}$/|required',
            'age'        => 'numeric|min:4|max:14|required',
        ];

        $messages = [
            'parent_fio.regex' => ':attribute введено неверно',
            'child_fio.regex'  => ':attribute введено неверно',
            'phone.regex'      => ':attribute введен неверно',
            'age'              => '',
            'phone.unique'     => 'Такой телефон уже есть'
        ];

        $attr = [
            'parent_fio' => 'фио родителя',
            'child_fio'  => 'фио ребенка',
            'phone'      => 'номер телефона',
            'age'        => 'возраст ребенка',
        ];

        $res = preg_replace('/^\+*/i','', $request->phone);
        
        $request->phone  = preg_replace('/^7/i','8', $res);

        $data = [
            'parent_fio' => $request->parent_fio,
            'child_fio'  => $request->child_fio,
            'age'        => $request->age,
            'phone'      => $request->phone
        ];

        $validator = Validator::make($data,
        $rules, $messages, $attr);

        if ($validator->fails()) {
            $errors = $validator->errors();
                return response()->json([
                    'code' => 500,
                    'data' => ['errors'=>$errors],
                ]);
        }
    
        return $this->client->save($request);

    }
}
