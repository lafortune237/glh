@extends('layouts.app')

@section('css')
    @parent
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="/assets/plugins/daterangepicker/daterangepicker.css">


    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">


    <link rel="stylesheet" href="/assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endsection

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

                <!-- /.card- -->
                    <div class="card-body">
                        <h4 class="mt-3">{{$room->hostel->name}}
                            <small></small></h4>

                        <a href="{{route('hostels.show',['hostel'=>$room->hostel->id])}}"><img class="img-fluid pad" style="height: 200px; width: 100%" src="{{$room->hostel->front_image}}" alt="Room Image"></a>


                        <a href="" class="btn-link text-decoration-none"><i class="fas fa-map-marker-alt"></i> {{$room->hostel->address_station}}</a>

                    </div>


                </div>
                <div class="col-12 col-sm-6">

                    <h3 class="my-3">{{$room->name}}</h3>

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
                                            <a href="" class="btn-link text-secondary"><i class="{{$option->icon}}"></i> {{$option->option}}</a>
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

                    <form method="post" action="{{route('hostels.rooms.book',['hostel'=>$room->hostel->id,'room'=>$room->id])}}" id="book-room">
                        @csrf
                        <div class="form-group-lg">
                            <label>Sélectionez des dates:</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control float-right" id="request_dates">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group" style="margin-top: 10px; border-radius: 4px !important;">
                            <a onclick="
                            event.preventDefault();
                            alert(document.getElementById('request_dates').value);
                            document.getElementById('reservation_dates').value = document.getElementById('request_dates').value;

                                document.getElementById('book-room').submit()"
                               type="submit" class="btn btn-success btn-lg btn-flat  shadow">
                                Réserver
                            </a>
                        </div>

                        <input type="hidden" name="request_dates" id="reservation_dates">
                    </form>

                </div>
            </div>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection

@section('js')
    @parent

    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="/assets/plugins/moment/moment.min.js"></script>
    <!-- date-range-picker -->
    <script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>


    <!-- Page script -->
    <script>
        $(function () {



            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#request_dates').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm'
                }
            })
        })
    </script>

@endsection