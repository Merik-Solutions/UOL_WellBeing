<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@if (env('APP_NAME'))
        {!! env('APP_NAME') !!} @else Kinda Health
        @endif</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{!! assets('dashboard/light/assets/images/favicon.ico')!!}">

    <!-- App css -->
    <link href="{!! assets('dashboard/light/assets/css/bootstrap.min.css')!!}" rel="stylesheet" type="text/css" />
    <link href="{!! assets('dashboard/light/assets/css/icons.min.css')!!}" rel="stylesheet" type="text/css" />
    @if (app()->getLocale() == 'ar')
    <link href="{!! assets('dashboard/light/assets/css/app-rtl.min.css')!!}" rel="stylesheet" type="text/css" />
    @else
    <link href="{!! assets('dashboard/light/assets/css/app.min.css')!!}" rel="stylesheet" type="text/css" />
    @endif
</head>


<body class="authentication-bg">

    <div class="home-btn d-none d-sm-block">
        <a href="{!! url('/') !!}"><i class="fas fa-home h2 text-light"></i></a>
    </div>

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center">
                        <a href="{!! url('/') !!}">
                            <span><img src="{!! assets('dashboard/logo.png') !!}" width="200" alt=""></span>
                        </a>
                        <p class="text-muted mt-2 mb-4">{!! env("APP_NAME") !!}</p>
                    </div>
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">{!! __("Sign In") !!}</h4>
                            </div>

                            <form method="POST" action="{{ route('admin.login') }}" aria-label="{{ __('Login') }}">
                                {!! csrf_field() !!}

                                {{--

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                        </div>
                    </div>
                </div>--}}
                <div class="form-group mb-3">
                    <label for="emailaddress">{!! __("Email address") !!}</label>
                    <input type="email" placeholder="Enter your email" id="email"
                        class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password">{!! __("Password") !!}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="checkbox-signin" name="remember"
                            id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="checkbox-signin"> {!! __('Remember me')!!}</label>
                    </div>
                </div>

                <div class="form-group mb-0 text-center">
                    <button class="btn btn-primary btn-block" type="submit"> {!! __("Login") !!}</button>
                </div>

                </form>

            </div> <!-- end card-body -->
        </div>
        <!-- end card -->


        <!-- end row -->

    </div> <!-- end col -->
    </div>
    <!-- end row -->
    </div>
    <!-- end container -->
    </div>
    <!-- end page -->


    <!-- Vendor js -->
    <script src="{!! assets('dashboard/light/assets/js/vendor.min.js')!!}"></script>

    <!-- App js -->
    <script src="{!! assets('dashboard/light/assets/js/app.min.js') !!}"></script>

</body>

</html>
