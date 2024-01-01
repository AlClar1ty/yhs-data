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

        .img-container:hover {
            opacity: 0.6;
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
        @if($dataNya['type'] != "single")
            <div class="col-md-12">
                <form action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $dataNya['id'] }}">
                    <div class="card my-1">
                        <div class="card-header">
                            <h5 class="text-center font-weight-bold m-0">Data Suami</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="suami_name">Nama Suami</label>
                                    <input type="text" class="form-control" id="suami_name" name="suami_name" required="" placeholder="Nama" value="{{ $dataNya['name'] }}">
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label for="suami_phone">No. Telp Suami</label>
                                            <input type="tel" class="form-control" id="suami_phone" name="suami_phone" required="" placeholder="No. Telp" value="{{ $dataNya['phone'] }}">
                                        </div>
                                        
                                        <div class="form-group col-md-3 col-12">
                                            <label for="suami_baptis">Baptis</label>
                                            <select class="form-control need_required" id="suami_baptis" name="suami_baptis" aria-label="" required="">
                                                <option value="" disabled="">Pilih Baptis</option>
                                                <option value="1" {{ $dataNya['is_baptis'] == 1 ? "selected" : "" }}>Sudah</option>
                                                <option value="0" {{ $dataNya['is_baptis'] == 0 ? "selected" : "" }}>Belum Baptis</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 col-12">
                                            <label for="suami_fb">Status FB</label>
                                            <select class="form-control" id="suami_fb" name="suami_fb" aria-label="" required="">
                                                <option value="" selected="" disabled="">Pilih Status FB</option>
                                                <option value="1" {{ $dataNya['is_family_blessing'] == 1 ? "selected" : "" }}>Sudah FB</option>
                                                <option value="0" {{ $dataNya['is_family_blessing'] == 0 ? "selected" : "" }}>Belum Ikut FB</option>
                                            </select>
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
                                <div class="form-group col-12">
                                    <label for="istri_name">Nama Istri</label>
                                    <input type="text" class="form-control" id="istri_name" name="istri_name" required="" placeholder="Nama" value="{{ $childNya->where('type', 'istri')->first() != null ? $childNya->where('type', 'istri')->first()['name'] : "" }}">
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label for="istri_phone">No. Telp Istri</label>
                                            <input type="text" class="form-control" id="istri_phone" name="istri_phone" required="" placeholder="No. Telp" value="{{ $childNya->where('type', 'istri')->first() != null ? $childNya->where('type', 'istri')->first()['phone'] : "" }}">
                                        </div>

                                        @php
                                            $istri_is_baptis = 0;
                                            if($childNya->where('type', 'istri')->first() != null){
                                                $istri_is_baptis = $childNya->where('type', 'istri')->first()['is_baptis'];
                                            }

                                            $istri_is_fb = 0;
                                            if($childNya->where('type', 'istri')->first() != null){
                                                $istri_is_fb = $childNya->where('type', 'istri')->first()['is_family_blessing'];
                                            }
                                        @endphp
                                        <div class="form-group col-md-3 col-12">
                                            <label for="istri_baptis">Baptis</label>
                                            <select class="form-control" id="istri_baptis" name="istri_baptis" aria-label="" required="">
                                                <option value="" disabled="">Pilih Baptis</option>
                                                <option value="1" {{ $istri_is_baptis == 1 ? "selected" : "" }}>Sudah</option>
                                                <option value="0" {{ $istri_is_baptis == 0 ? "selected" : "" }}>Belum Baptis</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 col-12">
                                            <label for="istri_fb">Status FB</label>
                                            <select class="form-control" id="istri_fb" name="istri_fb" aria-label="">
                                                <option value="" selected="" disabled="">Pilih Status FB</option>
                                                <option value="1" {{ $istri_is_fb == 1 ? "selected" : "" }}>Sudah FB</option>
                                                <option value="0" {{ $istri_is_fb == 0 ? "selected" : "" }}>Belum Ikut FB</option>
                                            </select>
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

                    @for($i = 1; $i <= 3; $i++)
                        <div class="card my-1">
                            <div class="card-header">
                                <h5 class="text-center font-weight-bold m-0">Data Anak {{ $i }} (Optional)</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="anak_name_{{ $i }}">Nama Anak {{ $i }}</label>
                                        <input type="text" class="form-control" id="anak_name_{{ $i }}" name="anak_name[]" placeholder="Nama" value="{{ isset($childNya->where('type', 'anak')[$i]) ? $childNya->where('type', 'anak')[$i]['name'] : "" }}">
                                    </div>

                                    <div class="col-12">
                                        <div class="row">
                                            @php
                                                $anak_gender = "";
                                                $anak_baptis = "2";
                                                $anak_fb = "2";
                                                if(isset($childNya->where('type', 'anak')[$i])){
                                                    $anak_gender = $childNya->where('type', 'anak')[$i]['gender'];
                                                    $anak_baptis = $childNya->where('type', 'anak')[$i]['is_baptis'];
                                                    $anak_fb = $childNya->where('type', 'anak')[$i]['is_family_blessing'];
                                                }
                                            @endphp

                                            <div class="form-group col-md-2 col-12">
                                                <label for="anak_gender_{{ $i }}">Gender</label>
                                                <select class="form-control" id="anak_gender_{{ $i }}" name="anak_gender[]" aria-label="">
                                                    <option value="" selected="" disabled="">Pilih Gender</option>
                                                    <option value="pria" {{ $anak_gender == "pria" ? "selected" : "" }}>Pria</option>
                                                    <option value="wanita" {{ $anak_gender == "wanita" ? "selected" : "" }}>Wanita</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4 col-12">
                                                <label for="anak_phone_{{ $i }}">No. Telp Anak {{ $i }}</label>
                                                <input type="text" class="form-control" id="anak_phone_{{ $i }}" name="anak_phone[]" placeholder="No. Telp" value="{{ isset($childNya->where('type', 'anak')[$i]) ? $childNya->where('type', 'anak')[$i]['phone'] : "" }}">
                                            </div>
                                                
                                            <div class="form-group col-md-3 col-12">
                                                <label for="anak_baptis_{{ $i }}">Baptis</label>
                                                <select class="form-control" id="anak_baptis_{{ $i }}" name="anak_baptis[]" aria-label="">
                                                    <option value="" selected="" disabled="">Pilih Baptis</option>
                                                    <option value="1" {{ $anak_baptis == 1 ? "selected" : "" }}>Sudah</option>
                                                    <option value="0" {{ $anak_baptis == 0 ? "selected" : "" }}>Belum Baptis</option>
                                                </select>
                                            </div> 

                                            <div class="form-group col-md-3 col-12">
                                                <label for="anak_fb_{{ $i }}">Status FB</label>
                                                <select class="form-control" id="anak_fb_{{ $i }}" name="anak_fb[]" aria-label="">
                                                    <option value="" selected="" disabled="">Pilih Status FB</option>
                                                    <option value="1" {{ $anak_fb == 1 ? "selected" : "" }}>Sudah FB</option>
                                                    <option value="0" {{ $anak_fb == 0 ? "selected" : "" }}>Belum Ikut FB</option>
                                                </select>
                                            </div>                                       
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <label for="anak_tmpt_lahir_{{ $i }}">Tempat Lahir Anak {{ $i }}</label>
                                                <input type="text" class="form-control" id="anak_tmpt_lahir_{{ $i }}" name="anak_tmpt_lahir[]" placeholder="Tempat Lahir" value="{{ isset($childNya->where('type', 'anak')[$i]) ? $childNya->where('type', 'anak')[$i]['tempat_lahir'] : "" }}">
                                            </div>

                                            <div class="form-group col-md-6 col-12">
                                                <label for="anak_tgl_lahir_{{ $i }}">Tanggal Lahir Anak {{ $i }}</label>
                                                <input type="date" class="form-control" id="anak_tgl_lahir_{{ $i }}" name="anak_tgl_lahir[]" placeholder="Tanggal Lahir" value="{{ isset($childNya->where('type', 'anak')[$i]) ? $childNya->where('type', 'anak')[$i]['tgl_lahir'] : "" }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor

                    <div class="card my-1">
                        <div class="card-header">
                            <h5 class="text-center font-weight-bold m-0">Foto Keluarga</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="photo">Upload Foto</label>
                                    <input type="file" class="form-control" id="photo" name="photo" placeholder="Upload Foto" accept="image/*">
                                </div>
                                <div class="col" style="border: solid lightgrey 1px; border-radius: 1em; padding: 1em; margin-left: 1em; margin-right: 1em;">
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <a class="img-container" href="{{ asset("sources/members/". $dataNya['photo']) }}" target="_blank">
                                                <img src="{{ asset("sources/members/". $dataNya['photo']) }}" style="max-height: 12em;" alt="Current Photo">
                                            </a>
                                        </div>
                                        <div class="col-12 col-md-8" style="display: table;">
                                            <span class="font-weight-bold" style="display: table-cell; vertical-align: middle;">Foto Keluaga Saat Ini (Upload Foto Baru Untuk Mengganti Foto Saat Ini)</span>
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
                                    <button type="submit" class="btn btn-success w-100">Save Data</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @else
            <div class="col-md-12">
                <form action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $dataNya['id'] }}">
                    <div class="card my-1">
                        <div class="card-header">
                            <h5 class="text-center font-weight-bold m-0">Data Member</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-12">
                                    <label for="single_name">Nama</label>
                                    <input type="text" class="form-control" id="single_name" name="single_name" required="" placeholder="Nama" value="{{ $dataNya['name'] }}">
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col-md-2 col-12">
                                            <label for="single_gender">Gender</label>
                                            <select class="form-control" id="single_gender" name="single_gender" aria-label="" required="">
                                                <option value="" selected="" disabled="">Pilih Gender</option>
                                                <option value="pria" {{ $dataNya['gender'] == "pria" ? "selected" : "" }}>Pria</option>
                                                <option value="wanita" {{ $dataNya['gender'] == "wanita" ? "selected" : "" }}>Wanita</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4 col-12">
                                            <label for="single_phone">No. Telp</label>
                                            <input type="tel" class="form-control" id="single_phone" name="single_phone" required="" placeholder="No. Telp" value="{{ $dataNya['phone'] }}">
                                        </div>
                                        
                                        <div class="form-group col-md-3 col-12">
                                            <label for="single_baptis">Baptis</label>
                                            <select class="form-control" id="single_baptis" name="single_baptis" aria-label="" required="">
                                                <option value="" selected="" disabled="">Pilih Baptis</option>
                                                <option value="1" {{ $dataNya['is_baptis'] == 1 ? "selected" : "" }}>Sudah</option>
                                                <option value="0" {{ $dataNya['is_baptis'] == 0 ? "selected" : "" }}>Belum Baptis</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 col-12">
                                            <label for="single_fb">Status FB</label>
                                            <select class="form-control" id="single_fb" name="single_fb" aria-label="" required="">
                                                <option value="" selected="" disabled="">Pilih Status FB</option>
                                                <option value="1" {{ $dataNya['is_family_blessing'] == 1 ? "selected" : "" }}>Sudah FB</option>
                                                <option value="0" {{ $dataNya['is_family_blessing'] == 0 ? "selected" : "" }}>Belum Ikut FB</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label for="single_tmpt_lahir">Tempat Lahir</label>
                                            <input type="text" class="form-control" id="single_tmpt_lahir" name="single_tmpt_lahir" required="" placeholder="Tempat Lahir" value="{{ $dataNya['tempat_lahir'] }}">
                                        </div>

                                        <div class="form-group col-md-6 col-12">
                                            <label for="single_tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="single_tgl_lahir" name="single_tgl_lahir" required="" placeholder="Tanggal Lahir" value="{{ $dataNya['tgl_lahir'] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="single_alamat">Alamat</label>
                                        <select class="js-example-basic-single form-control" name="single_district">
                                            @php $currentCity = ""; @endphp
                                            @foreach($subDistricts as $perDistrict)
                                                <option value="{{ $perDistrict['id'] }}" {{ $perDistrict['id'] == $dataNya['district_id'] ? "selected" : "" }}>{{ $perDistrict['province'] }}, {{ $perDistrict['city'] }}, {{ $perDistrict['subdistrict_name'] }}</option>
                                            @endforeach
                                        </select>
                                        <textarea class="form-control" id="single_alamat" rows="5" name="single_address" required="">{{ $dataNya['alamat'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card my-1">
                        <div class="card-header">
                            <h5 class="text-center font-weight-bold m-0">Foto Member</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="photo">Upload Foto</label>
                                    <input type="file" class="form-control" id="photo" name="photo" placeholder="Upload Foto" accept="image/*">
                                </div>
                                <div class="col" style="border: solid lightgrey 1px; border-radius: 1em; padding: 1em; margin-left: 1em; margin-right: 1em;">
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <a class="img-container" href="{{ asset("sources/members/". $dataNya['photo']) }}" target="_blank">
                                                <img src="{{ asset("sources/members/". $dataNya['photo']) }}" style="max-height: 12em;" alt="Current Photo">
                                            </a>
                                        </div>
                                        <div class="col-12 col-md-8" style="display: table;">
                                            <span class="font-weight-bold" style="display: table-cell; vertical-align: middle;">Foto Member Saat Ini (Upload Foto Baru Untuk Mengganti Foto Saat Ini)</span>
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
                                    <button type="submit" class="btn btn-success w-100">Save Data</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endif
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
