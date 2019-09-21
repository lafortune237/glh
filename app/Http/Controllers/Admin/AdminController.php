<?php

namespace App\Http\Controllers\Admin;

use App\Hostel;
use App\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function checkUser($user,$hostel)
    {
        if($user->id !== $hostel->id){
            abort(404);
        }
    }

    public function showHostelRoom($hostel,$room)
    {
        $hostel = Hostel::findOrFail($hostel);
        $room = Room::findOrFail($room);

        $this->checkUser($hostel,$room->hostel);

        return view('admin.rooms.show')->with(['room'=>$room]);
    }

    public function showHostel($hostel)
    {
        $hostel = Hostel::findOrFail($hostel);


        return view('admin.hostels.show')->with(['hostel'=>$hostel]);
    }

    public function showHostels($option)
    {
        if($option == 'waiting'){

            $hostels = Hostel::where(['verified'=>Hostel::UNVERIFIED_HOSTEL])->get();

            return view('admin.hostels.waiting-validation')
                ->with(['hostels'=>$hostels]);
        }

        if($option == 'verified'){

            $hostels = Hostel::where(['verified'=>Hostel::VERIFIED_HOSTEL])->get();

            return view('admin.hostels.verified')
                ->with(['hostels'=>$hostels]);
        }

        return redirect(route('home'));
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
        //
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
