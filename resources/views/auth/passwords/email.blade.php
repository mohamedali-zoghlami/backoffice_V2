@extends('layouts.app2')

@section('content')
  <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mt-sm-5 mb-4 text-white-50">
                    <div>

                    </div>
                    <p class="mt-3 fs-15 fw-medium"></p>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">

                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <div class="card-header text-center"><span class="logo-lg pb-2">
                                <img src="{{$image_path}}" alt="" height="50">
                            </span>
                            <h4 class=" pt-1 fw-bold" >Backoffice</h4>
                            <h5 class="text-primary pt-3">Mot de passe oublié?</h5>
                            <p class="text-muted">
                                Réinitialiser le mot de passe </p>

                            <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:blue" class="avatar-xl">
                            </lord-icon>
                            </div>
                        </div>

                        <div class="alert alert-borderless alert-warning text-center mb-2 mx-2" role="alert">
                            Saisir votre email et on vous envoi un lien de réinitialisation!
                        </div>
                        <div class="p-2">
                            <p class="alert alert-danger d-none text-center" id="loginError">

                            </p>
                            <form method="POST" onsubmit="return verif(event)" action="{{ route('password.email') }}">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label">Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                <div class="alert alert-danger text-center" role="alert">
                                    E-mail non enregistré !
                                </div>
                                @enderror
                                @if (session('status'))
                                <div class="alert alert-success text-center" role="alert">
                                    E-mail de réinitialisation du mot de passe est correctement envoyé !</div>
                                 @endif
                                 <div class="mb-3 mx-3">
                                    <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}">
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Envoi du lien de réinitalisation !</button>
                                </div>
                            </form><!-- end form -->


                    </div>
                    <!-- end card body -->
                </div>
                <p class="text-muted d-flex mx-auto">Attendez, je me souviens de mon mot de passe... <a href="/login" class="link-primary">Cliquez ici</a></p>
                <!-- end card -->
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
@endsection
@section("script")
<script>
    function verif(e){

            $("#loginError").addClass("d-none");
             if (grecaptcha.getResponse() === "") {
                $('#loginError').text("Captcha est obligatoire !");
                $('#loginError').removeClass('d-none');
                e.preventDefault();
        }
    }
    </script>
@endsection
