<?php

namespace App\Http\Controllers\Selection;

use App\Payment;
use App\Room;
use App\Selection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SelectionRoomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['booking']);
    }

    public function booking($id)
    {
        $selection = Selection::findOrFail($id);

        if(!$selection->user_id){

            $selection->user_id = Auth::id();

        }else{

            if($selection->user_id !== Auth::id()){

                abort(404);
            }
        }

        if($selection->nbr_rooms === 0){

            return redirect(route('home'))
                ->with(['general_error'=>'Désolé les chambres sélectionnées ne sont plus disponibles']);
        }

        return view('rooms.payment')->with(['selection'=>$selection]);


    }

    /**
     * @param Request $request
     * @param $id
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function book(Request $request, $id)
    {
        $selection = Selection::findOrFail($id);

        if($selection->user_id !== Auth::id()){

            abort(404);
        }

        $rules = [
            'account_nbr'=>'required|integer|digits:16',
            'account_owner'=>'required',
            'month'=>'required|digits_between:1,2',
            'year'=>'required|digits:4',
            'cvv'=>'required|digits:3'
        ];

       $data = $this->validate($request,$rules);



        $data['selection_id'] = $selection->id;
        $data->total = $selection->total;

        Payment::create($data);




        return view('rooms.payment-success')->with(['selection'=>$selection]);
    }
}
