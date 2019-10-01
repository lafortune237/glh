<?php

namespace App\Http\Controllers\Admin;

use App\Hostel;
use App\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function validateHostel(Request $request, $hostel)
    {
        $hostel = Hostel::findOrFail($hostel);

        if(!$hostel->isVerified()){
            $hostel->verified = Hostel::VERIFIED_HOSTEL;

            $hostel->save();


            $this->forwardHostel($request,$hostel);


        }

        return back();


    }
    public function unvalidateHostel(Request $request, $hostel)
    {

        $hostel = Hostel::findOrFail($hostel);

        if($hostel->isVerified()){

            $hostel->verified = Hostel::UNVERIFIED_HOSTEL;

            $hostel->save();


            $this->unforwardHostel($request,$hostel);


        }
        return back();
    }


    public function forwardHostel(Request $request, $hostel)
    {

        if(!$hostel->isForwarded() && !$hostel->AvailableRooms()->get()->isEmpty()){

            $hostel->forwarded = Hostel::FORWARDED_HOSTEL;
            $hostel->save();

            if(Hostel::where(['forwarded'=>Hostel::FORWARDED_HOSTEL])->get()->count() >= 15){

                $hostel_replacer = Hostel::has('AvailableRooms')
                    ->where(['verified'=>Hostel::VERIFIED_HOSTEL,'forwarded'=>Hostel::FORWARDED_HOSTEL])
                    ->orderBy('created_at','desc')
                    ->first();

                $hostel_replacer->forwarded = Hostel::REGULAR_HOSTEL;
                $hostel_replacer->save();
            }

        }

        return back()->with(['success'=>'Opération réussie']);

    }

    public function unforwardHostel(Request $request,$hostel)
    {

        if($hostel->isForwarded()){

            $hostel->forwarded = Hostel::REGULAR_HOSTEL;
            $hostel->save();

            if(Hostel::where(['forwarded'=>Hostel::FORWARDED_HOSTEL])->get()->count() < 15){
                $hostel_replacer = Hostel::has('AvailableRooms')
                    ->where(['verified'=>Hostel::VERIFIED_HOSTEL,'forwarded'=>Hostel::REGULAR_HOSTEL])
                    ->orderBy('nbr_rental','desc')
                    ->first();

                $hostel_replacer->forwarded = Hostel::FORWARDED_HOSTEL;
                $hostel_replacer->save();
            }

        }



        return back()->with(['success'=>'Opération réussie']);

    }

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
