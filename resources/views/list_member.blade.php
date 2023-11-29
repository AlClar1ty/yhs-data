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
                    <h1 class="text-center font-weight-bold m-0" id="time"></h1>
                </div>

                <div class="card-body">
                    <div class="row mb-2 mx-2">   
                        <form id="addForm" class="registration-form col-md-6" action="" method="GET">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}" placeholder="by Name and Phone" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-outline-success" type="button">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-6 col-12 mb-3">
                            <a href="{{ route('create') }}"><button type="submit" class="btn btn-success w-100">Add Data</button></a>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width: 84em;">
                                <thead style="background-color: aliceblue; font-weight: 800;">
                                    <tr>
                                        <td class="text-center" style="width: 1em">No.</td>
                                        <td class="text-center" style="width: 25em">Detail Data</td>
                                        <td class="text-center" style="width: 28em">Alamat</td>
                                        <td class="text-center" style="width: 20em">Foto</td>
                                        <td class="text-center" style="width: 10em">Edit/Delete</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $isOdd = 0; @endphp
                                    @foreach ($result as $key => $value)
                                        @php
                                            $isOdd++;
                                            $colorTable = "#ffffff";
                                            if($isOdd%2 == 0){
                                                $colorTable = "#f1f7fd";
                                            }
                                            else{
                                                $colorTable = "#ffffff";
                                            }
                                        @endphp
                                        <tr style="border-top-style: double;">
                                            <td style="vertical-align: middle; background-color: {{ $colorTable }};" class="font-weight-bold text-right">{{ $key+1 }}.</td>
                                            <td class="text-left" style="vertical-align: middle; background-color: {{ $colorTable }};">
                                                <span class="font-weight-bold">Nama : </span>{{ $value['name'] }} <br>
                                                <span class="font-weight-bold">Tempat, Tgl Lahir : </span>{{ $value['tempat_lahir'] }}, {{ date("d F Y", strtotime($value['tgl_lahir'])) }} <br>
                                                <span class="font-weight-bold">No. Telp : </span><a href="https://api.whatsapp.com/send/?phone={{ $value['phone'] }}" target="_blank" style="color: green;"><i class="mdi mdi-whatsapp"></i> {{ $value['phone'] }}</a> <br>
                                            </td>
                                            <td class="text-left" style="background-color: {{ $colorTable }};">
                                                {{ $value->district_detail['province'] }}, {{ $value->district_detail['city'] }}, {{ $value->district_detail['subdistrict_name'] }} <br> {{ $value['alamat'] }}
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($value['photo'])
                                                    <a class="img-container" href="{{ asset("sources/members/". $value['photo']) }}" target="_blank">
                                                        <img src="{{ asset("sources/members/". $value['photo']) }}" style="max-height: 12em;">
                                                    </a>
                                                @else
                                                    <h3>No Photo</h3>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle; background-color: {{ $colorTable }};" class="text-center">
                                                <a href="{{ route('edit', ['id' => $value['id']]) }}">
                                                    <button class="btn btn-delete btn-sm">
                                                        <i class="mdi mdi-border-color" style="font-size: 24px; color:#fed713;"></i>
                                                    </button>
                                                </a>
                                                <button value="{{ route('destroy', ["parent_id" => $value['id']]) }}"
                                                    data-toggle="modal"
                                                    data-target="#deleteModal" 
                                                    class="btn btn-delete btn-sm btn-delete-data">
                                                    <i class="mdi mdi-delete" style="font-size: 24px; color:#fe7c96;"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $result->appends(\Request::except('page'))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
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
                    Are You Sure to Delete this Payment?
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
                    Are You Sure to Delete this Payment?
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

    window.onload = setInterval(clock, 1000);
    function clock()
    {
        var d = new Date();

        var date = d.getDate();
        var month = d.getMonth();
        var montharr = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"];
        month = montharr[month];

        var day = d.getDay();
        var dayarr = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        day = dayarr[day];

        var year = day + " " + date + " " + month + " " + d.getFullYear();

        var hour = d.getHours();
        var min = d.getMinutes();
        var sec = d.getSeconds();
        document.getElementById("time").innerHTML = year + ", " + (hour < 10 ? '0' : '') + hour + ":" + (min < 10 ? '0' : '') + min + ":" + (sec < 10 ? '0' : '') + sec;
    }

    function clearInvalid(keyNya) {
        $("#addForm").find("input[name="+keyNya+"]").next().find("strong").text("");
    }
</script>
@endsection
