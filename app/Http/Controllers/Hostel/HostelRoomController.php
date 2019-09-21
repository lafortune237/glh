<?php

namespace App\Http\Controllers\Hostel;

use App\Hostel;
use App\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HostelRoomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['booking']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $hostel
     * @param $room
     * @return \Illuminate\Http\Response
     */
    public function booking($hostel, $room)
    {
        $hostel = Hostel::find($hostel);
        $room = Room::find($room);

        if(!$hostel || !$room){

            abort(404);

        }

        $this->checkUser($hostel,$room->hostel);

        return view('rooms.booking')->with(['room'=>$room]);

    }

    /**
     * Display the specified resource.
     *
     * @param $hostel
     * @param $room
     * @return \Illuminate\Http\Response
     */
    public function show($hostel, $room)
    {
        $hostel = Hostel::find($hostel);
        $room = Room::find($room);

        $this->checkUser(Auth::user(),$hostel->user);
        $this->checkUser($hostel,$room->hostel);

        if($hostel->id !== $room->hostel->id){

            return redirect(route('home'));
        }

        return view('rooms.show')->with(['room'=>$room]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hostel  $hostel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hostel $hostel)
    {
        return view('rooms.edit');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hostel  $hostel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hostel $hostel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hostel  $hostel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hostel $hostel)
    {
        //
    }

    public function checkUser($user,$hostel)
    {
        if($hostel->id !== $user->id){
            abort(404);
        }
    }
}
