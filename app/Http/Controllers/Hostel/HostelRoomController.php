<?php

namespace App\Http\Controllers\Hostel;

use App\Hostel;
use App\Room;
use App\Selection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HostelRoomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['booking','book']);
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
        $hostel = Hostel::findOrFail($hostel);
        $room = Room::findOrFail($room);

        $this->checkUser($hostel,$room->hostel);

        return view('rooms.booking')->with(['room'=>$room]);

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function book(Request $request, $hostel,$room)
    {
        $rules = [
            'request_dates'=>'required',
            'address_station'=>'filled',
            'address_latitude'=>'filled',
            'address_longitude'=>'filled'
        ];

        $this->validate($request,$rules);

        $hostel = Hostel::findOrFail($hostel);

        $room = Room::findOrFail($room);

        $this->checkUser($hostel,$room->hostel);

        if(!$hostel->isVerified()){

            return back()->with(['general_error'=>'Désolé une erreur s\'est produite']);

        }

        if(!$room->isAvailable()){
            return back()->with(['general_error'=>'Désolé cette chambre n\'est pas disponible']);

        }

        $request_dates = explode(' - ',$request->request_dates);

        $date_start = date('Y-m-d H:i:s',strtotime($request_dates[0]));
        $date_end = date('Y-m-d H:i:s',strtotime($request_dates[1]));

        $info_price = $room->getInfoPricing($date_start,$date_end)->getData();

        if($info_price->message == 'invalid_dates'){
            return back()->withErrors(['request_dates'=>'Dates invalides'])
                ->withInput()
                ->with(['general_error'=>'Dates invalides']);

        }

        if($info_price->message == 'passed_dates'){
            return back()->withErrors(['request_dates'=>'Une réservation ne peut pas commencer dans le passé'])
                ->withInput()
                ->with(['general_error'=>'Une réservation ne peut pas commencer dans le passé']);

        }

        if($info_price->message == 'delay_passed'){
            return back()->withErrors(['request_dates'=>'La durée maximale de réservation est de 30 nuits'])
                ->withInput()
                ->with(['general_error'=>'La durée maximale de réservation est de 30 nuits']);

        }

        if($info_price->message == 'short_date'){
            return back()->withErrors(['request_dates'=>'Vous ne pouvez pas réserver pour moin de '.Selection::MIN_HOURS.' heure(s)'])
                ->withInput()
                ->with(['general_error'=>'Vous ne pouvez pas réserver pour moin de '.Selection::MIN_HOURS.' heure(s)']);

        }

        $selection = new Selection();
        $selection->address_station = $request->address_station ? $request->address_station : $room->hostel->address_station;
        $selection->address_latitude = $request->address_latitude ? $request->address_latitude : $room->hostel->address_latitude;
        $selection->address_longitude = $request->address_longitude ? $request->address_longitude : $room->hostel->address_longitude;
        $selection->request_date_start = $date_start;
        $selection->request_date_end = $date_end;
        $selection->nbr_hours =  isset($info_price->pricing->nbr_hours) ? $info_price->pricing->nbr_hours : null;
        $selection->nbr_nights =isset($info_price->pricing->nbr_nights) ? $info_price->pricing->nbr_nights : null;
        $selection->save();

        $selection->rooms()->attach($room->id,[
            'total'=>$info_price->pricing->total,
            'pricing'=>json_encode($info_price->pricing),
            'created_at'=> $created_at = date("Y-m-d H:i:s"),
            'updated_at'=>$created_at
        ]);

        return redirect(route('selections.booking',['selection'=>$selection->id]));

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

        $this->checkUser($hostel,$room->hostel);

        $this->checkUser(Auth::user(),$hostel->user);

        if($hostel->id !== $room->hostel->id){

            return redirect(route('home'))->with(['general_error'=>'Désolé une erreur s\'est produite']);
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

    public function checkUser($user,$hostel)
    {
        if($hostel->id !== $user->id){
            abort(404);
        }
    }
}
