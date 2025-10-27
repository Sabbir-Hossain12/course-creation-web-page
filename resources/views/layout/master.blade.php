<!doctype html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8"/>

    <title>
        {{ config('app.name') }} | @stack('title')
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Softvence" name="Softvence"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('public/backend/assets/images/favicon.ico')}}">
    
    @include("include.meta-titles")

    @stack('backendCss')
</head>

<body class="pace-done sidebar-enable" data-sidebar-size="lg">

<!-- <body data-layout="horizontal"> -->

<!-- Begin page -->
<div id="layout-wrapper">
    @include('include.topbar')
    
    @include('include.sidebar')
    
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('contents')
            </div> 
        </div>
        
        @include('include.footer')
    </div>
 

</div>
 
    @include("include.scripts")

<script>
    @if (Session::has('success'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.success("{{ session('success') }}");
    @endif

            @if (Session::has('error'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.error("{{ session('error') }}");
    @endif

            @if (Session::has('info'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.info("{{ session('info') }}");
    @endif

            @if (Session::has('warning'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.warning("{{ session('warning') }}");
    @endif
</script>

</body>
</html>
