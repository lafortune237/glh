<?php
/**
 * Created by PhpStorm.
 * User: kuatekevin
 * Date: 18/09/2019
 * Time: 19:17
 */
?>


@extends('layouts.app')

@section('css')
    @parent
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
@endsection

@section('title')

    Hôtels en attente de vérification
@endsection

@section('content')

    <div class="card">

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Addresse</th>
                    <th>Contact</th>
                    <th>Propriétaire</th>
                    <th>Date</th>
                    <th>Prix min</th>
                    <th>Prix max</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($hostels as $hostel)
                    <tr>
                        <td>{{$hostel->name}}</td>
                        <td>{{$hostel->address_station}}</td>
                        <td>{{$hostel->contact}}</td>
                        <td>{{$hostel->user->fullname}}</td>
                        <td>{{$hostel->created_at}}</td>
                        <td>@if($hostel->rooms()) {{$hostel->rooms()->min('price_night')}} XAF @endif</td>
                        <td>@if($hostel->rooms()) {{$hostel->rooms()->max('price_night')}} XAF @endif</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="{{route('admin.hostels.show',['hostel'=>$hostel->id])}}">Afficher</a>
                                    <a class="dropdown-item" href="#">Valider</a>
                                    <a class="dropdown-item" href="#">Rejeter</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Supprimer</a>
                                </div>
                            </div></td>

                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Nom</th>
                    <th>Addresse</th>
                    <th>Contact</th>
                    <th>Propriétaire</th>
                    <th>Date</th>
                    <th>Prix min</th>
                    <th>Prix max</th>
                    <th>Actions</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@section('js')
    @parent

    <!-- DataTables -->
    <script src="/assets/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>
@endsection