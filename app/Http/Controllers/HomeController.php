<?php

namespace App\Http\Controllers;

use App\Hostel;
use App\Room;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except("index");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hostels = Hostel::has('AvailableRooms')
            ->where(['verified'=>Hostel::VERIFIED_HOSTEL,'forwarded'=>Hostel::FORWARDED_HOSTEL])
            ->get();

        return view('home')->with(['hostels'=>$hostels]);
    }
}
