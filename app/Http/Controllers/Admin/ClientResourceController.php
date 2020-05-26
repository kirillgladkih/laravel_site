<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\DefaultController;
use App\Http\Requests\ChildSaveRequest;
use App\Http\Requests\ClientSaveRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Client;
use App\Repositories\Client\ChildRepository;
use App\Repositories\Client\ClientRepository;
use App\Repositories\Client\ProcreatorRepository;
use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;

class ClientResourceController extends DefaultController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClientRepository $clientRepository, ProcreatorRepository $procreatorRepository)
    {
        $clients = $clientRepository->getAll();
        $parents = $procreatorRepository->getAll();

        return view('client.client', compact(['clients', 'parents']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientSaveRequest $request, 
    ClientRepository $clientRepository)
    {
        return $clientRepository->save($request);
    }
    
    public function destroy($id, ClientRepository $repository){
        
        $model = $repository->delete($id);
        
        return response()->json($model);
    }

    public function storeChild(ChildSaveRequest $request, ChildRepository $repository)
    {
        $repository->saveForAddChild($request);
    }
    
    public function update($id,ClientUpdateRequest $request, ClientRepository $repository)
    {   
        $client = new Client();
        $id_ = $client->find($id)->child->parent->id;

        $Validator = Validator::make($request->all(), [
            'phone' => [
                Rule::unique('procreators')->ignore($id_)
            ],
        ]);

        if($Validator->fails())
            return response()->json(['errors' => $Validator->errors()], 422);

        $repository->edit($id, $request);
    }
}
