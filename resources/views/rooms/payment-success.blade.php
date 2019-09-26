@extends('layouts.app')

@section('title')

    Paiement réussi
@endsection

@section('content')
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Paiement réussi!</h5>
        Merci pour votre paiement.
    </div>


@endsection