@extends('layouts.app2')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center mt-sm-5 mb-4 text-white-50">

            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <span class="logo-lg pb-2">
                            <img src="{{$image_path}}" alt="" height="50">
                        </span>
                        <h4 class=" pt-1 fw-bold" >Backoffice</h4>
                        <h5 class="text-primary pt-3">Réinitaliser votre mot de passe !</h5>
                    </div>

                    <div class="p-2">
                        <form method="POST" id="submitForm" action="{{ route('password.customReset') }}">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                <label class="form-label" for="password-input">Mot de passe</label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                                <div id="passwordInput" class="form-text">Doit comporter au moins 8 caractères.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="confirm-password-input">Confirmer le mot de passe</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="confirm-password-input"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                            </div>
                            <div id="captchaError" class="alert alert-danger text-center d-none" role="alert">

                            </div>
                            <button class="btn btn-primary w-100" type="submit">Réinitaliser</button>
                        </form>
                    </div>
                </div>
                <!-- end card body -->
                <p class="text-muted d-flex mx-auto">Attendez, je me souviens de mon mot de passe... <a href="/login" class="link-primary">Cliquez ici</a></p>
            </div>
            <!-- end card -->



        </div>
    </div>
    <!-- end row -->
</div>
@endsection



@section("script")

<script>
    redirect=function()
    {
        window.location.href="/login"
    }
    document.addEventListener("DOMContentLoaded", function () {
        $('#submitForm').submit(function (event) {
            const email=$("#email").val()
            const hasAtSymbol = email.includes("@");
            if(!hasAtSymbol)
                $("#email").val(decodeURIComponent(email));
            const passwordField = document.getElementById("password");
            const confirmedField = document.getElementById("password-confirm");
            $("#captchaError").addClass("d-none").empty();
        event.preventDefault();

        if(passwordField.value.length<8)
            $("#captchaError").removeClass("d-none").text("Mot de passe doit comporter au moins 8 caractères. !");
        else if(passwordField.value!==confirmedField.value)
            $("#captchaError").removeClass("d-none").text("Mot de passe et confirmer mot de passe ne sont pas identique !");
        else {
            this.submit();
        }
    });

      const passwordField = document.getElementById("password");
      const togglePasswordBtn = document.getElementById("password-addon");

      togglePasswordBtn.addEventListener("click", function () {
        if (passwordField.type === "password") {
          passwordField.type = "text";
        } else {
          passwordField.type = "password";
        }
      });
      const passwordField1 = document.getElementById("password-confirm");
      const togglePasswordBtn1 = document.getElementById("confirm-password-input");

      togglePasswordBtn1.addEventListener("click", function () {
        if (passwordField1.type === "password") {
          passwordField1.type = "text";
        } else {
          passwordField1.type = "password";
        }
      });
    });
  </script>
@endsection





