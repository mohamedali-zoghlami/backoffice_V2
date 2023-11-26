@extends("layouts.app")

@section('content')
    <div class="page-content">
            <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success" id="successAlert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" id="dangerAlert">
                    {{ session('error') }}
                </div>
            @endif

                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDet" role="tab">
                                            <i class="fas fa-home"></i>
                                            Détails personnels
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                            <i class="fas fa-home"></i>
                                            Changer les détails
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                            <i class="far fa-user"></i>
                                            Changer le mot de passe
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDet" role="tabpanel">
                                        <div class="card" style="border-radius: 15px;">
                                            <div class="card-body text-center">
                                              <div class="mt-3 mb-4">
                                                <img src="@if(auth()->user()->image){{ asset('profile_images/' . auth()->user()->image) }} @else https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp @endif"
                                                  class="rounded-circle img-fluid " style="width: 100px;" />
                                              </div>
                                              <h4 class="mb-2">{{auth()->user()->name}}</h4>
                                              <p class="text-muted mb-4">{{auth()->user()->email}}</p>
                                                <button onclick="uploadPhoto()" class="btn btn-primary btn-rounded btn-sm" type="submit">Changer image de profil</button>
                                              <div class=" justify-content-around text-center mt-5 mb-2">
                                                <h4 class="mb-2">@if(auth()->user()->role==="2")Admin @else Super Admin @endif </h4>
                                                <p class="text-muted mb-4">@if(auth()->user()->created_at)Depuis : {{auth()->user()->created_at->format('d-m-Y')}} @endif</p>

                                              </div>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="tab-pane" id="personalDetails" role="tabpanel">
                                        <form action="{{route('changeUser')}}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="firstnameInput" class="form-label">Nom <span class="text-danger">*</span></label>
                                                        <input required type="text" maxlength="255" name="name" class="form-control" id="usernameInput" placeholder="Enter your firstname" value="{{auth()->user()->name}}">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="emailInput" class="form-label">Adresse Email</label>
                                                        <input type="email" class="form-control" id="emailInput" placeholder="Enter your email" value="{{auth()->user()->email}}" disabled readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">

                                                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane" id="changePassword" role="tabpanel">
                                        <p class="alert alert-danger d-none text-center" id="passwordError">

                                        </p>
                                        <form id="myForm" method="POST" action="{{route('changeUser')}}" >
                                            @csrf
                                            <div class="row g-2">
                                                <div class="col-lg-4">
                                                    <div>
                                                        <label for="oldpasswordInput" class="form-label">Ancien mot de passe<span class="text-danger">*</span></label>
                                                        <input type="password" maxlength="255" required class="form-control" name="oldpassword" id="oldpasswordInput" placeholder="Enter current password">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div>
                                                        <label for="newpasswordInput" class="form-label">Nouveau mot de passe<span class="text-danger">*</span></label>
                                                        <input type="password" maxlength="255" class="form-control" required id="newpasswordInput" name="password" placeholder="Enter new password">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div>
                                                        <label for="confirmpasswordInput" class="form-label">Confirmer mot de passe<span class="text-danger">*</span></label>
                                                        <input type="password" maxlength="255" class="form-control" required id="confirmpasswordInput"  placeholder="Confirm password">
                                                    </div>
                                                </div>
                                                <!--end col-->

                                                <!--end col-->
                                            </div>
                                        </form>
                                        <div class="col-lg-12 mt-3">
                                            <div class="text-end">
                                                <button id="changePassButton" class="btn btn-primary">Changer mot de passe</button>
                                            </div>
                                        </div>
                                            <!--end row-->
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->

                </div>
                <!--end row-->
            </div>
            <!-- container-fluid -->
        <!-- container-fluid -->
    </div>
