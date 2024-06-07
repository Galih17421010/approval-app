@section('title', 'Log In')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    @include('layouts.header')

<style>

</style>


</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
    
  @include('layouts.navbar')
 
    <div class="content-wrapper">
        <div class="content">
            <div class="row">
                <div class="login-box" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    <div class="card card-outline card-primary">
                        <div class="card-header text-center">
                        <a href="" class="h3"><b>{{ config('app.name') }}</b></a>
                        </div>
                        <div class="card-body">
                        <p class="login-box-msg">Sign in to start your session</p>
    
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"  name="email" value="{{ old('email') }}" placeholder="Email" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                            </div>
                            <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="showPassword" placeholder="Password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                            <div class="col-8">
                                <input type="checkbox" onclick="show()">
                                    Show Password
                            </div>
                            </div>
                            <div class="text-center mt-2 mb-3">
                                <button type="submit" name="login" id="login" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
 
    

    
    <!-- Main Footer -->
    <footer class="main-footer" style="position:absolute; bottom:0; width:100%; height:0px;">
        <!-- Default to the center -->
        <center>
            <b>{{ config('app.name') }}</b> Copyright &copy; <b> 2024 <a href="mailto:agussaputragalih@gmail.com">Galih Agus Saputra</a> </b>
        </center>
    </footer>

</div>
<!-- REQUIRED SCRIPTS -->
@include('layouts.javascript')

<script>
function show() {
  var x = document.getElementById("showPassword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

</body>
</html>
