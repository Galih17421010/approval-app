<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

   @include('layouts.header')

</head>

<body class="hold-transition layout-top-nav">
<div class="wrapper">

    @include('layouts.navbar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    

    @include('layouts.footer')

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('layouts.javascript')

{{-- SCRIPT  --}}
@yield('script')

</body>
</html>
