<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\DefaultController;
use App\Repositories\Schedule\DayRepository;
use App\Repositories\Schedule\HourRepository;
use Illuminate\Http\Request;

class ScheduleResourceController extends DefaultController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DayRepository $dayRepository, HourRepository $hourRepository)
    {
        $days = $dayRepository->getAll();
        $group1 = $hourRepository->getGroup(1);

      

        return view('schedule.index', compact('days', 'group1'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd(__METHOD__);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd(__METHOD__);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd(__METHOD__);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd(__METHOD__);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, HourRepository $hourRepository)
    {
        $status = $request->status;

        $result = $hourRepository->update($id, $status);
        
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd(__METHOD__);
    }
}
