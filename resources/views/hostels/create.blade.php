@extends('layouts.app')

@section('title')
    Ajouter un Hôtel
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">

            <div class="card card-primary">

                <div class="card-body">
                    <form action="{{route('hostels.create')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="inputName">Nom de l'hôtel*</label>
                            <input name="name" type="text" id="inputName" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                       <strong>{{$message}}</strong>
                                   </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description*</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4"></textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                       <strong>{{$message}}</strong>
                                   </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label  for="email">Email*</label>
                            <input value="{{Auth::user()->email}}" name="email" type="text" id="address_station" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                       <strong>{{$message}}</strong>
                                   </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label  for="address_station">Adresse*</label>
                            <input name="address_station" type="text" id="address_station" class="form-control @error('address_station') is-invalid @enderror">
                            @error('address_station')
                            <span class="invalid-feedback" role="alert">
                                       <strong>{{$message}}</strong>
                                   </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contact">FAX*</label>
                            <input type="tel" id="contact" name="contact" class="form-control @error('name') is-invalid @enderror">
                            @error('contact')
                            <span class="invalid-feedback" role="alert">
                                       <strong>{{$message}}</strong>
                                   </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contact">Options</label>

                            @foreach($options as $option)
                            <div class="custom-control custom-checkbox pb-2">
                                <input class="custom-control-input" type="checkbox" id="customCheckbox{{$option->id}}" name="{{$option->name}}">
                                <label for="customCheckbox{{$option->id}}" class="custom-control-label"><i style="margin-right: 4px; margin-left: -16px" class="{{$option->icon}}"></i>  {{$option->option}}</label>
                            </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="tel1">Tel. 1 (facultatif)</label>
                            <input type="tel" id="tel1" name="tel1" class="form-control @error('tel1') is-invalid @enderror">
                            @error('tel1')
                            <span class="invalid-feedback" role="alert">
                                       <strong>{{$message}}</strong>
                                   </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tel2">Tel. 2 (facultatif)</label>
                            <input type="tel" id="tel2" name="tel2" class="form-control @error('tel2') is-invalid @enderror">
                            @error('tel2')
                            <span class="invalid-feedback" role="alert">
                                       <strong>{{$message}}</strong>
                                   </span>
                            @enderror
                        </div>


                        <input type="submit" value="Suivant" class="btn btn-success float-right">
                    </form>


                </div>
                <!-- /.card-body -->
            </div>

        </div>


    </div>


@endsection
