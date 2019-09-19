<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showProfile()
    {
        return view('users.profile');
    }

    public function showReservations()
    {
        $reservations = Auth::user()
            ->reservations()
            ->with('rooms')
            ->get()
        ;

        return view('users.reservations')->with(['reservations'=>$reservations]);
    }



}
