@extends("layouts.app")
@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Formulaires</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Fiches</a></li>
                                <li class="breadcrumb-item active">Formulaires</li>
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
                <div class="col-xl-3 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <h5 class="fs-16">Filtres</h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="" class="link-secondary text-decoration-underline" id="clear-filters"> Effacer tout</a>
                                </div>
                            </div>
                        </div>

                        <div class="accordion accordion-flush filter-accordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingBrands">
                                    <button class="accordion-button bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseBrands" aria-expanded="true" aria-controls="flush-collapseBrands">
                                        <span class="text-muted text-uppercase fs-12 fw-medium">Operateurs</span> <span class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
                                    </button>
                                </h2>

                                <div id="flush-collapseBrands" class="accordion-collapse collapse show" aria-labelledby="flush-headingBrands">
                                    <div class="accordion-body text-body pt-0">

                                        <div class="d-flex flex-column gap-2 mt-3 filter-check">
                                            <select class="form-control " id="operateur-select" size="15" multiple>
                                            @foreach($acteurs as $acteur)
                                            <option  value="{{$acteur->id}}">{{$acteur->nom_acteur}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">

                            </div>
                            <!-- end accordion-item -->
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

                <div class="col-xl-9 col-lg-8">
                    <div>
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="row g-4">
                                    <div class="col-sm-auto">
                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModalfiche"><i class="ri-add-line align-bottom me-1"></i> Ajouter fiche</button>
                                        <button type="button" class="btn btn-warning add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#downloadModal"><i class="ri-file-download-line  align-bottom me-1"></i> Télécharger </button>

                                    </div>
                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input id="searchFiches" type="text" class="form-control search" placeholder="Rechercher...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <div class="card-header">

                            <div class="row align-items-center">
                                <div id="items-list" class="table-responsive table-card my-1 mx-1">
                                    @include("pages.fichespartial")
                                </div>


                            </div>
                        </div>

                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
            <div class="modal fade" id="showModalfiche" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" action="{{route('fiche.create')}}" method="POST" autocomplete="off">
                            @csrf
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="email-field" class="form-label">Fiche</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter le nom du fiche" required />
                                    <div class="invalid-feedback">Entrer le nom du fiche.</div>
                                </div>
                                <div>
                                    <label for="dom" class="form-label">Acteurs</label>
                                    <select class="form-control" name="choices[]" id="choices" multiple >
                                        @foreach ($acteurs as $choice)
                                        <option value="{{ $choice->id }}" >{{ strtoupper($choice->nom_acteur) }}</option>
                                        @endforeach
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
            <div class="modal fade" id="showModalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" action="{{route('fiche.update')}}" method="POST" autocomplete="off">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3" id="modal-id" style="display: none;">
                                    <label for="id-field" class="form-label">ID</label>
                                    <input type="text" id="id" name="id" class="form-control" placeholder="ID" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="email-field" class="form-label">Fiche</label>
                                    <input type="text" id="nameFiche" maxlength="255" name="nameFiche" class="form-control" placeholder="Enter le nom du fiche" required />
                                    <div class="invalid-feedback">Entrer le nom du fiche.</div>
                                </div>
                                <div>
                                    <label for="dom" class="form-label">Acteurs</label>
                                    <select class="form-control" name="acteurs[]" id="acteurs" multiple >
                                        @foreach ($acteurs as $choice)
                                        <option value="{{ $choice->id }}" >{{ strtoupper($choice->nom_acteur) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-success" id="add-btn">Modifier</button>
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
                            <h4>Télécharger les fiches en fichier :</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                        </div>
                        <div class="modal-body d-flex justify-content-center align-items-center">

                                <form action="/excel" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="fiches" hidden>
                                    <button type="submit" class="btn btn-success"><i class="ri-file-download-line"></i> Excel</button>
                                </form>
                                <form action="/pdf" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="fiches" hidden>
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
                                    <p class="text-muted mx-4 mb-0">Êtes vous sûr de vouloir supprimer cette fiche ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Annuler</button>
                                <form action="{{route('fiche.delete')}}" method="POST">
                                    @csrf
                                <input type="text" id="idFiche"  name="idFiche" hidden>
                                <button type="submit" class="btn w-sm btn-primary" id="delete-record">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center" id="templateSpinner" style="display:none">
            <div class="spinner-border text-primary" id="spinner" style="display:none">

            </div>
    </div>
        <!-- container-fluid -->
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            var urlParams = new URLSearchParams(window.location.search);
            var query = urlParams.get('name') || '';
            $('#searchFiches').val(query);
            if(urlParams.get('operateur_id')!==null)
                {var operateur=urlParams.get('operateur_id').split(",");
                const selectElement=document.getElementById("operateur-select")
                for (const option of selectElement.options) {
                    option.selected=operateur.includes(option.value);
                }}
            function updateResults(test){
                if(test)
                    {
                    template=$('#templateSpinner').clone();
                    template.removeAttr("style");
                    template.find('#spinner').removeAttr("style");
                    $('#items-list').html(template);}
                let query = $("#searchFiches").val();
                let opp=$('#operateur-select').val()
                $.ajax({
                    url: "/fiches",
                    method: 'GET',
                    data: { name: query,
                    operateur_id:opp
                    },
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
                history.replaceState(null, null, "?name=" + encodeURIComponent(query) + "&operateur_id=" + encodeURIComponent(opp.join(',')));
            }
            $('#searchFiches').on('keyup', function() {
            updateResults(false);
            });
            $('#operateur-select').each(function(){
                var select = $(this), values = {};
                $('option',select).each(function(i, option){
                    values[option.value] = option.selected;
                }).click(function(event){
                    values[this.value] = !values[this.value];
                    $('option',select).each(function(i, option){
                        option.selected = values[option.value];
                    });
                    updateResults(true);
                });
            });
            $("#choices").each(function(){
                var select = $(this), values = {};
                $('option',select).each(function(i, option){
                    values[option.value] = option.selected;
                }).click(function(event){
                    values[this.value] = !values[this.value];
                    $('option',select).each(function(i, option){
                        option.selected = values[option.value];
                    });
                });
            });

            $('#clear-filters').click(function() {
                $('#searchFiches').val('');
                $('#operateur-select').val([]);
                updateResults(false);
            });
        });
        deleteFiche= function(id)
        {
            idInput=document.getElementById("idFiche");
            idInput.value=id;
        }
        updateFiche=function(fiche)
        {   let values= {};
            for (const key in fiche.operateur)
            {
                values[key]=true;
            }
            selectElement=document.getElementById("acteurs");
                for (var i = 0; i < selectElement.options.length; i++) {
                if (values.hasOwnProperty(selectElement.options[i].value) && values[selectElement.options[i].value] ) {
                    selectElement.options[i].selected = true;
                }
                }

                $('option',"#acteurs").each(function(i, option){
                    values[option.value] = option.selected;
                }).click(function(event){
                    values[this.value] = !values[this.value];
                    $('option',"#acteurs").each(function(i, option){
                        option.selected = values[option.value];
                    });

            });
            document.getElementById("id").value=fiche.id;
            document.getElementById("nameFiche").value=fiche.name;
        }
    </script>
@endsection
