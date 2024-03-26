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
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('baptism_list') }}">List Baptism</a></li>
        <li class="breadcrumb-item active font-weight-bold" aria-current="page">Edit Baptismi</li>
      </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form id="formAdd" action="{{ route('baptism_update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $baptismNya['id'] }}">
                <div class="card my-1">
                    <div class="card-header">
                        <h5 class="text-center font-weight-bold m-0">Data Baptism</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" required="" placeholder="Nama" value="{{$baptismNya['name']  }}">
                            </div>
                            <div class="form-group col-md-3 col-12">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required="" placeholder="Tempat Lahir" value="{{ $baptismNya['tempat_lahir'] }}">
                            </div>
                            <div class="form-group col-md-3 col-12">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required="" placeholder="Tanggal Lahir" value="{{ $baptismNya['tgl_lahir'] }}">
                            </div>
                            <div class="form-group col-md-3 col-12">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" aria-label="" required="">
                                    <option value="" disabled="">Pilih Gender</option>
                                    <option value="pria" {{ $baptismNya['gender'] == 'pria' ? 'selected': '' }}>Pria</option>
                                    <option value="wanita" {{ $baptismNya['gender'] == 'wanita' ? 'selected': '' }}>Wanita</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 col-12">
                                <label for="phone">No. Telp</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required="" placeholder="No. Telp" value="{{ $baptismNya['phone'] }}">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="father_name">Nama Ayah</label>
                                <input type="text" class="form-control" id="father_name" name="father_name" required="" placeholder="Nama Ayah" value="{{ $baptismNya['father_name'] }}">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="mother_name">Nama Ibu</label>
                                <input type="text" class="form-control" id="mother_name" name="mother_name" required="" placeholder="Nama Ibu" value="{{ $baptismNya['mother_name'] }}">
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address_bless">Alamat</label>
                                    <select class="js-example-basic-single form-control" name="district_id">
                                        <option value="" disabled="" selected="">Pilih Daerah</option>
                                        @foreach($subDistricts as $perDistrict)
                                            <option value="{{ $perDistrict['id'] }}" {{ $perDistrict['id'] == $baptismNya['district_id'] ? 'selected' : '' }}>{{ $perDistrict['province'] }}, {{ $perDistrict['city'] }}, {{ $perDistrict['subdistrict_name'] }}</option>
                                        @endforeach
                                    </select>
                                    <textarea class="form-control" id="alamat" rows="5" name="alamat" required="">{{ $baptismNya['alamat'] }}</textarea>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label for="baptism_date">Tanggal Baptis</label>
                                <input type="date" class="form-control" id="baptism_date" name="baptism_date" required="" placeholder="Tanggal Baptis" value="{{ $baptismNya['baptism_date'] }}">
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="consellour_id">Konselor oleh Pastor</label>
                                    <select class="js-example-basic-single form-control" required="" name="consellour_id">
                                        <option value="" disabled="">Pilih Pastor</option>
                                        @foreach($pastors as $pastor)
                                            <option value="{{ $pastor['id'] }}" {{ $pastor['id'] == $baptismNya['consellour_id '] ? 'selected' : '' }}>{{ $pastor['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="baptized_by_id">Baptis oleh Pastor</label>
                                    <select class="js-example-basic-single form-control" required="" name="baptized_by_id">
                                        <option value="" disabled="">Pilih Pastor</option>
                                        @foreach($pastors as $pastor)
                                            <option value="{{ $pastor['id'] }}" {{ $pastor['id'] == $baptismNya['baptized_by_id '] ? 'selected' : '' }}>{{ $pastor['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Deskripsi / Keterangan</label>
                                    <textarea class="form-control" id="description" rows="5" name="description">{{ $baptismNya['description'] }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card my-1">
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
        });
    </script>
@endsection