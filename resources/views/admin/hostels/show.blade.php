@extends('layouts.app')

@section('title')

    {{$hostel->name}}

    @if(!$hostel->isVerified())
        <a  href="" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Valider</a>
        <a  href="" class="btn btn-warning btn-sm"><i class="fa fa-close"></i> Rejeter</a>
        <a  href="" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Supprimer</a>
    @else
        <a  href="" class="btn btn-warning btn-sm"><i class="fa fa-close"></i> Invalider</a>
        <a  href="" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Supprimer</a>
    @endif
@endsection

@section('content')

    <!-- Default box -->
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3 class="d-inline-block d-sm-none">{{$hostel->name}}</h3>
                    <div class="col-12">
                        <img src="{{$hostel->front_image}}" class="product-image" alt="Product Image">
                    </div>

                    @if($hostel->images->take(5))
                        <div class="col-12 product-image-thumbs">
                            @foreach($hostel->images as $image)
                                <div class="product-image-thumb @if($image->filename == $hostel->front_image) active @endif"><img src="{{$image->filename}}" alt="Hostel Image"></div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-12 col-sm-6">
                    <h3 class="my-3">{{$hostel->name}}
                        <a  href="{{route('admin.hostels',['option'=>'verified'])}}" class="btn btn-default btn-sm"><i class="fas fa-backward"></i> Retour à la liste des hôtels</a>

                    </h3>
                    <a href="" class="btn-link text-decoration-none"><i class="fas fa-map-marker-alt"></i> {{$hostel->address_station}}</a>

                    <p>{{$hostel->description}}.</p>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            @if($hostel->options)
                                <h4 class="mt-3">Options <small></small></h4>
                                <ul class="list-unstyled">

                                    @foreach($hostel->options as $option)
                                        <li>
                                            <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> {{$option->option}}</a>
                                        </li>
                                    @endforeach

                                </ul>
                            @endif
                        </div>
                        <div class="col-md-6 col-12">

                            <div class="mt-4 product-share">
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> {{$hostel->address_station}}</li>
                                    <li><span class="fa-li"><i class="fas fa-lg fa-mail-bulk"></i></span><a href="mailto:{{$hostel->email}}">{{$hostel->email}}</a></li>
                                    <li><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><a href="tel:{{$hostel->contact}}">{{$hostel->contact}}</a></li>
                                    <li><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><a href="tel:{{$hostel->tel1}}">{{$hostel->tel1}}</a></li>
                                    <li><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><a href="tel:{{$hostel->tel2}}">{{$hostel->tel2}}</a></li>

                                </ul>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
            <hr>

            <!-- /.card-header -->
            @if($hostel->rooms)
                <div class="row">

                    @foreach($hostel->rooms as $room)
                        <div class="col-md-4 col-12">

                            <div class="card-body">
                                <h4 class="mt-3">{{$room->name}} <small></small></h4>

                                <img class="img-fluid pad" style="height: 200px; width: 100%" src="{{$room->front_image}}" alt="Room Image">

                                <div class="bg-gray py-2 px-3 mb-3">
                                    <h2 class="mb-0">
                                        {{$room->price_night_estimated}} XAF
                                    </h2>
                                    <h4 class="mt-0">
                                        <small>/Nuit</small>
                                    </h4>
                                </div>
                                <span class="text-muted"> {{$room->nbr_rental}}  @if($room->nbr_rental > 1)réservations @else réservation @endif</span>


                                <a  href="{{route('admin.hostels.rooms.show',['hostel'=>$hostel->id,'room'=>$room->id])}}" class="btn btn-default btn-sm">Afficher</a>

                            </div>

                        </div>
                    @endforeach
                </div>

            @endif
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
