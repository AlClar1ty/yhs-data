<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>YHS FB Data</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/admin/tagsinput.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js "></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="https://play-lh.googleusercontent.com/f4d8N0GC8QtleHHPdTrSj9uo8z2u33JRu1r6c8CgY6b9EJNY8eggpyFZ_LWA4zNMdGU=w240-h480-rw" />
    <link rel="stylesheet" href="{{ asset('css/admin/tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mdi/css/materialdesignicons.min.css') }}">

    <style type="text/css">
        body{
            background-image: url("{{ asset('sources/bgyhs.png') }}");
            background-repeat: repeat;
        }

        .container-scroller{
            overflow: hidden;
        }
        .page-body-wrapper .full-page-wrapper{
            width: 100%;
            min-height: 100vh;
        }
        .page-body-wrapper{
            min-height: calc(100vh - 70px);
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-direction: row;
            flex-direction: row;
            padding-left: 0;
            padding-right: 0;
        }
        .content-wrapper{
            padding: 2rem 2rem;
            width: 100%;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
        }
        .flex-grow{
            -webkit-box-flex: 1; */
            -ms-flex-positive: 1;
            flex-grow: 1;
        }
        .auth-form-light{
            background: #ffffff;
            box-shadow: 7px 7px 7px 2px #88888854;
        }
        .auth form .auth-form-btn {
            height: 50px;
            line-height: 1.5;
            color: white;
            font-weight: bold;
        }
        .btn-gradient-primary {
            background: -webkit-gradient(linear, left top, right top, from(#7ac02f), to(#2cce85));
            background: linear-gradient(to right, #7ac02f, #2cce85);
            border: 0;
            -webkit-transition: opacity 0.3s ease;
            transition: opacity 0.3s ease;
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth">
                    <div class="row flex-grow">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left p-5">
                                <div class="brand-logo text-center">
                                    <img src="https://www.yhschurch.com/wp-content/uploads/2019/12/Website-Logo.png" style="width: 85%">
                                </div>
                                <h4 class="mt-3 text-center">Login Page</h4>
                                @php
                                    // dd($errors);
                                @endphp

                                <form class="pt-3" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                                            {{ __('LOGIN') }}
                                        </button>
                                    </div>
                                    <div class="my-2 d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <label class="form-check-label text-muted"></label>
                                        </div>
                                        @if (Route::has('password.request'))
                                            {{-- <a class="auth-link text-black" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a> --}}
                                        @endif
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>