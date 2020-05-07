<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\DefaultController;
use App\Repositories\Schedule\DayRepository;
use Illuminate\Http\Request;

class CalendarController extends DefaultController
{
    public function index(DayRepository $dayRepository)
    {
        $days = $dayRepository->getForCalendar();

        

        return view('calendar.index', compact('days'));
    }
}
