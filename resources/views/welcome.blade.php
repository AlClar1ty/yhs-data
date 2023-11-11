@extends('layouts.app')

@section('style')
  <style>
    img{
        max-height: 2em;
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
                            <table class="table table-bordered" style="width: 135em;">
                                </thead>
                                <thead style="background-color: aliceblue; font-weight: 800;">
                                    <tr>
                                        <td class="text-center" style="width: 2em">No.</td>
                                        <td class="text-center" style="width: 10em"></td>
                                        <td class="text-center" style="width: 18em">Suami</td>
                                        <td class="text-center" style="width: 18em">Istri</td>
                                        <td class="text-center" style="width: 18em">Anak 1</td>
                                        <td class="text-center" style="width: 18em">Anak 2</td>
                                        <td class="text-center" style="width: 18em">Anak 3</td>
                                        <td class="text-center" style="width: 25em">Alamat</td>
                                        <td class="text-center" style="width: 10em">Edit/Delete</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $isOdd = 0; @endphp
                                    @foreach ($result as $key => $value)
                                        @php
                                            $parentNya = $value->parent_member;
                                            $childNya = $parentNya->child_member;
                                            $totAnak = 0;
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
                                            <td rowspan="4" style="vertical-align: middle; background-color: {{ $colorTable }};" class="font-weight-bold text-right">{{ $key+1 }}.</td>
                                            <td class="font-weight-bold text-right" style="background-color: {{ $colorTable }};">Nama</td>
                                            
                                            @php
                                                if($isOdd%2 == 0){
                                                    $colorTable = "#f1f7fd";
                                                }
                                                else{
                                                    $colorTable = "#ffffff";
                                                }
                                                if(in_array($parentNya['id'], json_decode(json_encode($forMark), true))){
                                                    $colorTable = "#f1ffcf";
                                                }
                                            @endphp
                                            <td style="background-color: {{ $colorTable }};">{{ $parentNya['name'] }}</td>
                                            

                                            @php
                                                if($isOdd%2 == 0){
                                                    $colorTable = "#f1f7fd";
                                                }
                                                else{
                                                    $colorTable = "#ffffff";
                                                }
                                                if(in_array($childNya->where('type', 'istri')->first()['id'], json_decode(json_encode($forMark), true))){
                                                    $colorTable = "#f1ffcf";
                                                }
                                            @endphp
                                            <td style="background-color: {{ $colorTable }};">{{ $childNya->where('type', 'istri')->first() != null ? $childNya->where('type', 'istri')->first()['name'] : "" }}</td>
                                            @foreach($childNya->where('type', 'anak') as $anakNya)

                                                @php
                                                    if($isOdd%2 == 0){
                                                        $colorTable = "#f1f7fd";
                                                    }
                                                    else{
                                                        $colorTable = "#ffffff";
                                                    }
                                                    if(in_array($anakNya['id'], json_decode(json_encode($forMark), true))){
                                                        $colorTable = "#f1ffcf";
                                                    }
                                                @endphp
                                                <td style="background-color: {{ $colorTable }};">{{ $anakNya['name'] }}</td>
                                                @php
                                                    $totAnak++;
                                                    if($totAnak > 3){
                                                        continue;
                                                    }
                                                @endphp
                                            @endforeach

                                            @php
                                                if($isOdd%2 == 0){
                                                    $colorTable = "#f1f7fd";
                                                }
                                                else{
                                                    $colorTable = "#ffffff";
                                                }
                                            @endphp
                                            @for($i = $totAnak; $i < 3; $i++)
                                                <td style="background-color: {{ $colorTable }};"></td>
                                            @endfor

                                            @php
                                                if($isOdd%2 == 0){
                                                    $colorTable = "#f1f7fd";
                                                }
                                                else{
                                                    $colorTable = "#ffffff";
                                                }
                                            @endphp
                                            <td rowspan="4" style="vertical-align: middle; background-color: {{ $colorTable }};">{{ $parentNya->district_detail['province'] }}, {{ $parentNya->district_detail['city'] }}, {{ $parentNya->district_detail['subdistrict_name'] }} <br> {{ $parentNya['alamat'] }}</td>
                                            <td rowspan="4" style="vertical-align: middle; background-color: {{ $colorTable }};" class="text-center">
                                                <a href="{{ route('edit', ['id' => $parentNya['id']]) }}">
                                                    <button class="btn btn-delete btn-sm">
                                                        <i class="mdi mdi-border-color" style="font-size: 24px; color:#fed713;"></i>
                                                    </button>
                                                </a>
                                                <button value="{{ route('destroy', ["parent_id" => $parentNya['id']]) }}"
                                                    data-toggle="modal"
                                                    data-target="#deleteModal" 
                                                    class="btn btn-delete btn-sm btn-delete-data">
                                                    <i class="mdi mdi-delete" style="font-size: 24px; color:#fe7c96;"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold text-right" style="background-color: {{ $colorTable }};">Tempat, Tgl Lahir</td>

                                            @php
                                                if($isOdd%2 == 0){
                                                    $colorTable = "#f1f7fd";
                                                }
                                                else{
                                                    $colorTable = "#ffffff";
                                                }
                                                if(in_array($parentNya['id'], json_decode(json_encode($forMark), true))){
                                                    $colorTable = "#f1ffcf";
                                                }
                                            @endphp
                                            <td style="background-color: {{ $colorTable }};">{{ $parentNya['tempat_lahir'] }}, {{ date("d F Y", strtotime($parentNya['tgl_lahir'])) }}</td>
                                            
                                            @php
                                                if($isOdd%2 == 0){
                                                    $colorTable = "#f1f7fd";
                                                }
                                                else{
                                                    $colorTable = "#ffffff";
                                                }
                                                if(in_array($childNya->where('type', 'istri')->first()['id'], json_decode(json_encode($forMark), true))){
                                                    $colorTable = "#f1ffcf";
                                                }
                                            @endphp
                                            <td style="background-color: {{ $colorTable }};">{{ $childNya->where('type', 'istri')->first() != null ? $childNya->where('type', 'istri')->first()['tempat_lahir'] . ", " . date("d F Y", strtotime($childNya->where('type', 'istri')->first()['tgl_lahir'])) : "" }}</td>
                                            @php
                                                $totAnak = 0;
                                            @endphp

                                            @foreach($childNya->where('type', 'anak') as $anakNya)

                                                @php
                                                    if($isOdd%2 == 0){
                                                        $colorTable = "#f1f7fd";
                                                    }
                                                    else{
                                                        $colorTable = "#ffffff";
                                                    }
                                                    if(in_array($anakNya['id'], json_decode(json_encode($forMark), true))){
                                                        $colorTable = "#f1ffcf";
                                                    }
                                                @endphp
                                                <td style="background-color: {{ $colorTable }};">{{ $anakNya['tempat_lahir'] }}, {{ date("d F Y", strtotime($anakNya['tgl_lahir'])) }}</td>
                                                @php
                                                    $totAnak++;
                                                    if($totAnak > 3){
                                                        continue;
                                                    }
                                                @endphp
                                            @endforeach

                                            @php
                                                if($isOdd%2 == 0){
                                                    $colorTable = "#f1f7fd";
                                                }
                                                else{
                                                    $colorTable = "#ffffff";
                                                }
                                            @endphp
                                            @for($i = $totAnak; $i < 3; $i++)
                                                <td style="background-color: {{ $colorTable }};"></td>
                                            @endfor
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold text-right" style="background-color: {{ $colorTable }};">No. Telp</td>

                                            @php
                                                if($isOdd%2 == 0){
                                                    $colorTable = "#f1f7fd";
                                                }
                                                else{
                                                    $colorTable = "#ffffff";
                                                }
                                                if(in_array($parentNya['id'], json_decode(json_encode($forMark), true))){
                                                    $colorTable = "#f1ffcf";
                                                }
                                            @endphp
                                            <td style="background-color: {{ $colorTable }};"><a href="https://api.whatsapp.com/send/?phone={{ $parentNya['phone'] }}" target="_blank" style="color: green;"><i class="mdi mdi-whatsapp"></i> {{ $parentNya['phone'] }}</a></td>
                                            
                                            @php
                                                if($isOdd%2 == 0){
                                                    $colorTable = "#f1f7fd";
                                                }
                                                else{
                                                    $colorTable = "#ffffff";
                                                }
                                                if(in_array($childNya->where('type', 'istri')->first()['id'], json_decode(json_encode($forMark), true))){
                                                    $colorTable = "#f1ffcf";
                                                }
                                            @endphp
                                            <td style="background-color: {{ $colorTable }};"><a href="https://api.whatsapp.com/send/?phone={{ $childNya->where('type', 'istri')->first() != null ? $childNya->where('type', 'istri')->first()['phone'] : "" }}" target="_blank" style="color: green;"><i class="mdi mdi-whatsapp"></i> {{ $childNya->where('type', 'istri')->first() != null ? $childNya->where('type', 'istri')->first()['phone'] : "" }} </a></td>
                                            @php
                                                $totAnak = 0;
                                            @endphp

                                            @foreach($childNya->where('type', 'anak') as $anakNya)

                                                @php
                                                    if($isOdd%2 == 0){
                                                        $colorTable = "#f1f7fd";
                                                    }
                                                    else{
                                                        $colorTable = "#ffffff";
                                                    }
                                                    if(in_array($anakNya['id'], json_decode(json_encode($forMark), true))){
                                                        $colorTable = "#f1ffcf";
                                                    }
                                                @endphp
                                                <td style="background-color: {{ $colorTable }};"><a href="https://api.whatsapp.com/send/?phone={{ $anakNya['phone'] }}" target="_blank" style="color: green;"><i class="mdi mdi-whatsapp"></i>  {{ $anakNya['phone'] }} </a></td>
                                                @php
                                                    $totAnak++;
                                                    if($totAnak > 3){
                                                        continue;
                                                    }
                                                @endphp
                                            @endforeach

                                            @php
                                                if($isOdd%2 == 0){
                                                    $colorTable = "#f1f7fd";
                                                }
                                                else{
                                                    $colorTable = "#ffffff";
                                                }
                                            @endphp
                                            @for($i = $totAnak; $i < 3; $i++)
                                                <td style="background-color: {{ $colorTable }};"></td>
                                            @endfor
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold text-right" style="background-color: {{ $colorTable }};">Tgl Pernikahan</td>
                                            <td colspan="2" class="text-center" style="background-color: {{ $colorTable }};">{{ date("d F Y", strtotime($parentNya['tgl_pernikahan'])) }}</td>
                                            <td colspan="4" style="background-color: {{ $colorTable }};"></td>
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
