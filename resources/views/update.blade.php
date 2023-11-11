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
        <li class="breadcrumb-item active font-weight-bold" aria-current="page">Edit Data Bp. {{ $dataNya['name'] }}</li>
      </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{ route('update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $dataNya['id'] }}">
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
                                        <input type="text" class="form-control" id="suami_name" name="suami_name" required="" placeholder="Nama" value="{{ $dataNya['name'] }}">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label for="suami_phone">No. Telp Suami</label>
                                        <input type="tel" class="form-control" id="suami_phone" name="suami_phone" required="" placeholder="No. Telp" value="{{ $dataNya['phone'] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="suami_tmpt_lahir">Tempat Lahir Suami</label>
                                        <input type="text" class="form-control" id="suami_tmpt_lahir" name="suami_tmpt_lahir" required="" placeholder="Tempat Lahir" value="{{ $dataNya['tempat_lahir'] }}">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label for="suami_tgl_lahir">Tanggal Lahir Suami</label>
                                        <input type="date" class="form-control" id="suami_tgl_lahir" name="suami_tgl_lahir" required="" placeholder="Tanggal Lahir" value="{{ $dataNya['tgl_lahir'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @php
                    $childNya = $dataNya->child_member;
                @endphp

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
                                        <input type="text" class="form-control" id="istri_name" name="istri_name" required="" placeholder="Nama" value="{{ $childNya->where('type', 'istri')->first() != null ? $childNya->where('type', 'istri')->first()['name'] : "" }}">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label for="istri_phone">No. Telp Istri</label>
                                        <input type="text" class="form-control" id="istri_phone" name="istri_phone" required="" placeholder="No. Telp" value="{{ $childNya->where('type', 'istri')->first() != null ? $childNya->where('type', 'istri')->first()['phone'] : "" }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="istri_tmpt_lahir">Tempat Lahir Istri</label>
                                        <input type="text" class="form-control" id="istri_tmpt_lahir" name="istri_tmpt_lahir" required="" placeholder="Tempat Lahir" value="{{ $childNya->where('type', 'istri')->first() != null ? $childNya->where('type', 'istri')->first()['tempat_lahir'] : "" }}">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label for="istri_tgl_lahir">Tanggal Lahir Istri</label>
                                        <input type="date" class="form-control" id="istri_tgl_lahir" name="istri_tgl_lahir" required="" placeholder="Tanggal Lahir" value="{{ $childNya->where('type', 'istri')->first() != null ? $childNya->where('type', 'istri')->first()['tgl_lahir'] : "" }}">
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
                                    <input type="date" class="form-control" id="tgl_pernikahan" required="" name="tgl_pernikahan" value="{{ $dataNya['tgl_pernikahan'] }}">
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <select class="js-example-basic-single form-control" name="district">
                                        @php $currentCity = ""; @endphp
                                        @foreach($subDistricts as $perDistrict)
                                            <option value="{{ $perDistrict['id'] }}" {{ $perDistrict['id'] == $dataNya['district_id'] ? "selected" : "" }}>{{ $perDistrict['province'] }}, {{ $perDistrict['city'] }}, {{ $perDistrict['subdistrict_name'] }}</option>
                                        @endforeach
                                    </select>
                                    <textarea class="form-control" id="alamat" rows="5" name="address" required="">{{ $dataNya['alamat'] }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card my-1">
                    <div class="card-header">
                        <h5 class="text-center font-weight-bold m-0">Data Anak 1 (Optional)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="anak_name_1">Nama Anak 1</label>
                                        <input type="text" class="form-control" id="anak_name_1" name="anak_name[]" placeholder="Nama" value="{{ isset($childNya->where('type', 'anak')[1]) ? $childNya->where('type', 'anak')[1]['name'] : "" }}">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label for="anak_phone_1">No. Telp Anak 1</label>
                                        <input type="text" class="form-control" id="anak_phone_1" name="anak_phone[]" placeholder="No. Telp" value="{{ isset($childNya->where('type', 'anak')[1]) ? $childNya->where('type', 'anak')[1]['phone'] : "" }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="anak_tmpt_lahir_1">Tempat Lahir Anak 1</label>
                                        <input type="text" class="form-control" id="anak_tmpt_lahir_1" name="anak_tmpt_lahir[]" placeholder="Tempat Lahir" value="{{ isset($childNya->where('type', 'anak')[1]) ? $childNya->where('type', 'anak')[1]['tempat_lahir'] : "" }}">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label for="anak_tgl_lahir_1">Tanggal Lahir Anak 1</label>
                                        <input type="date" class="form-control" id="anak_tgl_lahir_1" name="anak_tgl_lahir[]" placeholder="Tanggal Lahir" value="{{ isset($childNya->where('type', 'anak')[1]) ? $childNya->where('type', 'anak')[1]['tgl_lahir'] : "" }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card my-1">
                    <div class="card-header">
                        <h5 class="text-center font-weight-bold m-0">Data Anak 2 (Optional)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="anak_name_2">Nama Anak 2</label>
                                        <input type="text" class="form-control" id="anak_name_2" name="anak_name[]" placeholder="Nama" value="{{ isset($childNya->where('type', 'anak')[2]) ? $childNya->where('type', 'anak')[2]['name'] : "" }}">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label for="anak_phone_2">No. Telp Anak 2</label>
                                        <input type="text" class="form-control" id="anak_phone_2" name="anak_phone[]" placeholder="No. Telp" value="{{ isset($childNya->where('type', 'anak')[2]) ? $childNya->where('type', 'anak')[2]['phone'] : "" }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="anak_tmpt_lahir_2">Tempat Lahir Anak 2</label>
                                        <input type="text" class="form-control" id="anak_tmpt_lahir_2" name="anak_tmpt_lahir[]" placeholder="Tempat Lahir" value="{{ isset($childNya->where('type', 'anak')[2]) ? $childNya->where('type', 'anak')[2]['tempat_lahir'] : "" }}">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label for="anak_tgl_lahir_2">Tanggal Lahir Anak 2</label>
                                        <input type="date" class="form-control" id="anak_tgl_lahir_2" name="anak_tgl_lahir[]" placeholder="Tanggal Lahir" value="{{ isset($childNya->where('type', 'anak')[2]) ? $childNya->where('type', 'anak')[2]['tgl_lahir'] : "" }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card my-1">
                    <div class="card-header">
                        <h5 class="text-center font-weight-bold m-0">Data Anak 3 (Optional)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="anak_name_3">Nama Anak 3</label>
                                        <input type="text" class="form-control" id="anak_name_3" name="anak_name[]" placeholder="Nama" value="{{ isset($childNya->where('type', 'anak')[3]) ? $childNya->where('type', 'anak')[3]['name'] : "" }}">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label for="anak_phone_3">No. Telp Anak 3</label>
                                        <input type="text" class="form-control" id="anak_phone_3" name="anak_phone[]" placeholder="No. Telp" value="{{ isset($childNya->where('type', 'anak')[3]) ? $childNya->where('type', 'anak')[3]['phone'] : "" }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="anak_tmpt_lahir_3">Tempat Lahir Anak 3</label>
                                        <input type="text" class="form-control" id="anak_tmpt_lahir_3" name="anak_tmpt_lahir[]" placeholder="Tempat Lahir" value="{{ isset($childNya->where('type', 'anak')[3]) ? $childNya->where('type', 'anak')[3]['tempat_lahir'] : "" }}">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label for="anak_tgl_lahir_3">Tanggal Lahir Anak 3</label>
                                        <input type="date" class="form-control" id="anak_tgl_lahir_3" name="anak_tgl_lahir[]" placeholder="Tanggal Lahir" value="{{ isset($childNya->where('type', 'anak')[3]) ? $childNya->where('type', 'anak')[3]['tgl_lahir'] : "" }}">
                                    </div>
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
