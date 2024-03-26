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
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('wedding_list') }}">List Wedding Bless</a></li>
        <li class="breadcrumb-item active font-weight-bold" aria-current="page">Add Wedding Bless</li>
      </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form id="formAdd" action="{{ route('wedding_update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $weddingBlessNya['id'] }}">
                <div class="card my-1">
                    <div class="card-header">
                        <h5 class="text-center font-weight-bold m-0">Data Wedding Blessing</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label for="male_name">Nama Mempelai Pria</label>
                                <input type="text" class="form-control" id="male_name" name="male_name" required="" placeholder="Nama Mempelai Pria" value="{{ $weddingBlessNya['male_name'] }}">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="female_name">Nama Mempelai Wanita</label>
                                <input type="text" class="form-control" id="female_name" name="female_name" required="" placeholder="Nama Mempelai Wanita" value="{{ $weddingBlessNya['female_name'] }}">
                            </div>
                            <div class="form-group col-12">
                                <label for="datetime_bless">Jam & Tanggal Pemberkatan</label>
                                <input type="datetime-local" class="form-control" id="datetime_bless" name="datetime_bless" required="" placeholder="Jam & Tanggal Pemberkatan" value="{{ $weddingBlessNya['datetime_bless'] }}">
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address_bless">Alamat Pemberkatan</label>
                                    <select class="js-example-basic-single form-control" name="district_id">
                                        <option value="" disabled="">Pilih Daerah</option>
                                        @foreach($subDistricts as $perDistrict)
                                            <option value="{{ $perDistrict['id'] }}" {{ $perDistrict['id'] == $weddingBlessNya['district_id'] ? 'selected' : '' }}>{{ $perDistrict['province'] }}, {{ $perDistrict['city'] }}, {{ $perDistrict['subdistrict_name'] }}</option>
                                        @endforeach
                                    </select>
                                    <textarea class="form-control" id="address_bless" rows="5" name="address_bless" required="">{{ $weddingBlessNya['address_bless'] }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="pastor_bless">Dilayani oleh Pastor</label>
                                    <select class="js-example-basic-single form-control" name="pastor_id">
                                        <option value="" disabled="">Pilih Pastor</option>
                                        @foreach($pastors as $pastor)
                                            <option value="{{ $pastor['id'] }}" {{ $pastor['id'] == $weddingBlessNya['pastor_id'] ? 'selected' : '' }}>{{ $pastor['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Deskripsi / Keterangan</label>
                                    <textarea class="form-control" id="description" rows="5" name="description">{{ $weddingBlessNya['description'] }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card my-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success w-100">Change Data</button>
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