@extends('layouts.app')

@section('style')
  <style>
    img{
        max-height: 2em;
    }

    .img-container:hover {
        opacity: 0.6;
    }

    @media print {
        div.divFooter {
            position: fixed;
            bottom: 0;
        }
        @page {
            size: 8.5in 9in;
            width: 210mm;
            height: 297mm;
            size: A4 landscape;
        }
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
                    <h4 class="text-center m-0">Jumlah jemaat : {{ $totMembers }} | Jumlah Keluarga : {{ $totFamily }}</h4>
                </div>

                <div class="card-body">
                    <div class="row mb-2 mx-2">   
                        <form id="searchForm" class="registration-form col-md-12" action="" method="GET">
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label for="search-name-phone">Search by Name & Phone</label>
                                    <input id="search-name-phone" type="text" class="form-control" name="search" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}" placeholder="by Name and Phone" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                </div>
                                <div class="form-group col-md-2 col-12">
                                    <label for="search-baptis">Status Baptis</label>
                                    <select class="form-control" id="search-baptis" name="search_baptis" aria-label="">
                                        <option value="" selected="" disabled="">Pilih Baptis</option>
                                        <option value="1" {{ isset($_GET['search_baptis']) ? ($_GET['search_baptis'] == 1 ? "selected" : "") : '' }}>Sudah</option>
                                        <option value="0" {{ isset($_GET['search_baptis']) ? ($_GET['search_baptis'] == 0 ? "selected" : "") : '' }}>Belum Baptis</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2 col-12">
                                    <label for="search-fb">Status FB</label>
                                    <select class="form-control" id="search-fb" name="search_fb" aria-label="">
                                        <option value="" selected="" disabled="">Pilih Status</option>
                                        <option value="1" {{ isset($_GET['search_fb']) ? ($_GET['search_fb'] == 1 ? "selected" : "") : '' }}>Sudah FB</option>
                                        <option value="0" {{ isset($_GET['search_fb']) ? ($_GET['search_fb'] == 0 ? "selected" : "") : '' }}>Belum Ikut FB</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-12">
                                    <label for="search-name-phone">Search by Birth/Marriage Date</label>
                                    <div class="input-group">
                                        <input type="hidden" name="search-date-type" id="search-date-type">
                                        <input type="date" class="form-control" name="search-date" value="{{ isset($_GET['search-date']) ? $_GET['search-date'] : '' }}">
                                        <div class="input-group-append">
                                            <button id="btn-dropdown-date" class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ isset($_GET['search-date-type']) && $_GET['search-date-type'] != '' ? ($_GET['search-date-type'] == 'tgl_lahir' ? 'Birth Date' : 'Marriage Date') : 'Choose Date' }}</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item dropdown-date" href="#" data-value="tgl_lahir">Birth Date</a>
                                                <a class="dropdown-item dropdown-date" href="#" data-value="tgl_pernikahan">Marriage Date</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-6 col-12 mt-2">
                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <button type="submit" form="searchForm" class="btn btn-info w-100">Search</button>
                                </div>
                                <div class="col-md-3 col-6">
                                    <a href="{{ route('index') }}"><button class="btn btn-danger w-100">Reset</button></a>
                                </div>
                                <div class="col-md-3 col-6">
                                    <button id="btn-print" class="btn btn-warning w-100">Print</button>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-12 col-12 mb-3">
                            <a href="{{ route('create') }}"><button type="submit" class="btn btn-success w-100">Add Data</button></a>
                        </div>  --}}                       
                    </div>
                </div>
            </div>

            <div id="element-to-print" class="table pt-2">
                <table class="table table-bordered" style="width: 190em;">
                    </thead>
                    <thead style="background-color: aliceblue; font-weight: 800;">
                        <tr>
                            <td class="text-center" >No.</td>
                            <td class="text-center" ></td>
                            <td class="text-center" colspan="2">Data Member</td>
                            <td class="text-center" >Anak 1</td>
                            <td class="text-center" >Anak 2</td>
                            <td class="text-center" >Anak 3</td>
                            <td class="text-center" >Alamat</td>
                            <td class="text-center on_print" >Foto</td>
                            <td class="text-center on_print" >Edit/Delete</td>
                        </tr>                                
                    </thead>
                    <tbody>
                        @php $isOdd = 0; $idxNum = 0; @endphp
                        @foreach ($result as $key => $value)
                            @php
                                $parentNya = $value->parent_member;
                                if(!isset($parentNya->child_member)){
                                    continue;
                                }
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

                                $idxNum++;
                            @endphp
                            <tr style="border-top-style: double;">
                                <td rowspan="5" style="vertical-align: middle; background-color: {{ $colorTable }};" class="font-weight-bold text-right">{{ $idxNum }}.</td>
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
                                <td style="background-color: {{ $colorTable }};">{{ $parentNya['name'] }} ({{ $parentNya['type'] == 'single' ? ucfirst($parentNya['gender']) : "Suami" }})</td>
                                

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
                                <td style="background-color: {{ $colorTable }};">{{ $childNya->where('type', 'istri')->first() != null ? $childNya->where('type', 'istri')->first()['name'] . " (Istri)" : "" }}</td>
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
                                    <td style="background-color: {{ $colorTable }};">{{ $anakNya['name'] }} ({{ ucfirst($anakNya['gender']) }})</td>
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
                                <td rowspan="5" style="vertical-align: middle; background-color: {{ $colorTable }};"><a href="https://www.google.com/maps/search/?api=1&query={{ str_replace(" ", "+", $parentNya['alamat']) }}" target="_blank">{{ $parentNya->district_detail['province'] }}, {{ $parentNya->district_detail['city'] }}, {{ $parentNya->district_detail['subdistrict_name'] }} <br> {{ $parentNya['alamat'] }}</a></td>

                                <td class="on_print" rowspan="5" style="text-align: center; vertical-align: middle;">
                                    @if($parentNya['photo'])
                                        <a class="img-container" href="{{ asset("sources/members/". $parentNya['photo']) }}" target="_blank">
                                            <img src="{{ asset("sources/members/". $parentNya['photo']) }}" style="max-height: 12em;">
                                        </a>
                                    @else
                                        <h3>No Photo</h3>
                                    @endif
                                </td>

                                <td class="on_print" rowspan="5" style="vertical-align: middle; background-color: {{ $colorTable }};" class="text-center">
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
                                <td style="background-color: {{ $colorTable }};">
                                    @if(isset($parentNya['phone']))
                                        <a href="https://api.whatsapp.com/send/?phone={{ $parentNya['phone'] }}" target="_blank" style="color: green;"><i class="mdi mdi-whatsapp"></i> 
                                            {{ $parentNya['phone'] }}
                                        </a>
                                    @endif
                                </td>
                                
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
                                <td style="background-color: {{ $colorTable }};">
                                    @if($childNya->where('type', 'istri')->first() != null)
                                        <a href="https://api.whatsapp.com/send/?phone={{ $childNya->where('type', 'istri')->first() != null ? $childNya->where('type', 'istri')->first()['phone'] : "" }}" target="_blank" style="color: green;"><i class="mdi mdi-whatsapp"></i> 
                                            {{ $childNya->where('type', 'istri')->first() != null ? $childNya->where('type', 'istri')->first()['phone'] : "" }} 
                                        </a>
                                    @endif
                                </td>

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
                                    <td style="background-color: {{ $colorTable }};">
                                        @if(isset($anakNya['phone']))
                                            <a href="https://api.whatsapp.com/send/?phone={{ $anakNya['phone'] }}" target="_blank" style="color: green;"><i class="mdi mdi-whatsapp"></i>  {{ $anakNya['phone'] }} </a>
                                        @endif
                                    </td>

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
                                <td class="font-weight-bold text-right" style="background-color: {{ $colorTable }};">Status Baptis</td>

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
                                @if(isset($parentNya['is_baptis']))
                                    <td style="background-color: {{ $colorTable }};">
                                        {!! $parentNya['is_baptis'] ? "<span class=\"text-success\">Sudah Baptis</span>" : "<span class=\"text-danger\">Belum Baptis</span>" !!}
                                        {!! $parentNya['is_family_blessing'] ? "<span class=\"text-success\"> (Sudah FB)</span>" : "<span class=\"text-danger\"> (Belum Ikut FB)</span>" !!}
                                    </td>
                                @endif
                                
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
                                <td style="background-color: {{ $colorTable }};"> 
                                    @if($childNya->where('type', 'istri')->first() != null)
                                        {!! $childNya->where('type', 'istri')->first()['is_baptis'] ? "<span class=\"text-success\">Sudah Baptis</span>" : "<span class=\"text-danger\">Belum Baptis</span>" !!} 
                                        {!! $childNya->where('type', 'istri')->first()['is_family_blessing'] ? "<span class=\"text-success\"> (Sudah FB)</span>" : "<span class=\"text-danger\"> (Belum Ikut FB)</span>" !!} 
                                    @endif
                                </td>

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
                                    <td style="background-color: {{ $colorTable }};">
                                        @if(isset($anakNya['is_baptis']))
                                            {!! $anakNya['is_baptis'] ? "<span class=\"text-success\">Sudah Baptis</span>" : "<span class=\"text-danger\">Belum Baptis</span>" !!} 
                                        @endif

                                        @if(isset($anakNya['is_family_blessing']))
                                            {!! $anakNya['is_family_blessing'] ? "<span class=\"text-success\"> (Sudah FB)</span>" : "<span class=\"text-danger\"> (Belum Ikut FB)</span>" !!} 
                                        @endif
                                    </td>

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
                                <td colspan="2" class="text-center" style="background-color: {{ $colorTable }};">{{ isset($parentNya['tgl_pernikahan']) ? date("d F Y", strtotime($parentNya['tgl_pernikahan'])) : "Belum Menikah" }}</td>
                                <td colspan="4" style="background-color: {{ $colorTable }};"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                {!! $result->appends(\Request::except('page'))->render() !!}
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
        $(".dropdown-date").click(function(e) {
            $("#btn-dropdown-date").html($(this).html());
            $("#search-date-type").val($(this).attr("data-value"));
        });

        $("#btn-print").click(function(e){
            $(".on_print").hide();
            var printContents = document.getElementById("element-to-print").innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            $(".on_print").show();
            return true;
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
        $("#searchForm").find("input[name="+keyNya+"]").next().find("strong").text("");
    }
</script>
@endsection