@endsection
@section("script")
<script>
    uploadPhoto=function()
        {
            Swal.fire({
            title: 'Changer votre image !',
            html: `
                <form id="uploadPhoto" action="{{ route('changePicture') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="profile_image" id="imageForm" class="swal2-file" required>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Changer',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                // Access the form field values
                const formElement = document.getElementById('uploadPhoto');
                const excelFileElement = document.getElementById('imageForm');
                const excelFile = excelFileElement.files[0];
                const allowedExtensions = /(\.jpeg|\.png|\.jpg|\.gif)$/i;
                if (!excelFile) {
                Swal.showValidationMessage('Sélectionnez une image');
                }
                else if(!allowedExtensions.exec(excelFileElement.value))
                {
                Swal.showValidationMessage('L"image doit être de type jpeg, jpg, png, gif !');
                }
                return { profile_image: excelFile };
            }
            }).then((result) => {
            if (result.isConfirmed) {
                const excelFile = result.value.profile_image;
                const formData = new FormData();
                formElement=document.getElementById("uploadPhoto")
                formElement.submit();
                        }
                        });
        }
        $(document).ready(function () {
            function isStrongPassword(password) {
    // Define the regular expressions for each criteria
    console.log(password)
    const uppercaseRegex = /[A-Z]/;
    const lowercaseRegex = /[a-z]/;
    const digitRegex = /\d/;
    const specialCharRegex = /[!@#$%^&*(),.?":{}|<>]/;

    // Check if the password meets all criteria
    const hasUppercase = uppercaseRegex.test(password);
    const hasLowercase = lowercaseRegex.test(password);
    const hasDigit = digitRegex.test(password);
    const hasSpecialChar = specialCharRegex.test(password);

    // Return true if all criteria are met, otherwise return false
    return hasUppercase && hasLowercase && hasDigit && hasSpecialChar;
}
            $('#changePassButton').on("click",function (event) {

            $('#successAlert').hide();
            $('#dangerAlert').hide();
            var newpassword=document.getElementById("newpasswordInput").value;
            var confirmpassword=document.getElementById("confirmpasswordInput").value;
            var oldpassword=document.getElementById("oldpasswordInput").value;
            if (newpassword.length<8) {
                $("#alert-success").empty();
                $('#passwordError').text("Le nouveau mot de passe doit être composé de plus de 8 caractères !");
                $('#passwordError').removeClass('d-none');
                event.preventDefault(); // Prevent form submission
                return;
            }
            else if(isStrongPassword(newpassword)==false)
        {
            $("#alert-success").empty();
            $('#passwordError').text("Le nouveau mot de passe doit contenir une lettre majuscule, une miniscule, un chiffre et un caractère spécial !");
            $('#passwordError').removeClass('d-none');
            event.preventDefault(); // Prevent form submission
                return;
        }
            else if(newpassword!=confirmpassword)
            {   $("#alert-success").empty();
                $('#passwordError').text("Le nouveau mot de passe ne correspond pas, retapez confirmer mot de passe !");
                $('#passwordError').removeClass('d-none');
                event.preventDefault(); // Prevent form submission
                return;
            }
            else
            {
                $.ajax({
                    url:"{{route('check.password')}}",
                    type:"POST",
                    data:{
                        password:$("#oldpasswordInput").val(),
                        _token: "{{csrf_token()}}"
                    },
                    success:function(response)
                    {
                        if(response.error)
                        {$("#alert-success").empty();
                        $('#passwordError').text(response.error);
                        $('#passwordError').removeClass('d-none');
                        }
                        else
                        {
                            $("#myForm").submit();
                        }
                    }
                    ,
                    error:function(xhr,statu,error)
                    {
                        console.log(xhr.responseText)
                    }
                }
                ).fail(function (jqXHR) {
                    if (jqXHR.status === 401) {
                        // Session expired, redirect to the login page
                        window.location.href = '/login';
                    }
                    if (jqXHR.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: "Le serveur de base de données distant est injoignable !",
                            confirmButtonText: 'OK'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                                }
                            }).then(() => {
                            location.reload();
                        });
                        }
                });

            }


        })});
    </script>
@endsection
