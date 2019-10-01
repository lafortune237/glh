@extends('layouts.app')

@section('title')
    Ajouter un Hôtel - Ajouter des images
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">

            <div class="card card-primary">

                <div class="card-body">
                    <form action="{{route('hostels.rooms.create.images',['hostel'=>$room->hostel->id,'room'=>$room->id])}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <label for="inputName">Image principale*</label>

                            <div class="form-group">

                                <div class="col-sm-12">

                                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">Parcourir… <input name="front_image" type="file" onchange="readURL(this,'#img-upload1')" id="imgInp"></span></span>
                                        <input required type="text"  class="form-control" readonly>
                                    </div>
                                    <img style="max-width: 350px; max-height: 250px" src="" id='img-upload1'/>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">Parcourir… <input name="image1" type="file" onchange="readURL(this,'#img-upload2')" id="imgInp"></span></span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img src="" class="img-upload" id='img-upload2'/>
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">Parcourir… <input name="image2" type="file" onchange="readURL(this,'#img-upload3')" id="imgInp"></span></span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img src="" class="img-upload" id='img-upload3'/>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">Parcourir… <input name="image3" type="file" onchange="readURL(this,'#img-upload4')" id="imgInp"></span></span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img src="" class="img-upload" id='img-upload4'/>
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">

                                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">Parcourir… <input name="image4" type="file" onchange="readURL(this,'#img-upload5')" id="imgInp"></span></span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img src="" class="img-upload" id='img-upload5'/>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">Parcourir… <input name="image5" type="file" onchange="readURL(this,'#img-upload6')" id="imgInp"></span></span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img src="" class="img-upload" id='img-upload6'/>
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">Parcourir… <input name="image6" type="file" onchange="readURL(this,'#img-upload7')" id="imgInp"></span></span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img src="" class="img-upload" id='img-upload7'/>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">Parcourir… <input type="file" name="image7" onchange="readURL(this,'#img-upload8')" id="imgInp"></span></span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img src="" class="img-upload" id='img-upload8'/>
                                </div>
                            </div>


                            <div class="col-sm-6">

                                <div class="form-group">
                                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">Parcourir… <input name="image8" type="file" onchange="readURL(this,'#img-upload9')" id="imgInp"></span></span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img src="" class="img-upload" id='img-upload9'/>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">Parcourir… <input name="image9" type="file" onchange="readURL(this,'#img-upload10')" id="imgInp"></span></span>
                                    <input type="text" class="form-control" readonly>
                                </div>
                                <img src="" class="img-upload" id='img-upload10'/>
                            </div>
                        </div>

                        <input type="submit" value="Enregistrer" class="btn btn-success float-right">
                    </form>


                </div>
                <!-- /.card-body -->
            </div>

        </div>


    </div>


@endsection

@section('js')
    @parent

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="/assets/js/upload-images.js"></script>

@endsection