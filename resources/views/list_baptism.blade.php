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
                    <h2 class="text-center m-0">Jumlah baptism : {{ $baptisms->count() }}</h2>
                </div>
            </div>

            <div class="table pt-2">
                <table class="table table-bordered" style="width: 190em;">
                    <thead style="background-color: aliceblue; font-weight: 800;">
                        <tr>
                            <td class="text-center">No.</td>
                            <td class="text-center col-1">Nama</td>
                            <td class="text-center">Tempat, Tgl Lahir</td>
                            <td class="text-center col-1">Nama Ayah</td>
                            <td class="text-center col-1">Nama Ibu</td>
                            <td class="text-center">Alamat</td>
                            <td class="text-center">Phone</td>

                            <td class="text-center">Tanggal Baptis</td>
                            <td class="text-center">Konselor</td> 
                            <td class="text-center">Pembabtis</td> 
                            <td class="text-center">Keterangan</td>
                            <td class="text-center">Edit/Delete</td>
                        </tr>                       
                    </thead>
                    <tbody>
                        @foreach($baptisms as $idx => $baptism)
                            <tr style="border-top-style: double;">
                                <td class="font-weight-bold text-right" style="vertical-align: middle;">{{ $idx+1 }}.</td>
                                <td class="text-left" style="vertical-align: middle;">{{ $baptism['name'] }}</td>
                                <td class="text-left" style="vertical-align: middle;">{{ $baptism['tempat_lahir'] }}, {{ date("d F Y", strtotime($baptism['tgl_lahir'])) }}</td>
                                <td class="text-left" style="vertical-align: middle;">{{ $baptism['father_name'] }}</td>
                                <td class="text-left" style="vertical-align: middle;">{{ $baptism['mother_name'] }}</td>
                                <td class="text-left" style="vertical-align: middle;"><a href="https://www.google.com/maps/search/?api=1&query={{ str_replace(" ", "+", $baptism['alamat']) }}" target="_blank">{{ $baptism->district_detail['province'] }}, {{ $baptism->district_detail['city'] }}, {{ $baptism->district_detail['subdistrict_name'] }} <br> {{ $baptism['alamat'] }}</a></td>
                                <td class="text-left" style="vertical-align: middle;"><a href="https://api.whatsapp.com/send/?phone={{ $baptism['phone'] }}" target="_blank" style="color: green;"><i class="mdi mdi-whatsapp"></i> 
                                            {{ $baptism['phone'] }}
                                        </a></td>
                                <td class="text-left" style="vertical-align: middle;">{{ date("l, d F Y", strtotime($baptism['baptism_date'])) }}</td>
                                <td class="text-left" style="vertical-align: middle;">{{ $baptism->consellour['name'] }}</td>
                                <td class="text-left" style="vertical-align: middle;">{{ $baptism->baptizedBy['name'] }}</td>
                                <td class="text-left" style="vertical-align: middle;">{{ $baptism['description'] }}</td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <a href="{{ route('baptism_edit', ['id' => $baptism['id']]) }}">
                                        <button class="btn btn-delete btn-sm">
                                            <i class="mdi mdi-border-color" style="font-size: 16px; color:#fed713;"></i>
                                        </button>
                                    </a>
                                    <button value="{{ route('baptism_destroy', ["id" => $baptism['id']]) }}"
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
                {!! $baptisms->appends(\Request::except('page'))->render() !!}
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
                    Are You Sure to Delete this baptism data?
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