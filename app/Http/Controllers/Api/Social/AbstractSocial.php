<?php

namespace App\Http\Controllers\Api\Social;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Client\ProcreatorRepository;


/**
 * Abstract class for social contact in 
 * procreator table
 */
abstract class AbstractSocial
{
    private $clients = [
        'viber', 'vk'
    ];

    private $repository;

    private $getRules = [
        "id"      => 'required|regex:/^\d+$/|exists:procreators',
    ];

    private $setRules = [
        "id"         => 'required|regex:/^\d+$/|exists:procreators',
        "client_id"  => 'required|unique:procreators,viber|unique:procreators,vk'
    ];

    public function __construct()
    {
        $this->repository = new ProcreatorRepository();
    }

    /**
     * Check valid data
     *
     * @param [type] $client
     * @param [type] $procreator_id
     * @return void
     */
    private function Validate($client, $procreator_id, $rules, $client_id = null)
    {

        if (! in_array($client, $this->clients)) {
            return [
            'code' => 500,
            'data' => [
                'errors'=> ['данный тип социальной сети не поддерживается']
            ]];
            
        }

        $data = ['id' => $procreator_id];

        if( ! is_null($client_id)){
            $data['client_id'] = $client_id;
        }

        $validator = Validator::make($data,$rules);
        
        if ($validator->fails()) {
            $errors = $validator->errors();
                return [
                    'code' => 500,
                    'data' => ['errors'=>$errors],
                ];
        }
    }

    /**
     * Get viber contacts
     *
     * @param integer $procreator_id
     * @return void
     */
    public function getSocial($procreator_id, $client)
    {     
        $validate = $this->Validate($client, 
            $procreator_id, $this->getRules);

        if(isset($validate['code']))
            return response()->json(
                $validate
            );

        $model = $this->repository->getEdit($procreator_id);

        return response()->json([
            'code' => 200,
            'data' => [
                'errors'=>[
                    'viber' => $model->viber,
                    'vk'    => $model->vk 
                ]],
        ]);
    }

    public function setSocial(Request $request)
    {
        $validate = $this->validate($request->client, 
            $request->id, $this->setRules, $request->client_id);
    
        if(isset($validate['code']))
            return response()->json(
                $validate
            );

       $model = $this->repository->setSocial(
            $request->client, $request->id, $request->client_id
        );

        return $model;
    }

}
