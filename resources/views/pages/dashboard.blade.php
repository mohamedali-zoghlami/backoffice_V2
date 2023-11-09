
@extends("layouts.app")
@section("head")
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Gestion des dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Paramètres > Dashboard</li>
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
                                            <button type="button" class="btn btn-warning add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#downloadModal"><i class="ri-file-download-line  align-bottom me-1"></i> Télécharger </button>

                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" id="searchDashboard" class="form-control search" placeholder="Rechercher...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="items-list" class="table-responsive table-card mt-3 mb-1">
                                        @include("pages.dashboardpartial")
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
                        <form class="tablelist-form" autocomplete="off" action="{{route('dashboard.create')}}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nom_ac" class="form-label">Nom du dashboard </label>
                                    <input type="text" id="name" name="name" maxlength="255" class="form-control" placeholder="Enter le nom de l'acteur" required />
                                    <div class="invalid-feedback">Entrer le nom du dashboard.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="dom" class="form-label">Lien</label>
                                    <input type="text" id="lien" name="lien" maxlength="255" class="form-control" placeholder="Enter le nom de l'acteur" required />
                                    <div class="invalid-feedback">Entrer le nom du dashboard.</div>
                                </div>
                                <div>
                                    <label for="dom" class="form-label">Visible</label>
                                    <select class="form-control" name="visible" id="visible"  required>
                                        <option value="oui">Oui</option>
                                        <option value="non">Non</option>
                                    </select>
                                </div>
                                <br>

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
            <div class="modal fade" id="updateModal" tabindex="-1" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" autocomplete="off" action="{{route('dashboard.update')}}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="text" id="id" name="id" hidden>
                                <div class="mb-3">
                                    <label for="nom_ac" class="form-label">Nom du dashboard </label>
                                    <input type="text" id="name2" name="name" maxlength="255" class="form-control" placeholder="Enter le nom de l'acteur" required />
                                    <div class="invalid-feedback">Entrer le nom du dashboard.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="dom" class="form-label">Lien</label>
                                    <input type="text" id="lien2" name="lien" maxlength="255" class="form-control" placeholder="Enter le nom de l'acteur" required />
                                    <div class="invalid-feedback">Entrer le nom du dashboard.</div>
                                </div>
                                <div>
                                    <label for="dom" class="form-label">Visible</label>
                                    <select class="form-control" name="visible" id="visible2"  required>
                                        <option value="oui">Oui</option>
                                        <option value="non">Non</option>
                                    </select>
                                </div>
                                <br>

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
                            <h4>Télécharger les administrateurs en fichier :</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                        </div>
                        <div class="modal-body d-flex justify-content-center align-items-center">

                                <form action="/excel" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="dashboard" hidden>
                                    <button type="submit" class="btn btn-success"><i class="ri-file-download-line"></i> Excel</button>
                                </form>
                                <form action="/pdf" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="dashboard" hidden>
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
                                    <h4>Êtes vous sûr ?</h4>
                                    <p class="text-muted mx-4 mb-0">Êtes vous sûr de vouloir supprimer ce dashboard ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Annuler</button>
                                <form action="{{route('dashboard.delete')}}" method="POST">
                                    @csrf
                                <input type="text" id="idActeur" name="idDashboard" hidden>
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
        $(function() {
   $('[data-toggle="tooltip"]').tooltip();
})
        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            var query = urlParams.get('name') || '';
            $('#searchDashboard').val(query);

            $('#searchDashboard').on('keyup', function() {
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

            document.getElementById("name2").value=acteur.name;
            document.getElementById("lien2").value=acteur.lien;
            $("visible2").val(acteur.visible);
            idVal=document.getElementById("id");
            idVal.value=acteur.id;
        }
    </script>
@endsection
