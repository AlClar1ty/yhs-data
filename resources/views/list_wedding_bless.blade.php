@extends('layouts.app')

@section('style')
  <style>
    img{
        max-height: 2em;
    }

    .img-container:hover {
        opacity: 0.6;
    }
  </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center m-0">Jumlah wedding bless : {{ $weddingBlesses->count() }}</h2>
                </div>
            </div>

            <div class="table pt-2">
                <table class="table table-bordered" style="width: 120em;">
                    <thead style="background-color: aliceblue; font-weight: 800;">
                        <tr>
                            <td rowspan="2" class="text-center" style="vertical-align: middle;">No.</td>
                            <td colspan="2" class="text-center">Nama Mempelai</td>
                            <td rowspan="2" class="text-center" style="vertical-align: middle;">Tanggal Pemberkatan</td>
                            <td rowspan="2" class="text-center" style="vertical-align: middle;">Jam Pemberkatan</td>
                            <td rowspan="2" class="text-center" style="vertical-align: middle;">Alamat Pemberkatan</td>
                            <td rowspan="2" class="text-center" style="vertical-align: middle;">Dilayani oleh Pastor</td> 
                            <td rowspan="2" class="text-center" style="vertical-align: middle;">Keterangan</td>
                            <td rowspan="2" class="text-center" style="vertical-align: middle;">Edit/Delete</td>
                        </tr>
                        <tr>
                            <td class="text-center col-2">Pria</td>
                            <td class="text-center col-2">Wanita</td>
                        </tr>                         
                    </thead>
                    <tbody>
                        @foreach($weddingBlesses as $idx => $weddingBless)
                            <tr style="border-top-style: double;">
                                <td style="vertical-align: middle;" class="font-weight-bold text-right">{{ $idx+1 }}.</td>
                                <td style="vertical-align: middle;" class="text-left">{{ $weddingBless['male_name'] }}</td>
                                <td style="vertical-align: middle;" class="text-left">{{ $weddingBless['female_name'] }}</td>
                                <td style="vertical-align: middle;" class="text-left">{{ date("l, d F Y", strtotime($weddingBless['datetime_bless'])) }}</td>
                                <td style="vertical-align: middle;" class="text-left">{{ date("H:i", strtotime($weddingBless['datetime_bless'])) }}</td>
                                <td style="vertical-align: middle;" class="text-left"><a href="https://www.google.com/maps/search/?api=1&query={{ str_replace(" ", "+", $weddingBless['address_bless']) }}" target="_blank">{{ $weddingBless->district_detail['province'] }}, {{ $weddingBless->district_detail['city'] }}, {{ $weddingBless->district_detail['subdistrict_name'] }} <br> {{ $weddingBless['address_bless'] }}</a></td>
                                <td style="vertical-align: middle;" class="text-left">{{ $weddingBless->pastor['name'] }}</td>
                                <td style="vertical-align: middle;" class="text-left">{{ $weddingBless['description'] }}</td>
                                <td style="vertical-align: middle;" class="text-center">
                                    <a href="{{ route('wedding_edit', ['id' => $weddingBless['id']]) }}">
                                        <button class="btn btn-delete btn-sm">
                                            <i class="mdi mdi-border-color" style="font-size: 16px; color:#fed713;"></i>
                                        </button>
                                    </a>
                                    <button value="{{ route('wedding_destroy', ["id" => $weddingBless['id']]) }}"
                                        data-toggle="modal"
                                        data-target="#deleteModal" 
                                        class="btn btn-delete btn-sm btn-delete-data">
                                        <i class="mdi mdi-delete" style="font-size: 16px; color:#fe7c96;"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                {!! $weddingBlesses->appends(\Request::except('page'))->render() !!}
        </div>
    </div>
</div>

<!-- Modal Delete Payment -->
<div class="modal fade"
    id="deleteModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 style="text-align: center;">
                    Are You Sure to Delete this Wedding Bless?
                </h5>
            </div>
            <div class="modal-footer">
                <form id="frmDelete" method="post" action="">
                    {{ csrf_field() }}
                    <button type="submit"
                        class="btn btn-danger mr-2">
                        Yes
                    </button>
                </form>
                <button class="btn btn-primary" data-dismiss="modal">
                    No
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Delete -->
@endsection

@section("script")
<script>
    $(document).ready(function() {
        $(".btn-delete-data").click(function(e) {
            console.log($(this).val());
            $("#frmDelete").attr("action",  $(this).val());
        });
    });
</script>
@endsection