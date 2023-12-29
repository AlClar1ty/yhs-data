@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <link rel="stylesheet" href="{{ asset("css/select2-bootstrap4.min.css") }}" />
    <style>
        img{
            max-height: 2em;
        }        
        .select2-selection__rendered {
            line-height: 38px !important;
        }
        .select2-container .select2-selection--single {
            height: 38px !important;
            margin-bottom: 16px;
        }

        .select2-container--bootstrap4 .select2-results__group {
            color: black;
        }
        .select2-selection__arrow{
            margin-top: 0.3em;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('index') }}">List Data</a></li>
        <li class="breadcrumb-item active font-weight-bold" aria-current="page">Add Data</li>
      </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form id="formAdd" action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card my-1">
                    <div class="card-header">
                        <h5 class="text-center font-weight-bold m-0">Data Classification</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="status_perinkahan">Status Pernikahan</label>
                                <select class="form-control" id="status_perinkahan" name="status_perinkahan" aria-label="" required="">
                                    <option value="" selected="" disabled="">Pilih Status</option>
                                    <option value="single">Belum Menikah</option>
                                    <option value="married">Menikah</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="single-group" class="d-none">
                    <div class="card my-1">
                        <div class="card-header">
                            <h5 class="text-center font-weight-bold m-0">Data Member</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-12">
                                    <label for="single_name">Nama</label>
                                    <input type="text" class="form-control" id="single_name" name="single_name" required="" placeholder="Nama">
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <label for="single_gender">Gender</label>
                                            <select class="form-control" id="single_gender" name="single_gender" aria-label="" required="">
                                                <option value="" selected="" disabled="">Pilih Gender</option>
                                                <option value="pria">Pria</option>
                                                <option value="wanita">Wanita</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4 col-12">
                                            <label for="single_phone">No. Telp</label>
                                            <input type="tel" class="form-control" id="single_phone" name="single_phone" required="" placeholder="No. Telp">
                                        </div>
                                        
                                        <div class="form-group col-md-4 col-12">
                                            <label for="single_baptis">Baptis</label>
                                            <select class="form-control" id="single_baptis" name="single_baptis" aria-label="" required="">
                                                <option value="" selected="" disabled="">Pilih Baptis</option>
                                                <option value="1">Sudah</option>
                                                <option value="0">Belum Baptis</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label for="single_tmpt_lahir">Tempat Lahir</label>
                                            <input type="text" class="form-control" id="single_tmpt_lahir" name="single_tmpt_lahir" required="" placeholder="Tempat Lahir">
                                        </div>

                                        <div class="form-group col-md-6 col-12">
                                            <label for="single_tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="single_tgl_lahir" name="single_tgl_lahir" required="" placeholder="Tanggal Lahir">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="single_alamat">Alamat</label>
                                        <select class="js-example-basic-single form-control" name="single_district">
                                            @php $currentCity = ""; @endphp
                                            @foreach($subDistricts as $perDistrict)
                                                <option value="{{ $perDistrict['id'] }}">{{ $perDistrict['province'] }}, {{ $perDistrict['city'] }}, {{ $perDistrict['subdistrict_name'] }}</option>
                                            @endforeach
                                        </select>
                                        <textarea class="form-control" id="single_alamat" rows="5" name="single_address" required=""></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="family-group" class="d-none">
                    <div class="card my-1">
                        <div class="card-header">
                            <h5 class="text-center font-weight-bold m-0">Data Suami</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label for="suami_name">Nama Suami</label>
                                            <input type="text" class="form-control need_required" id="suami_name" name="suami_name" required="" placeholder="Nama">
                                        </div>

                                        <div class="form-group col-md-4 col-12">
                                            <label for="suami_phone">No. Telp Suami</label>
                                            <input type="tel" class="form-control need_required" id="suami_phone" name="suami_phone" required="" placeholder="No. Telp">
                                        </div>
                                        
                                        <div class="form-group col-md-2 col-12">
                                            <label for="suami_baptis">Baptis</label>
                                            <select class="form-control need_required" id="suami_baptis" name="suami_baptis" aria-label="" required="">
                                                <option value="" selected="" disabled="">Pilih Baptis</option>
                                                <option value="1">Sudah</option>
                                                <option value="0">Belum Baptis</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label for="suami_tmpt_lahir">Tempat Lahir Suami</label>
                                            <input type="text" class="form-control need_required" id="suami_tmpt_lahir" name="suami_tmpt_lahir" required="" placeholder="Tempat Lahir">
                                        </div>

                                        <div class="form-group col-md-6 col-12">
                                            <label for="suami_tgl_lahir">Tanggal Lahir Suami</label>
                                            <input type="date" class="form-control need_required" id="suami_tgl_lahir" name="suami_tgl_lahir" required="" placeholder="Tanggal Lahir">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card my-1">
                        <div class="card-header">
                            <h5 class="text-center font-weight-bold m-0">Data Istri</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label for="istri_name">Nama Istri</label>
                                            <input type="text" class="form-control need_required" id="istri_name" name="istri_name" placeholder="Nama">
                                        </div>

                                        <div class="form-group col-md-4 col-12">
                                            <label for="istri_phone">No. Telp Istri</label>
                                            <input type="text" class="form-control need_required" id="istri_phone" name="istri_phone" placeholder="No. Telp">
                                        </div>

                                        <div class="form-group col-md-2 col-12">
                                            <label for="istri_baptis">Baptis</label>
                                            <select class="form-control need_required" id="istri_baptis" name="istri_baptis" aria-label="">
                                                <option value="" selected="" disabled="">Pilih Baptis</option>
                                                <option value="1">Sudah</option>
                                                <option value="0">Belum Baptis</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label for="istri_tmpt_lahir">Tempat Lahir Istri</label>
                                            <input type="text" class="form-control need_required" id="istri_tmpt_lahir" name="istri_tmpt_lahir" placeholder="Tempat Lahir">
                                        </div>

                                        <div class="form-group col-md-6 col-12">
                                            <label for="istri_tgl_lahir">Tanggal Lahir Istri</label>
                                            <input type="date" class="form-control need_required" id="istri_tgl_lahir" name="istri_tgl_lahir" placeholder="Tanggal Lahir">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card my-1">
                        <div class="card-header">
                            <h5 class="text-center font-weight-bold m-0">Data Lainnya</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="tgl_pernikahan">Tanggal Pernikahan</label>
                                        <input type="date" class="form-control need_required" id="tgl_pernikahan" name="tgl_pernikahan">
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <select class="js-example-basic-single form-control need_required" name="district">
                                            @php $currentCity = ""; @endphp
                                            @foreach($subDistricts as $perDistrict)
                                                <option value="{{ $perDistrict['id'] }}">{{ $perDistrict['province'] }}, {{ $perDistrict['city'] }}, {{ $perDistrict['subdistrict_name'] }}</option>
                                            @endforeach
                                        </select>
                                        <textarea class="form-control need_required" id="alamat" rows="5" name="address" required=""></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @for($i = 1; $i <= 3; $i++)
                        <div class="card my-1">
                            <div class="card-header">
                                <h5 class="text-center font-weight-bold m-0">Data Anak {{ $i }} (Optional)</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="anak_name_{{ $i }}">Nama Anak {{ $i }}</label>
                                        <input type="text" class="form-control" id="anak_name_{{ $i }}" name="anak_name[]" placeholder="Nama">
                                    </div>

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-group col-md-4 col-12">
                                                <label for="anak_gender_{{ $i }}">Gender</label>
                                                <select class="form-control" id="anak_gender_{{ $i }}" name="anak_gender[]" aria-label="">
                                                    <option value="" selected="" disabled="">Pilih Gender</option>
                                                    <option value="pria">Pria</option>
                                                    <option value="wanita">Wanita</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4 col-12">
                                                <label for="anak_phone_{{ $i }}">No. Telp Anak {{ $i }}</label>
                                                <input type="text" class="form-control" id="anak_phone_{{ $i }}" name="anak_phone[]" placeholder="No. Telp">
                                            </div>
                                            
                                            <div class="form-group col-md-4 col-12">
                                                <label for="anak_baptis_{{ $i }}">Baptis</label>
                                                <select class="form-control" id="anak_baptis_{{ $i }}" name="anak_baptis[]" aria-label="">
                                                    <option value="" selected="" disabled="">Pilih Baptis</option>
                                                    <option value="1">Sudah</option>
                                                    <option value="0">Belum Baptis</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <label for="anak_tmpt_lahir_{{ $i }}">Tempat Lahir Anak {{ $i }}</label>
                                                <input type="text" class="form-control" id="anak_tmpt_lahir_{{ $i }}" name="anak_tmpt_lahir[]" placeholder="Tempat Lahir">
                                            </div>

                                            <div class="form-group col-md-6 col-12">
                                                <label for="anak_tgl_lahir_{{ $i }}">Tanggal Lahir Anak {{ $i }}</label>
                                                <input type="date" class="form-control" id="anak_tgl_lahir_{{ $i }}" name="anak_tgl_lahir[]" placeholder="Tanggal Lahir">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="default_none d-none card my-1">
                    <div class="card-header">
                        <h5 class="text-center font-weight-bold m-0">Foto Member</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="photo">Upload Foto</label>
                                <input type="file" class="form-control" id="photo" name="photo" placeholder="Upload Foto" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="default_none d-none card my-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success w-100">Add Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section("script")
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();

            $("form#formAdd :input").each(function(){
                if($(this).attr('id') != "status_perinkahan"){
                    $(this).removeAttr('required', false);
                }
            });

            $("#status_perinkahan").change(function(e) {
                $(".default_none").removeClass("d-none");

                if($(this).val() == "married"){
                    $("#single-group").addClass("d-none");
                    $("#single-group :input").each(function(){
                        $(this).removeAttr('required');
                    });

                    $("#family-group").removeClass("d-none");
                    $(".need_required").each(function(){
                        $(this).attr('required', true);
                    });
                }
                else{
                    $("#family-group").addClass("d-none");
                    $("#family-group :input").each(function(){
                        $(this).removeAttr('required');
                    });

                    $("#single-group").removeClass("d-none");
                    $("#single-group :input").each(function(){
                        $(this).attr('required', true);
                    });
                }
            });
        });
    </script>
@endsection