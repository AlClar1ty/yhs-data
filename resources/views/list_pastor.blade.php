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
                    <h2 class="text-center m-0">Jumlah pastors : {{ $pastors->count() }}</h2>
                </div>
            </div>

            <div class="table pt-2">
                <table class="table table-bordered">
                    </thead>
                    <thead style="background-color: aliceblue; font-weight: 800;">
                        <tr>
                            <td class="text-center col-1" >No.</td>
                            <td class="text-center" >Nama Pastor</td>
                            <td class="text-center col-2" >Edit/Delete</td>
                        </tr>                                
                    </thead>
                    <tbody>
                        @foreach($pastors as $idx => $pastor)
                            <tr style="border-top-style: double;">
                                <td style="vertical-align: middle;" class="font-weight-bold text-right">{{ $idx+1 }}.</td>
                                <td style="vertical-align: middle;" class="text-left">{{ $pastor['name'] }}</td>
                                <td style="vertical-align: middle;" class="text-center">
                                    <a href="{{ route('pastor_edit', ['id' => $pastor['id']]) }}">
                                        <button class="btn btn-delete btn-sm">
                                            <i class="mdi mdi-border-color" style="font-size: 16px; color:#fed713;"></i>
                                        </button>
                                    </a>
                                    <button value="{{ route('pastor_destroy', ["id" => $pastor['id']]) }}"
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
                {!! $pastors->appends(\Request::except('page'))->render() !!}
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
                    Are You Sure to Delete this Pastor?
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