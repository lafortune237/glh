@extends('layouts.app')

@section('title')
    Modifier une chambre
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">

            <div class="card card-primary">

                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Project Name</label>
                        <input type="text" id="inputName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Project Description</label>
                        <textarea id="inputDescription" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Status</label>
                        <select class="form-control custom-select">
                            <option selected disabled>Select one</option>
                            <option>On Hold</option>
                            <option>Canceled</option>
                            <option>Success</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputClientCompany">Client Company</label>
                        <input type="text" id="inputClientCompany" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Project Leader</label>
                        <input type="text" id="inputProjectLeader" class="form-control">
                    </div>

                    <input type="submit" value="Suivant" class="btn btn-success float-right">

                </div>
                <!-- /.card-body -->
            </div>

        </div>


    </div>


@endsection
