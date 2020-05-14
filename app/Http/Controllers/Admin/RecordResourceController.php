<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Client\ChildRepository;
use App\Repositories\Record\RecordRepository;
use App\Repositories\Schedule\DayRepository;
use Illuminate\Http\Request;

class RecordResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RecordRepository $recordRepository)
    {
        $parents = $recordRepository->getParent();

        return view('record.index', compact('parents'));
    }

    public function getHour($day, $group, DayRepository $dayRepository)
    {
        $result = $dayRepository->getHours($day, $group);
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RecordRepository $recordRepository)
    {
        $result = $recordRepository->save($request);

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, ChildRepository $childRepository)
    {
        $result = $childRepository->getAsParentId($id);

        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id, RecordRepository $recordRepository)
    // {
    //     $recordRepository->delete($id);
    // }
}
