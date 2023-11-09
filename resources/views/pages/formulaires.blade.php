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
                                <li class="breadcrumb-item"><a href="{{route('fiche')}}">Fiches</a></li>
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
            <div class="d-flex">
                <div class="flex-grow-1">
                    <h5 class="fs-16">Filtres</h5>
                </div>
                <div class="flex-shrink-0">
                    <a href="" class="link-secondary text-decoration-underline" id="clear-filters">Effacer tout</a>
                </div>
            </div>


                <div class="">
                    <div>
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="row g-4">
                                    <div class="col-sm-auto">
                                        <form method="POST" action="/formulaires">
                                            @csrf
                                            <input type="text" id="id" name="id" value="{{$idFiche}}" hidden>
                                            <button type="submit" class="btn btn-success add-btn"  id="create-btn" ><i class="ri-add-line align-bottom me-1"></i> Ajouter Formulaire</button>
                                        </form>
                                    </div>
                                    <div class="col-sm-auto">
                                        <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModalformulaire"><i class="ri-add-line align-bottom me-1"></i> Ajouter Fichier Excel </button>

                                    </div>
                                    <div class="col-sm-auto">
                                        <button type="button" class="btn btn-warning add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#downloadModal"><i class="ri-file-download-line  align-bottom me-1"></i> Télécharger </button>
                                    </div>
                                    <div class="col-sm">
                                                <select id="searchPer" class="form-control">
                                                    <option value="">Toutes les périodicités</option>
                                                    <option value="mensuelle">Mensuelle</option>
                                                    <option value="trimestrielle">Trimestrielle</option>
                                                    <option value="semestrielle">Semestrielle</option>
                                                    <option value="annuelle">Annuelle</option>
                                                </select>

                                    </div>
                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" class="form-control search" id="searchForms" placeholder="Rechercher...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                            <li class="nav-item">
                                                <form method="POST" action="/deleteType">
                                                    @csrf
                                                    <input type="text"  id="id" name="id" value="{{$idFiche}}" class="form-control" placeholder="ID" hidden />
                                                <button type="submit" style="background-color:transparent"  class="nav-link @if(session()->has('fichier')===false&&session()->has('intern')===false) active @endif fw-semibold" data-bs-toggle="tab" id="formButton" role="tab" @if(session()->has('fichier')===false&&session()->has('intern')===false) disabled @endif>
                                                    Formulaires publiques
                                                </button>
                                            </form>
                                            </li>
                                            <li class="nav-item">
                                                <form method="POST" action="/setType">
                                                    @csrf
                                                    <input type="text"  id="id" name="id" value="{{$idFiche}}" class="form-control" placeholder="ID" readonly hidden/>
                                                <button type="submit" style="background-color:transparent"  class="nav-link @if(session()->has('fichier')) active @endif fw-semibold" data-bs-toggle="tab" id="fileButton"  role="tab" @if(session()->has("fichier")) disabled @endif>
                                                    Fichiers Excel
                                                </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form method="POST" action="/setInt">
                                                    @csrf
                                                    <input type="text"  id="id" name="id" value="{{$idFiche}}" class="form-control" placeholder="ID" readonly hidden/>
                                                <button type="submit" style="background-color:transparent"  class="nav-link @if(session()->has('intern')) active @endif fw-semibold" data-bs-toggle="tab" id="fileButton"  role="tab" @if(session()->has("intern")) disabled @endif>
                                                    Formulaires Internes
                                                </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="items-list" class="table-responsive table-card mt-3 mb-1">
                                        @include("pages.formulairespartial")
                                    </div>

                                </div>
                            </div>
                        </div>

                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div>
                <!-- end col -->
            <!-- end row -->
            <div class="modal fade" id="showModalfiche" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" autocomplete="off">
                            <div class="modal-body">
                                <div class="mb-3" id="modal-id" style="display: none;">
                                    <label for="id-field" class="form-label">ID</label>
                                    <input type="text" class="form-control" placeholder="ID" readonly />
                                </div>

                                <div class="mb-3">
                                    <label for="email-field" class="form-label">Fiche</label>
                                    <input type="email" id="email-field" class="form-control" maxlength="255" placeholder="Enter le nom du fiche" required />
                                    <div class="invalid-feedback">Entrer le nom du ficher.</div>
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
            <div class="modal fade" id="showModalformulaire" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" method="POST" action="{{route('file.create')}}" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3" id="modal-id" style="display: none;">
                                    <label for="id-field" class="form-label">ID</label>
                                    <input type="text"  id="id" name="id" value="{{$idFiche}}" class="form-control" placeholder="ID" readonly />
                                </div>

                                <div class="mb-3">
                                    <label for="email-field" class="form-label">Fichier</label>
                                    <input type="text" id="name" name="name" maxlength="255" class="form-control" placeholder="Enter le nom du fichier" required />
                                    <div class="invalid-feedback">Entrer le nom du fichier.</div>
                                </div>
                                <div>
                                    <label for="status-field" class="form-label">Periodicite</label>
                                    <select class="form-control" data-trigger name="periodicite" id="periodicite" required>
                                        <option value="mensuelle">Mensuelle</option>
                                        <option value="trimestrielle">Trimestrielle</option>
                                        <option value="semestrielle">Semestrielle</option>
                                        <option value="annuelle">Annuelle</option>
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="status-field" class="form-label">Visibilité</label>
                                    <select class="form-control" data-trigger name="visibility" id="visibility" required>
                                        <option value="PUBLIQUE" selected>Publique</option>

                                    </select>
                                </div>
                                <br>
                                <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xlsx, .xls" required>
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
            <div class="modal fade" id="showModalformulaireUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" method="POST" action="{{route('file.update')}}" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3" id="modal-id" style="display: none;">
                                    <label for="id-field" class="form-label">ID</label>
                                    <input type="text"  id="idFile" name="idFile" class="form-control" placeholder="ID" readonly />
                                </div>

                                <div class="mb-3">
                                    <label for="email-field" class="form-label">Fichier</label>
                                    <input type="text" id="nameFile" name="nameFile" maxlength="255" class="form-control" placeholder="Enter le nom du fichier" required />
                                    <div class="invalid-feedback">Entrer le nom du fichier.</div>
                                </div>
                                <div>
                                    <label for="status-field" class="form-label">Periodicite</label>
                                    <select class="form-control" data-trigger name="periodiciteFile" id="periodiciteFile" required>
                                        <option value="mensuelle">Mensuelle</option>
                                        <option value="trimestrielle">Trimestrielle</option>
                                        <option value="semestrielle">Semestrielle</option>
                                        <option value="annuelle">Annuelle</option>
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="status-field" class="form-label">Visibilité</label>
                                    <select class="form-control" data-trigger name="visibilityFile" id="visibilityFile" required>
                                        <option value="PUBLIQUE">Publique</option>
                                    </select>
                                </div>
                                <br>
                                <input type="file" name="excel_file" id="excel_file" class="swal2-file" accept=".xlsx, .xls">
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
                                    <p class="text-muted mx-4 mb-0">Êtes vous sûr de vouloir supprimer cette formulaire ?</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Annuler</button>
                            <form action="{{route('formulaire.delete')}}" method="POST">
                                @csrf
                            <input type="text" id="idFormulaire" name="idFormulaire" hidden>
                            <input type="text" id="typeForm" name="type" hidden>
                            <button type="submit" class="btn w-sm btn-primary" id="delete-record">Supprimer !</button>
                            </form>
                        </div>
                    </div>
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
                                <input type="text" id="id" name="id" value="{{$idFiche}}" hidden>
                                <button type="submit" class="btn btn-success"><i class="ri-file-download-line"></i> Excel</button>
                            </form>
                            <form action="/pdf" class="m-4" method="POST">
                                @csrf
                                <input type="text" id="id" name="id" value="{{$idFiche}}" hidden>
                                <button type="submit" class="btn btn-warning"><i class="ri-file-download-line"></i> PDF</button>
                            </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade zoomIn" id="deleteRecordModal2" tabindex="-1" aria-hidden="true">
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
                                    <p class="text-muted mx-4 mb-0">Êtes vous sûr de vouloir supprimer ce fichier ?</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Annuler</button>
                            <form action="{{route('file.delete')}}" method="POST">
                                @csrf
                            <input type="text" id="idFichier" name="idFichier" hidden>
                            <button type="submit" class="btn w-sm btn-primary" id="delete-record">Supprimer !</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-xl" id="formRender" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 id="nomform" class="fs-16 mb-0 flex-grow-1 text-truncate task-title text-primary  fw-bold">

                            </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                    </div>
                    <div class="form">

                        <form class="modal-body" id="formdatamodal" enctype="multipart/form-data" method="POST" action="">


                        </form>
                    </div>
                </div>
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
            var periodicite=urlParams.get('periodicite') || '';
            $('#searchForms').val(query);
            $('#searchPer').val(periodicite);
            function updateResults(){
                let query = $("#searchForms").val();
                let per=$('#searchPer').val();
                $.ajax({
                    url:window.location.pathname,
                    method: 'GET',
                    data: { name: query,
                    periodicite:per,
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
                history.replaceState(null, null, "?name=" + encodeURIComponent(query) + "&periodicite=" + encodeURIComponent(per));
            }
            $('#searchForms').on('keyup', function() {
            updateResults();
            });
            $("#searchPer").on("change",function()
            {
                updateResults();
            })
            $('#clear-filters').click(function() {
                $('#searchForms').val('');
                $('#searchPer').val('');
                updateResults();
            });
        });
        handleClickk=function(form,test)
            {
                $("#nomform").text(form.name);
            event.preventDefault();
                formData=JSON.parse(form.formJson);
                var formioElement =  document.getElementById('formdatamodal');
                var formulaires=Formio.createForm(formioElement,JSON.parse(form.formJson),{
            readOnly: true,
            highlightErrors : true,
            } );
        }
        deleteForm=function(id,type)
        {
            idInput=document.getElementById("idFormulaire");
            types=document.getElementById("typeForm");
            types.value=type;
            idInput.value=id;
        }
        deleteFichier=function(id)
        {
            idInput=document.getElementById("idFichier");
            idInput.value=id;
        }
        updateFichier=function(id,name,periodicite,visibilite)
        {  
            document.getElementById("idFile").value=id;
            document.getElementById("nameFile").value=name;
            selectElement=document.getElementById("periodiciteFile");
            for (const option of selectElement.options) {
                option.selected=(periodicite===option.value);
            }
            selectElement=document.getElementById("visibilityFile");
            for (const option of selectElement.options) {
                option.selected=(visibilite===option.value);
            }
        }
        download=function(id)
        {   $.ajax({
                url:"/file/download",
                type:'GET',
                data:{
                    id:id,
                    type:"form"
                },
                success: function(response) {
                    if (response.error)
                     {
                        Swal.fire({
                            icon: 'error',
                            title: response.error,
                            showConfirmButton: false,
                            timer: 1500
                            });
                    }
                    else
                    {
                        window.location.href=response.download_url;
                        Swal.fire({
                            icon: 'success',
                            title: 'Fichier téléchargé !',
                            showConfirmButton: false,
                            timer: 1500
                            });
                     }
                },
                error: function() {
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
        }
        copieFile= function(form,test){
            if(test)
            {
            $("#idInternCopie").val(form.id);
            $("#fiche_idInternCopie").val(form.fiche_id);
            $("#copieFormForm2").submit();
            }
            else
           { $("#idFormCopie").val(form.id);
            $("#fiche_idFormCopie").val(form.fiche_id);
            $("#copieFormForm").submit();
            }
        }
        updateFile= function(form,test){
            if(test)
            {   $("#idInternUpdate").val(form.id);
                $("#fiche_idInternUpdate").val(form.fiche_id);
                $("#updateFormForm2").submit();}
            else
            {   $("#idFormUpdate").val(form.id);
                $("#fiche_idFormUpdate").val(form.fiche_id);
                $("#updateFormForm").submit();}
        }
    </script>
@endsection
