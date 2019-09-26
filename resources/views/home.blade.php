@extends('layouts.app')

@section('breadcrumb') @endsection

@section('custom-css')
    {{
    '.content-header{
    background-image: url(/img/even-hotels-eugene-5405616297-4x3_2.jpg);
    height:500px;
    background-size: cover;
    }'
    }}
@endsection

@section('form-search')
    <!-- SEARCH FORM -->


    <div class="col-10 col-lg-6 offset-1 offset-lg-3 form-search">

        <form class="form-inline ml-3">
            <label for="address_station" class="text-white text-xl mb-4">
                Besoin d'une Chambre d'Hôtel?
            </label>
            <div class="input-group input-group-lg">

                <input name="address_station" id="address_station" class="form-control form-control-navbar input-search" type="search" placeholder="Indiquez un lieu..." aria-label="Search">
                <div class="input-group-append ">
                    <button class="btn btn-success" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>


        </form>

    </div>




@endsection

@section('content')

    <div class="card card-solid" style="margin-top: 30px">

        <div class="card-body">
            <div class="row">

                @foreach($hostels as $hostel)
                    <div class="col-md-4 col-12">

                        <div class="card-body">
                            <h4 class="mt-3">Hôtel {{$hostel->name}} <small></small></h4>

                            <img class="img-fluid pad" style="height: 200px; width: 100%" src="{{$hostel->front_image}}" alt="Photo">

                            <div class="bg-dark py-2 px-3 mb-3">
                                <h3 class="mb-0">
                                   À partir de {{$hostel->min_price}} XAF
                                </h3>
                                <h4 class="mt-0">
                                    <small>/Nuit</small>
                                </h4>
                            </div>
                            <span><i class="fas fa-map-marker-alt"></i> {{$hostel->address_station}}</span><br>

                            <span class="text-muted"> {{$hostel->nbr_rental}}  @if($hostel->nbr_rental > 1) réservations @else réservation @endif de chambre</span>

                            <a href="{{route('hostels.show',['hostel'=>$hostel->id])}}" class="btn btn-success">Consulter</a>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
