@extends("layouts.app")

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Gestion des Groupes</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Paramètres > Groupes</li>
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
                                            <button type="button" onclick="" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Ajouter</button>
                                            <button type="button" class="btn btn-warning add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#downloadModal"><i class="ri-file-download-line  align-bottom me-1"></i> Télécharger </button>

                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" id="searchDomaine" class="form-control search" placeholder="Rechercher...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="items-list" class="table-responsive table-card mt-3 mb-1">
                                        @include("pages.groupespartial")
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
                        <form class="tablelist-form" action="/groupe/create" id="formDomaine" autocomplete="off" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3" id="modal-id" style="display: none;">
                                    <label for="id-field" class="form-label">ID</label>
                                    <input type="text" id="id" name="id" class="form-control" placeholder="ID" readonly />
                                </div>

                                <div class="mb-3">
                                    <label for="customername-field" class="form-label">Nom du groupe</label>
                                    <input type="text" id="name" name="nom" maxlength="255" class="form-control" placeholder="Entrer le nom du groupe" required />
                                    <div class="invalid-feedback">Entrer le nom du groupe</div>
                                </div>
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Priorité</label>
                                    <select class="form-control" data-trigger name="priorite" id="priorite" required>
                                        @for ($i=$priorite+1;$i>=1 ;$i-- )
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Dépend d'un autre groupe :</label>
                                    <select class="form-control" data-trigger name="dep" id="dep" required>
                                            <option value="O">Oui</option>
                                            <option value="N">Non</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Type</label>
                                    <select class="form-control" data-trigger name="type" id="type" required>
                                        <option value="decalage">Décalage</option>
                                        <option value="permutation">Permutation</option>
                                    </select>
                                </div>
                                <h6 class="text-muted">Le type est important au cas où vous choisissez une prioirté existante</h6>
                                <h6 class="text-muted">Permutation : le groupe qui à la priorité sélectionnée prend la priorité {{$priorite+1}} </h6>
                            </div>

                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" id="submitDomaineButton" class="btn btn-success" id="add-btn">Ajouter</button>
                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="showModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" action="/groupe/update" id="formDomaine2" autocomplete="off" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3" id="modal-id" style="display: none;">
                                    <label for="id-field" class="form-label">ID</label>
                                    <input type="text" id="id2" name="id" class="form-control" placeholder="ID" readonly />
                                </div>

                                <div class="mb-3">
                                    <label for="customername-field" class="form-label">Nom du groupe</label>
                                    <input type="text" id="name2" name="nom" maxlength="255" class="form-control" placeholder="Entrer le nom du groupe" required />
                                    <div class="invalid-feedback">Entrer le nom du groupe</div>
                                </div>
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Priorité</label>
                                    <select class="form-control" data-trigger name="priorite" id="priorite2" required>
                                        @for ($i=$priorite;$i>=1 ;$i-- )
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Depend d'autre groupe :</label>
                                    <select class="form-control" data-trigger name="dep" id="dep2" required>
                                            <option value="O">Oui</option>
                                            <option value="N">Non</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Type</label>
                                    <select class="form-control" data-trigger name="type" id="type" required>
                                        <option value="decalage">Décalage</option>
                                        <option value="permutation">Permutation</option>
                                    </select>
                                </div>
                                <h6 class="text-muted">Permutation : le groupe qui à la priorité sélectionné prend la priorité {{$priorite++}} </h6>
                            </div>

                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" id="submitDomaineButton" class="btn btn-success" id="add-btn">Modifier</button>
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
                            <h4>Télécharger les groupes en fichier :</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                        </div>
                        <div class="modal-body d-flex justify-content-center align-items-center">

                                <form action="/excel" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="groupes" hidden>
                                    <button type="submit" class="btn btn-success"><i class="ri-file-download-line"></i> Excel</button>
                                </form>
                                <form action="/pdf" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="groupes" hidden>
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
                                    <p class="text-muted mx-4 mb-0">Êtes vous sûr de vouloir supprimer ce groupe ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Annuler</button>
                                <form action="{{route('groupe.delete')}}" method="POST">
                                    @csrf
                                <input type="text" name="id" id="idDomaine" hidden>
                                <button type="submit" class="btn w-sm btn-primary" id="delete-record">Supprmier !</button>
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
            $('#searchDomaine').val(query);

            $('#searchDomaine').on('keyup', function() {
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
        deleteDomaine=function(id){
            idInput=document.getElementById("idDomaine");
            idInput.value=id;
        }
        updateDomaine=function(id,name,priorite,dep){
            $("#submitDomaineButton").text("Modifier");
            document.getElementById("id2").value=id;
            document.getElementById("priorite2").value=priorite;
            document.getElementById("name2").value=name;
            document.getElementById("dep2").value=dep;
        }

    </script>
@endsection
