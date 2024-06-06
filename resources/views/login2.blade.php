<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ config('app.name', 'Laravel') }} - Log In</title>

    @include('layouts.header')

<style>
.main-center {
   margin: 0 auto;
   max-width: 400px;
   padding: 40px 40px;
   position:absolute;
   left:0;
   right:0;
   top: 50%;
   transform: translateY(-50%);
}

</style>

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-dark navbar-light">    
    <div class="row col-12">
        <span class="navbar-brand brand-text font-weight-light">
            &emsp; <i class="fa fa-globe"></i>
            {{ config('app.name') }}
        </span>
    </div>
  </nav>

    <!-- Main content -->
    <div class="content-wrapper">
      <div class="container">
        <div class="row">

            <div class="main-center">
                <div class="login-box">
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
      </div>
    </div>

  </div>
 
  @include('layouts.footer')

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
