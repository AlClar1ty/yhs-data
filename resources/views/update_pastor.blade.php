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
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('pastor_list') }}">Data Pastor</a></li>
        <li class="breadcrumb-item active font-weight-bold" aria-current="page">Update Data</li>
      </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form id="formAdd" action="{{ route('pastor_update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $pastorNya['id'] }}">
                <div class="card my-1">
                    <div class="card-header">
                        <h5 class="text-center font-weight-bold m-0">Data Pastor</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="single_name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" required="" placeholder="Nama" value="{{ $pastorNya['name'] }}">
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