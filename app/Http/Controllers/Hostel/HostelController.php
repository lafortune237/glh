<?php

namespace App\Http\Controllers\Hostel;

use App\Hostel;
use App\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HostelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('hostels.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $options = Option::where(['rel'=>'hostel'])->get();

        return view('hostels.create')->with(['options'=>$options]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function createImages($hostel_id)
    {

        $hostel = Hostel::findOrFail($hostel_id);

        return view('hostels.images')->with(['hostel'=>$hostel]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param $hostel_id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */

    public function storeImages(Request $request, $hostel_id)
    {

        $rules = [
            'front_image'=>'required|image'
        ];

        $this->validate($request,$rules);


        $hostel = Hostel::findOrFail($hostel_id);

        $this->checkUser(Auth::user(),$hostel->user);

        if($request->hasFile('front_image')){

            DB::table('images')->insert([

                'rel_id'=>$hostel->id,
                'filename'=>$request->file('front_image')->store(config('images.hostelsImages')),
                'image_type'=>'front_image',
                'rel'=>'hostel'

            ]);
        }

        for ($i = 1; $i < 10; $i++){

            if($request->hasFile('image'.$i)){
                DB::table('images')->insert([

                    'rel_id'=>$hostel->id,
                    'filename'=>$request->file('image'.$i)->store(config('images.hostelsImages')),
                    'image_type'=>'image'.$i,
                    'rel'=>'hostel'

                ]);

            }
        }

        return redirect(route('hostels.show',['hostel'=>$hostel->id]))
            ->with(['success'=>$hostel->name.' créé avec succès']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $this->validator($request);

        $hostel_data = $request->only([
            'name',
            'description',
            'address_station',
            'email',
            'contact',
            'tel1',
            'tel2'
        ]);

        $hostel_data['user_id'] = Auth::id();

        $hostel = Hostel::create($hostel_data);

        $this->saveOptions($request,$hostel);

        return redirect(route('hostels.create.images',['hostel'=>$hostel->id]));
    }

    /**
     * @param $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validator($request)
    {
        $rules = [
            'name'=>'filled',
            'hostel_id'=>'filled|exist:hostels,id',
            'description'=>'filled',
            'address_station'=>'filled',
            'email'=>'filled|email',
            'contact'=>'filled',
            'front_image'=>'filled|image'
        ];

        $this->validate($request,$rules);
    }

    public function saveOptions($request,$hostel)
    {
        $options = Option::where(['rel'=>'hostel'])->get();


        foreach ($options as $option){

            if($request->{$option->name}){

                $hostel->options()->syncWithoutDetaching($option->id);
            }

            if(!$request->{$option->name}){

                $hostel->options()->detach($option->id);
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hostel = Hostel::findOrFail($id);

        return view('hostels.show')->with(['hostel'=>$hostel]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hostel = Hostel::findOrFail($id);

        $this->checkUser(Auth::user(),$hostel->user);

        $options = Option::where(['rel'=>'hostel'])->get();

        return view('hostels.edit')->with(['hostel'=>$hostel,'options'=>$options]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Hostel $hostel
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validator($request);

        $hostel = Hostel::findOrFail($id);

        $hostel_data = $request->only([
            'name',
            'description',
            'address_station',
            'email',
            'contact',
            'tel1',
            'tel2'
        ]);

        $hostel->update($hostel_data);

        $this->saveOptions($request,$hostel);

        return redirect(route('hostels.show',['hostel'=>$hostel->id]))
            ->with(['success'=>$hostel->name.' modifié avec succès']);
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
