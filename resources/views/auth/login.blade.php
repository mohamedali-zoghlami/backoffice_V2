
<!doctype html>
<html >
<head>

    <meta charset="utf-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

    <!-- Layout config Js -->
    <script src="{{asset('assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position bg-dark bg-gradient" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center mt-sm-5 mb-4 text-white-50">
                                <div>
                                <p class="mt-3 fs-15 fw-medium"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-header text-center"><span class="logo-lg">
                                <img src="{{$image_path}}" alt="" height="50">
                            </span>
                            <h4 class=" pt-1 fw-bold" >Backoffice</h4>
                        </div>
                            <p class="alert alert-danger d-none text-center" id="loginError">

                            </p>
                            <div class="card-body">
                                <form id="loginForm" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-4">
                                        <div class="row mx-1">

                                        <label for="email" class="form-label">{{ __('Email') }}</label>
                                        </div>
                                        <div class="mx-3">

                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="email" name="email" id="email" class="form-control"  required>
                                        </div>

                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="row mx-1">
                                        <label for="password" class="">{{ __('Mot de passe') }}</label>
                                        </div>
                                        <div class="mx-3">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">


                                        </div>
                                    </div>

                                    <div class="mb-3 mx-3">
                                        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}">
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="mx-1">


                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Mot de passe oublié?') }}
                                                </a>
                                            @endif


                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="mx-3">


                                            <button type="submit" class="btn  w-100 btn-primary">
                                                {{ __('Login') }}
                                            </button>


                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('partials.footer')

    </div>

    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{asset('assets/js/plugins.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- particles js -->
    <script src="{{asset('assets/libs/particles.js/particles.js')}}"></script>
    <!-- particles app js -->
    <script src="{{asset('assets/js/pages/particles.app.js')}}"></script>
    <!-- password-addon init -->
    <script src="{{asset('assets/js/pages/password-addon.init.js')}}"></script>
    <script>
        $('#loginForm').submit(function(e){

            e.preventDefault();
    /*        if (grecaptcha.getResponse() === "") {
                $('#loginError').text("Captcha est obligatoire !");
                $('#loginError').removeClass('d-none');
        }
        else
        */
        {
            var email = $("input[name='email']").val();
            var password = $("input[name='password']").val();
            var token = $("input[name='_token']").val();
            var data = {email:email, password:password, _token:token};
            $.ajax({
                url:"{{route('login')}}",
                type:'POST',
                data:data,
                dataType:"json",
                    success:function(response){
                        if(response.error){
                            $('#loginError').text(response.error);
                            $('#loginError').removeClass('d-none');
                        }
                        else if(response.success)
                        {

                                location.href = "/";
                        }
                    },
                    error:function(xhr,statu,error){
                        console.log(xhr.responseText)
                    }
                })
            }});
    </script>
</body>

</html>
