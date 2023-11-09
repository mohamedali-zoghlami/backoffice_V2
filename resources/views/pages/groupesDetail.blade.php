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
                        <h4 class="mb-sm-0">Gestion des Formulaires</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active"><a href="/groupes">Les groupes</a> > Formulaire</li>
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
                                            <button type="button" onclick="createForm()" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Ajouter Formulaire</button>
                                            <button type="button" onclick="createForm2()" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showMod"><i class="ri-add-line align-bottom me-1"></i> Ajouter Fichier</button>
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
                                        @include("pages.groupesDetailpartial")
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
                        <form class="tablelist-form" id="formDomaine" action="/groupeDetail/create" autocomplete="off" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3" id="modal-id" style="display: none;">
                                    <label for="id-field" class="form-label"></label>
                                    <input type="text" id="groupe" name="groupe" class="form-control" placeholder="ID" value="{{$groupe_id}}" readonly />
                                </div>
                                <input hidden name="type2" value="formulaire">
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Formulaires</label>
                                    <select class="form-control choices-single" name="form" id="selectActeur" required>
                                        <option data-tokens="" value="">Sélectionnez un formulaire</option>
                                        @foreach ($forms as $operateur )
                                            <option data-tokens="{{$operateur->name}}" value="{{$operateur->id}}">{{strtoupper($operateur->name)}}</option>
                                        @endforeach
                                    </select>
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
                                    <label for="operateur_id" class="form-label">Depend d'autre formulaire/fichier :</label>
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
                                <h6 class="text-muted">Le type est important au cas où vous choisissez un prioirté existante</h6>
                                <h6 class="text-muted">Permutation : le formulaire qui à la priorité sélectionné prend la priorité {{$priorite+1}} </h6>
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
            <div class="modal fade" id="showMod" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" id="formDomaine" action="/groupeDetail/create" autocomplete="off" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3" id="modal-id" style="display: none;">
                                    <label for="id-field" class="form-label"></label>
                                    <input type="text" id="groupe" name="groupe" class="form-control" placeholder="ID" value="{{$groupe_id}}" readonly />
                                </div>
                                <input hidden name="type2" value="fichier">
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Fichier</label>
                                    <select class="form-control choices-single" name="form" id="selectActeur1" required>
                                        <option data-tokens="" value="">Selectionnez un fichier</option>
                                        @foreach ($fichier as $operateur )
                                            <option data-tokens="{{$operateur->name}}" value="{{$operateur->id}}">{{strtoupper($operateur->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Depend d'autre formulaire/fichier :</label>
                                    <select class="form-control" data-trigger name="dep" id="dep" required>
                                            <option value="O">Oui</option>
                                            <option value="N">Non</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Priorité</label>
                                    <select class="form-control" data-trigger name="priorite" id="priorite3" required>
                                        @for ($i=$priorite+1;$i>=1 ;$i-- )
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Type</label>
                                    <select class="form-control" data-trigger name="type" id="type" required>
                                        <option value="decalage">Décalage</option>
                                        <option value="permutation">Permutation</option>
                                    </select>
                                </div>
                                <h6 class="text-muted">Le type est important au cas où vous choisissez un prioirté existante</h6>
                                <h6 class="text-muted">Permutation : le formulaire qui à la priorité sélectionné prend la priorité {{$priorite+1}} </h6>
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
                        <form class="tablelist-form" id="formDomaine" action="/groupeDetail/update" autocomplete="off" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="text" name="type2" id="type3" hidden>
                                <div class="mb-3" id="modal-id" style="display: none;">
                                    <label for="id-field" class="form-label"></label>
                                    <input type="text" id="groupe" name="groupe" class="form-control" placeholder="ID" value="{{$groupe_id}}" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Formulaires</label>
                                    <input class="form-control" id="formName" disabled>
                                </div>
                                <input hidden id="form2" name="form" >
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Priorité</label>
                                    <select class="form-control" data-trigger name="priorite" id="priorite2" required>
                                        @for ($i=$priorite;$i>=1 ;$i-- )
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="operateur_id" class="form-label">Depend d'autre formulaire/fichier :</label>
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
                                <h6 class="text-muted">Permutation : le formulaire qui à la priorité sélectionné prend la priorité {{$priorite++}} </h6>
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
                            <h4>Télécharger les groupes en fichier </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                        </div>
                        <div class="modal-body d-flex justify-content-center align-items-center">

                                <form action="/excel" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="groupesdetails" hidden>
                                    <input name="id" value="{{$groupe_id}}" hidden>
                                    <button type="submit" class="btn btn-success"><i class="ri-file-download-line"></i> Excel</button>
                                </form>
                                <form action="/pdf" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="groupesdetails" hidden>
                                    <input name="id" value="{{$groupe_id}}" hidden>

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
                                    <p class="text-muted mx-4 mb-0">Êtes vous sur de vouloir supprimer ce groupe ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Annuler</button>
                                <form action="{{route('groupeDetails.delete')}}" method="POST">
                                    @csrf
                                    <input type="text" name="id" value="{{$groupe_id}}" hidden>
                                <input type="text" name="form" id="idDomaine" hidden>
                                <input type="text" nmae="type" id="type2" hidden>
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

            const schema =new Choices(document.getElementById("selectActeur"), {
                searchResultLimit: 50,
                classNames: {
                containerInner: 'choices__inner ',
                input: 'form-control',
                item: 'choices__item sa', // Add a custom class here
                highlightedState: 'text-info',
                selectedState: 'text-primary',
                },
            });
            const schema2 =new Choices(document.getElementById("selectActeur1"), {
                searchResultLimit: 50,
                classNames: {
                containerInner: 'choices__inner ',
                input: 'form-control',
                item: 'choices__item sa', // Add a custom class here
                highlightedState: 'text-info',
                selectedState: 'text-primary',
                },
            });
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

        deleteDomaine=function(id,type){
            idInput=document.getElementById("idDomaine");
            idInput.value=id;
            $("#type2").val(type);
        }
        updateDomaine=function(id,name,priorite,type,dep){
            $("#formName").val(name);
            $("#form2").val(id);
            $("#priorite2").val(priorite)
            $("#type3").val(type);
            $("#dep2").val(dep)
        }
        createForm1=function()
        {   $("#priorite3").val(@json($priorite));
        }
        createForm=function()
        {   $("#priorite").val(@json($priorite));
        }});
    </script>
@endsection
