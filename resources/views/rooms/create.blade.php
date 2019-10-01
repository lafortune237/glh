@extends('layouts.app')

@section('title')
    Ajouter une chambre
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">

            <div class="card card-primary">

                <div class="card-body">
                    <form action="{{route('hostels.rooms.create',['hostel'=>$hostel->id])}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="inputName">Nom de la chambre (facultatif)</label>
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
                            <label for="category_id">Catégorie</label>
                            <select name="category_id" id="category_id" class="custom-select form-control @error('category_id') is-invalid @enderror">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                       <strong>{{$message}}</strong>
                                   </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nbr_beds">Nombre de lits*</label>
                            <input name="nbr_beds" min="1" value="1" type="number" id="nbr_beds" class="form-control @error('nbr_beds') is-invalid @enderror">
                            @error('nbr_beds')
                            <span class="invalid-feedback" role="alert">
                                       <strong>{{$message}}</strong>
                                   </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nbr_people">Nombre de personnes*</label>
                            <input name="nbr_people" min="1" value="1" type="number" id="nbr_people" class="form-control @error('nbr_people') is-invalid @enderror">
                            @error('nbr_people')
                            <span class="invalid-feedback" role="alert">
                                       <strong>{{$message}}</strong>
                                   </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price_hour">Prix horaire*</label>
                            <input name="price_hour" min="1" value="1" type="number" id="price_hour" class="form-control @error('price_hour') is-invalid @enderror">
                            @error('price_hour')
                            <span class="invalid-feedback" role="alert">
                                       <strong>{{$message}}</strong>
                                   </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price_night">Prix par nuit*</label>
                            <input name="price_night" min="1" value="1" type="number" id="price_night" class="form-control @error('price_night') is-invalid @enderror">
                            @error('price_night')
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

                        <input type="submit" value="Suivant" class="btn btn-success float-right">
                    </form>


                </div>
                <!-- /.card-body -->
            </div>

        </div>


    </div>


@endsection
