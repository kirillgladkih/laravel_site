<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\DefaultController;
use App\Http\Requests\ClientSaveRequest;
use App\Repositories\Client\ClientRepository;
use App\Repositories\Client\ProcreatorRepository;
use App\Repositories\Record\RecordRepository;

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
        $clientRepository->save($request);
    }
    
    public function destroy($id, ClientRepository $repository){
        
        $model = $repository->delete($id);
        
        return response()->json($model);
    }

    public function storeChild(Request $request)
    {
        return response()->json($request->all());
    }
    
}
