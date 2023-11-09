@extends("layouts.app")

@section('content')
<style>
    .sa{
        margin-left: 10px
    }
    .choices__list--dropdown,
.choices__list[aria-expanded] {
  word-break: break-word;
  width: max-content;
}
</style>
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Gestion des Utilisateurs</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Connexions > Utilisateurs</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <button type="button" class="btn btn-primary add-btn" onclick="userCreate()" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Ajouter un utilisateur</button>
                                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#sendMail"><i class="ri-mail-send-line  align-bottom me-1"></i> Envoyer un mail </button>
                                            <button type="button" class="btn btn-warning add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#downloadModal"><i class="ri-file-download-line  align-bottom me-1"></i> Télécharger </button>

                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" id="searchUser" class="form-control search" placeholder="Rechercher...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="items-list" class="table-responsive table-card mt-3 mb-1">
                                        @include("pages.userspartial")
                                </div>


                            </div>
                        </div><!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
             <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" id="formUser" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="text" id="id" name="id" hidden>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Utilisateur</label>
                                    <input type="text" id="name" name="name" class="form-control" maxlength="255" placeholder="Entrer le nom" required />
                                    <div class="invalid-feedback">Entrer le nom de l'utilisateur</div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" maxlength="255" placeholder="Entrer L'email" required />
                                    <div class="invalid-feedback">Entrer l'email de l'utilisateur</div>
                                </div>
                                <div>
                                    <label for="role" class="form-label">Rôle</label>
                                    <select class="form-control" data-trigger name="role" id="role" readonly required>
                                        <option value="3" selected>Opérateur</option>
                                    </select>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Acteur</label>
                                    <select class="form-control choices-single w-100" name="operateur_id" id="operateur_id" required >
                                        <option value="">Sélectionnez un opérateur</option>
                                        @foreach ($operateurs as $acteur )
                                            <option class="mx-2" data-tokens="{{$acteur->nom_acteur}}" value="{{$acteur->id}}">{{ strtoupper($acteur->nom_acteur) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-success" id="add-btn">Ajouter</button>
                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade zoomIn" id="downloadModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Télécharger les utilisateurs en fichier :</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                        </div>
                        <div class="modal-body d-flex justify-content-center align-items-center">

                                <form action="/excel" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="user" hidden>
                                    <button type="submit" class="btn btn-success"><i class="ri-file-download-line"></i> Excel</button>
                                </form>
                                <form action="/pdf" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="user" hidden>
                                    <button type="submit" class="btn btn-warning"><i class="ri-file-download-line"></i> PDF</button>
                                </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="sendMail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel">Email</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" action="{{route('email.send')}}" method="POST" id="emailForm" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="text" id="id" name="id" hidden>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Utilisateur email :</label>
                                    <input type="email" name="email" class="form-control" placeholder="Entrer l'email d'utilisateur" required />
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Sujet</label>
                                    <input type="text" name="sujet" class="form-control" placeholder="Entrer Le sujet" required />
                                </div>
                                <div>
                                    <label for="role" class="form-label">Contenu</label>
                                    <textarea class="form-control"  name="contenu"  required>
                                    </textarea>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Acteur</label>
                                    <input class="form-control" type="file" name="file">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-success" id="send-btn">Envoyer</button>
                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-2 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#25a0e2,secondary:#00bd9d" style="width:100px;height:100px"></lord-icon>
                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Êtes vous sûr ?</h4>
                                    <p class="text-muted mx-4 mb-0">Êtes vous sûr de vouloir supprimer cet utilisateur ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Annuler</button>
                                <form method="POST" action="{{route('user.delete')}}">
                                    @csrf
                                <input id="idUser" name="idUser" style="display: none" readonly>
                                <button type="submit" class="btn w-sm btn-primary" id="delete-record">Supprimer !</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
@endsection
@section("script")
<script>
$(document).ready(function() {
    const schema= new Choices(document.querySelector(".choices-single"), {
          shouldSort: false,
          classNames: {
            containerInner: 'choices__inner',
            input: 'form-control',
            item: 'choices__item sa',
            highlightedState: 'text-info',
            selectedState: 'text-primary',
          },
        });
        // Loop through each select element and initialize Choices.js
        $("#emailForm").on("submit",function(){
            $("#send-btn").attr("disabled",true);
        })
        var urlParams = new URLSearchParams(window.location.search);
        var query = urlParams.get('name') || '';
        $('#searchUser').val(query);

        $('#searchUser').on('keyup', function() {
            let query = $(this).val();
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                method: 'GET',
                data: { name: query },
                success: function(data) {
                    $('#items-list').html(data);
                }
            }).fail(function (jqXHR) {
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
            history.replaceState(null, null, "?name="+ encodeURIComponent(query));
        });
        userUpdate=function(form){
            document.getElementById("formUser").action="/user/update";
            document.getElementById("id").value=form.id;
            document.getElementById("name").value=form.name;
            document.getElementById("email").value=form.email;
            schema.setValue([form.operateur_id.toString()]);
            schema.setChoiceByValue(form.operateur_id.toString());
        }
        userCreate=function()
            {  document.getElementById("formUser").action="/user/create";
                document.getElementById("name").value="";
                document.getElementById("email").value="";
                document.getElementById("role").selectedIndex=0;
                schema.setValue([""]);
            schema.setChoiceByValue("");
            }
    });
 userDelete=function(id)
 {
    idInput=document.getElementById("idUser");
    idInput.value=id;
 }


</script>
@endsection
