
@extends('layouts.app')

@section('title')
    Mes réservations
@endsection

@section('content')

    <div class="row">
        <div class="col-12 col-md-9 offset-md-1">
            <div class="card card-solid">

                <div class="card-body">

                    @if(!$reservations->isEmpty())
                        @foreach($reservations as $reservation)

                            @foreach($reservation->rooms as $room)
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{$room->hostel->front_image}}" alt="hostel image">
                                        <span class="username">
                          <a href="{{route('hostels.show',['hostel'=>$room->hostel->id])}}">{{$room->hostel->name}}</a>
                        </span>
                                        <span class="description">{{$room->name}}  - {{$reservation->created_at}} </span>
                                    </div>
                                    <!-- /.user-block -->

                                    <p>
                                        <b> | du {{$reservation->date_start_human}}</b>
                                        --> <b>{{$reservation->date_end_human}}</b>
                                        <span class="badge badge-dark">@if($reservation->nbr_nights) {{$reservation->nbr_nights}} Nuits @else {{$reservation->nbr_hours}}  Heures @endif</span>

                                        <span class="badge badge-success"> {{$reservation->payment->total}} XAF</span>

                                        @if($reservation->timing == \App\Reservation::ONGOING_RENTAL)
                                            <span class="badge badge-warning"> En cours</span>
                                        @endif

                                        @if($reservation->timing == \App\Reservation::UPCOMING_RENTAL)
                                            <span class="badge badge-primary"> À venir</span>
                                        @endif

                                        @if($reservation->timing == \App\Reservation::CLOSED_RENTAL)
                                            <span class="badge badge-dark"> Terminée</span>
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        @endforeach
                    @else
                        <div class="col-8 offset-2 col-md-4 offset-md-4">

                            Aucune réservation <br>
                            <a  href="{{route('home')}}" class="btn btn-success btn-sm">Trouver un Hôtel</a>

                        </div>

                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection



