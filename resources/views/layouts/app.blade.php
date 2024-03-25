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
    </style>

    @yield('style')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="https://www.yhschurch.com/wp-content/uploads/2019/12/Website-Logo.png">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() == 'index' ? 'active' : '' }}" href="{{ route('index') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() == 'create' ? 'active' : '' }}" href="{{ route('create') }}">Add Data</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item"><a class="nav-link" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </div>
            </div>
        </nav>

        @if(sizeof($ultah) > 0 || sizeof($married) > 0)
            <div class="px-1 bg-info">
                <marquee class="pt-2" direction="left" onmouseover="this.stop()" onmouseout="this.start()">
                    <p class="h4 mb-0 text-light">
                        Birtday on {{ date("d F Y", strtotime($date2morrow)) }} ({{ count($ultah) > 0 ? count($ultah).') : ' : count($ultah).')' }} 
                        @foreach($ultah as $perUltah)
                            <a class="text-light" href="{{ route('index') }}?find_id={{ $perUltah->parent_member['id'] }}&highlight_ultah_id={{ $perUltah['id'] }}">{{ $perUltah['name'] }} - {{ $perUltah['phone'] }}</a>, 
                        @endforeach
                        ||
                        Marriage on {{ date("d F Y", strtotime($date2morrow)) }} ({{ count($married) > 0 ? count($married).') : ' : count($married).')' }} 
                        @foreach($married as $perMarried)
                            <a class="text-light" href="{{ route('index') }}?find_id={{ $perMarried->parent_member['id'] }}&highlight_maried_id={{ $perMarried['id'] }}">{{ $perMarried['name'] }} - {{ $perMarried['phone'] }}</a>, 
                        @endforeach
                    </p>
                </marquee>
            </div>
        @endif

        <main class="py-4">
            @if (session('success'))
                <div class="container">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('script')
    <script>
        window.onload = setInterval(close_alert, 3000);
        window.onload = setInterval(d_none, 3200);
        function close_alert() {
            $('.alert-success').addClass("fade");
        }
        function d_none(){
            $('.alert-success').addClass("d-none");
        }
    </script>
</body>
</html>
