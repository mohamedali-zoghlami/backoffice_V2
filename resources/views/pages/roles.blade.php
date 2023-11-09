
@extends("layouts.app")

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Gestion des roles</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Paramètres > Roles</li>
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
                                            <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Ajouter</button>

                                        </div>
                                    </div>
                                    <div class="col-sm-auto" >
                                        <div class="d-flex justify-content-sm-end">
                                            <button type="button" class="btn btn-warning add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#downloadModal"><i class="ri-file-download-line"></i> Télécharger</button>
                                        </div>
                                    </div>
                                    <div class="col-sm">

                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" id="searchActeur" class="form-control search" placeholder="Rechercher...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="items-list" class="table-responsive table-card mt-3 mb-1">
                                        @include("pages.rolespartial")
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
                        <form class="tablelist-form" action="/role/create" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nom_ac" class="form-label">Name</label>
                                    <input type="text" name="name" maxlength="255" class="form-control" placeholder="Enter le nom du role" required />
                                    <div class="invalid-feedback">Entrer le nom du role.</div>
                                </div>
                                <div>
                                    <label for="dom" class="form-label">Création :</label>
                                    <select class="form-control" name="create" required>
                                        <option value="oui">Oui</option>
                                        <option selected value="non">Non</option>
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="dom" class="form-label">Mis à jour :</label>
                                    <select class="form-control" name="update" required>
                                        <option value="oui">Oui</option>
                                        <option selected value="non">Non</option>
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="dom" class="form-label">Suppression :</label>
                                    <select class="form-control" name="delete" required>
                                        <option value="oui">Oui</option>
                                        <option selected value="non">Non</option>
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="dom" class="form-label">Gestion des administrateurs :</label>
                                    <select class="form-control" name="admin"  required>
                                        <option value="oui">Oui</option>
                                        <option selected value="non">Non</option>
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
            <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" action="/role/update" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="text" id="id" name="id" hidden>
                                <div class="mb-3">
                                    <label for="nom_ac" class="form-label">Name</label>
                                    <input type="text" id="name" name="name" maxlength="255" class="form-control" placeholder="Enter le nom du role" required />
                                    <div class="invalid-feedback">Entrer le nom du role.</div>
                                </div>
                                <div>
                                    <label for="dom" class="form-label">Création :</label>
                                    <select class="form-control" name="create" id="create" required>
                                        <option value="oui">Oui</option>
                                        <option selected value="non">Non</option>
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="dom" class="form-label">Mis à jour :</label>
                                    <select class="form-control" name="update" id="update" required>
                                        <option value="oui">Oui</option>
                                        <option selected value="non">Non</option>
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="dom" class="form-label">Suppression :</label>
                                    <select class="form-control" name="delete" id="delete" required>
                                        <option value="oui">Oui</option>
                                        <option selected value="non">Non</option>
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="dom" class="form-label">Gestion des administrateurs :</label>
                                    <select class="form-control" name="admin" id="admin" required>
                                        <option value="oui">Oui</option>
                                        <option selected value="non">Non</option>
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-success" id="add-btn">Modifier</button>
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
                            <h4>Télécharger acteur en fichier </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                        </div>
                        <div class="modal-body d-flex justify-content-center align-items-center">

                                <form action="/excel" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="acteurs" hidden>
                                    <button type="submit" class="btn btn-success"><i class="ri-file-download-line"></i> Excel</button>
                                </form>
                                <form action="/pdf" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="acteurs" hidden>
                                    <button type="submit" class="btn btn-warning"><i class="ri-file-download-line"></i> PDF</button>
                                </form>

                        </div>
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
                                    <h4>Êtes vous sur ?</h4>
                                    <p class="text-muted mx-4 mb-0">Êtes vous sur de vouloir supprimer cet acteur ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Annuler</button>
                                <form action="/role/delete" method="POST">
                                    @csrf
                                <input type="text" id="idActeur" name="id" hidden>
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
            var urlParams = new URLSearchParams(window.location.search);
            var query = urlParams.get('name') || '';
            $('#searchActeur').val(query);
            $('#searchActeur').on('keyup', function() {
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
        });
        deleteActeur=function(id){
            idInput=document.getElementById("idActeur");
            idInput.value=id;
        }
        updateActeur=function(acteur){
            $("#name").val(acteur.name);
            $("#id").val(acteur.id);
            if(acteur.privilege.includes("c"))
                $("#create").val("oui")
            else
                $("#create").val("non")
            if(acteur.privilege.includes("u"))
                $("#update").val("oui")
            else
                $("#update").val("non")
            if(acteur.privilege.includes("d"))
                $("#delete").val("oui")
            else
                $("#delete").val("non")
            if(acteur.privilege.includes("a"))
                $("#admin").val("oui")
            else
                $("#admin").val("non")
        }
    </script>
@endsection
