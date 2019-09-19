@extends('layouts.app')

@section('title')

    {{$room->name}}
@endsection

@section('content')

    <!-- Default box -->
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3 class="d-inline-block d-sm-none">{{$room->name}}</h3>
                    <div class="col-12">
                        <img src="{{$room->front_image}}" class="product-image" alt="Product Image">

                    </div>

                    @if($room->images->take(5))
                        <div class="col-12 product-image-thumbs">
                            @foreach($room->images as $image)
                                <div class="product-image-thumb @if($image->filename == $room->front_image) active @endif"><img src="{{$image->filename}}" alt="Room Image"></div>
                            @endforeach
                        </div>
                    @endif


                </div>
                <div class="col-12 col-sm-6">

                    <h3 class="my-3">{{$room->name}}
                        <a  href="{{route('hostels.rooms.edit',['hostel'=>$room->hostel->id,'room'=>$room->id])}}" class="btn btn-default btn-sm"><i class="fas fa-edit"></i> Modifier</a>
                            @if($room->isAvailable())
                                <a  href="{{route('hostels.edit',['hostel'=>$room->hostel->id])}}" class="btn btn-danger btn-sm"><i class="fas fa-edit"></i> Désactiver</a>
                            @else
                                <a  href="{{route('hostels.edit',['hostel'=>$room->hostel->id])}}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Activer</a>
                        @endif
                    </h3>

                    <a href="" class="btn-link text-decoration-none"><i class="fas fa-map-marker-alt"></i> {{$room->hostel->address_station}}</a>

                    <p>{{$room->description}}.</p>


                    <div class="row">
                        <div class="col-md-6 col-12">
                            @if($room->options || $room->nbr_beds || $room->nbr_people)
                                <h4 class="mt-3">Options <small></small></h4>
                                <ul class="list-unstyled">

                                    @if($room->nbr_beds)
                                        <li>
                                            <a href="" class="btn-link text-secondary"><i class="fas fa-bed"></i> {{$room->nbr_beds}} lits</a>
                                        </li>
                                    @endif
                                    @if($room->nbr_people)
                                        <li>
                                            <a href="" class="btn-link text-secondary"><i class="fas fa-person-booth"></i> {{$room->nbr_people}} personnes</a>
                                        </li>
                                    @endif
                                    @foreach($room->options as $option)
                                        <li>
                                            <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> {{$option->option}}</a>
                                        </li>
                                    @endforeach

                                </ul>
                            @endif
                        </div>
                        <div class="col-md-6 col-12">

                            <div class="mt-4 ml-3 product-share">
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> {{$room->hostel->address_station}}</li>
                                    <li><span class="fa-li"><i class="fas fa-lg fa-mail-bulk"></i></span><a href="mailto:{{$room->hostel->email}}">{{$room->hostel->email}}</a></li>
                                    <li><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><a href="tel:{{$room->hostel->contact}}">{{$room->hostel->contact}}</a></li>
                                    <li><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><a href="tel:{{$room->hostel->tel1}}">{{$room->hostel->tel1}}</a></li>
                                    <li><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><a href="tel:{{$room->hostel->tel2}}">{{$room->hostel->tel2}}</a></li>

                                </ul>
                            </div>


                        </div>
                    </div>

                    <div class="bg-gray py-2 px-3 mb-3">
                        <h2 class="mb-0">
                            {{$room->price_night_estimated}} XAF
                        </h2>
                        <h4 class="mt-0">
                            <small>/Nuit</small>
                        </h4>
                    </div>

                </div>
            </div>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
