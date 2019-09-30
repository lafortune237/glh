@extends('layouts.app')

@section('title')

    Payer ma réservation - <i class="fas fa-lock"></i> Paiement sécurisé
@endsection

@section('content')

    <!-- Default box -->
    <div class="card">

        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-7 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Du <b>{{$selection->date_start_human}}</b> </span>
                                    <span class="info-box-text text-center text-muted">Au <b>{{$selection->date_end_human}}</b> </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">
                                        <b>
                                            @if($selection->nbr_hours)
                                                {{$selection->nbr_hours}}
                                            @else
                                                {{$selection->nbr_nights}}
                                            @endif
                                        </b>
                                        @if($selection->nbr_hours)
                                            heures
                                        @else
                                            @if($selection->nbr_nights > 0)
                                                nuits
                                            @else
                                                nuit
                                            @endif
                                        @endif
                                    </span>

                                    <span class="info-box-text text-center text-muted">
                                        <b>
                                            @if($selection->rooms())
                                                {{$selection->rooms()->count()}}
                                            @endif
                                        </b>
                                        @if($selection->nbr_rooms > 1)
                                            chambres
                                        @else
                                            chambre
                                        @endif
                                    </span>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Prix total</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{$selection->total}} XAF<span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-12">

                            <div class="form-group mt-3">

                                <label for="account_owner">Nom et prénom sur la carte</label>

                                <div class="input-group">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input name="account_owner" type="text" class="form-control @error('account_owner') is-invalid @enderror" id="account_owner">

                                </div>
                                @error('account_owner')
                                <span class="invalid-feedback" role="alert">
                                       <strong>{{$message}}</strong>
                                   </span>
                                @enderror
                            </div>

                        </div>


                    </div>

                    <div class="row">

                        <div class="col-6">

                            <div class="form-group mt-3">
                                <label for="account_nbr">Numéro sur la carte</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                    </div>
                                    <input name="account_nbr" id="account_nbr" type="text" class="form-control @error('account_nbr') is-invalid @enderror" data-inputmask='"mask": "9999 9999 9999 9999"' data-mask placeholder="XXXX XXXX XXXX XXXX">
                                </div>
                                <!-- /.input group -->
                            </div>
                            @error('account_nbr')
                            <span class="invalid-feedback" role="alert">
                                       <strong>{{$message}}</strong>
                                   </span>
                            @enderror

                        </div>

                        <div class="col-6">
                            <label for="exampleInputEmail1"></label>

                            <div class="form-group" style="margin-top: 25px">
                                <div class="row">
                                    <div class="col-4">
                                        <input name="month" id="month" type="text" class="form-control @error('month') is-invalid @enderror" data-inputmask='"mask": "99"' data-mask placeholder="jj">

                                    </div>
                                    <div class="col-4">

                                        <input name="year" id="year" type="text" class="form-control @error('year') is-invalid @enderror" data-inputmask='"mask": "9999"' data-mask placeholder="aaaa">

                                    </div>
                                    <div class="col-4">
                                        <input name="cvv" id="cvv" type="text" class="form-control @error('cvv') is-invalid @enderror" data-inputmask='"mask": "999"' data-mask placeholder="cvv">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <!-- /.card -->
                            </div>

                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    J'ai lu et j'accepte <a href="#0">les conditions de réservation</a>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-6">
                            <div class="form-group" style="margin-top: 10px; border-radius: 4px !important;">
                                <a class="btn btn-default shadow">
                                    Annuler
                                </a>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group" style="margin-top: 10px; border-radius: 4px !important;">
                                <button onclick="
                            event.preventDefault();

                                document.getElementById('book-room').submit()"
                                        type="submit" class="btn btn-success shadow">
                                    Confirmer et payer {{$selection->total}} XAF
                                </button>
                            </div>
                        </div>



                    </div>



                </div>
                <div class="col-12 col-md-12 col-lg-5 order-2 order-md-2">
                    <div class="card card-info">
                        <div class="card-body p-0">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Hôtel</th>

                                    <th>@if($selection->rooms->count() > 1) Chambres @else Chambre @endif</th>
                                    <th>Prix</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($selection->rooms as $room)
                                    <tr>
                                        <td>Hôtel {{$room->hostel->name}}</td>

                                        <td>{{$room->name}}</td>
                                        <td>@if($selection->nbr_hours)
                                                {{$room->price_hour_estimated}} /Heure
                                            @else
                                                {{$room->price_night_estimated}} XAF /Nuit
                                            @endif

                                        </td>
                                        <td class="text-right py-0 align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <a target="_blank" href="{{route('hostels.rooms.booking',['hostel'=>$room->hostel->id,'room'=>$room->id])}}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                @if($room->isAvailable())
                                                    <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <p class="lead">Méthodes de paiement:</p>
                    <img src="/assets/dist/img/credit/visa.png" alt="Visa">
                    <img src="/assets/dist/img/credit/mastercard.png" alt="Mastercard">
                    <img src="/assets/dist/img/credit/american-express.png" alt="American Express">
                    <img src="/assets/dist/img/credit/paypal2.png" alt="Paypal">

                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>

@endsection

@section('js')
    @parent
    <script src="/assets/plugins/inputmask/jquery.inputmask.bundle.js"></script>

    <script>
        $('[data-mask]').inputmask()

    </script>
@endsection