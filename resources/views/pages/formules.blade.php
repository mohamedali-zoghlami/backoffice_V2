
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
                        <h4 class="mb-sm-0">Gestion des formules</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Paramètres > Formules</li>
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
                                        <div class="d-flex">
                                            <div>
                                            <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Ajouter</button>

                                        </div>
                                        <div class="mx-2">
                                            <select class="form-control choices-single w-100" id="selectActeur">
                                                <option value="">Tous les acteurs</option>
                                            @foreach ($acteurs as $acteur )
                                                <option value="{{$acteur->id}}">{{strtoupper($acteur->nom_acteur)}}
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="col-sm-auto" >
                                                <div class="d-flex justify-content-sm-end">
                                                    <button type="button" class="btn btn-warning add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#downloadModal"><i class="ri-file-download-line"></i> Télécharger</button>
                                                </div>
                                            </div>
                                            <div class="search-box ms-2">

                                                <input type="text" id="searchForm" class="form-control search" placeholder="Rechercher...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="items-list" class="table-responsive table-card mt-3 mb-1">
                                        @include("pages.formulespartial")
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
                        <form class="tablelist-form" action="{{route('formules.create')}}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div>
                                    <label for="dom" class="form-label">Acteur</label>
                                    <select class="form-control choices-single w-100" name="acteur" id="acteur" required>
                                        <option value="">Sélectionnez un acteur</option>
                                        @foreach ($acteurs as $choice)
                                        <option value="{{ $choice->id }}" >{{ strtoupper($choice->nom_acteur) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="dom" class="form-label">Formulaire</label>
                                    <select id="formsSelect" class="form-control choices-single " name="formulaire" disabled>
                                    </select>
                                </div>
                                <br>
                                <label for="dom" class="form-label">Pourcentage</label>
                                <div class="d-flex form-inline">
                                        <select class="form-control w-auto" id="operation" name="operation">
                                            <option value="+" selected>+</option>
                                            <option value="-">-</option>
                                        </select>

                                        <input type="number" class="form-control flex-grow-1" max="100" min="0" id="pourcentage" name="pourcentage" required placeholder="Enter le pourcentage à ajouter ">
                                            <button class="btn btn-secondary" type="button" disabled>%</button>
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
                        <form class="tablelist-form" action="{{route('formules.update')}}" method="POST">
                            @csrf
                            <input type="text" id="idFormule" name="idFormule" hidden>
                            <div class="modal-body">
                                <div>
                                    <label for="dom" class="form-label">Acteur</label>
                                    <select class="form-control" name="acteur" id="acteur2" disabled required>
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="dom" class="form-label">Formulaire</label>
                                    <select id="formsSelect2" class="form-control" name="formulaire" required disabled>
                                    </select>
                                </div>
                                <br>
                                <label for="dom" class="form-label">Pourcentage</label>
                                <div class="d-flex form-inline">
                                        <select class="form-control w-auto" id="operation2" name="operation">
                                            <option value="+">+</option>
                                            <option value="-">-</option>
                                        </select>

                                        <input type="number" class="form-control flex-grow-1" id="pourcentage2" name="pourcentage" min="0" max="100" required placeholder="Enter le pourcentage à ajouter ">
                                            <button class="btn btn-secondary" type="button" disabled>%</button>
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
                            <h4>Télécharger les formules en fichier :</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                        </div>
                        <div class="modal-body d-flex justify-content-center align-items-center">

                                <form action="/excel" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="formules" hidden>
                                    <button type="submit" class="btn btn-success"><i class="ri-file-download-line"></i> Excel</button>
                                </form>
                                <form action="/pdf" class="m-4" method="POST">
                                    @csrf
                                    <input name="source" value="formules" hidden>
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
                                    <p class="text-muted mx-4 mb-0">Êtes vous sur de vouloir supprimer cette formulaire ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Annuler</button>
                                <form action="{{route('formules.delete')}}" method="POST">
                                    @csrf
                                <input type="text" id="idActeur" name="idActeur" hidden>
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
            const schema= new Choices(document.getElementById("selectActeur"), {
          shouldSort: false,
          position: 'bottom',
          classNames: {
            containerInner: 'choices__inner',
            input: 'form-control',
            item: 'choices__item sa',
            highlightedState: 'text-info',
            selectedState: 'text-primary',
          },
        });
        let schema2= new Choices(document.getElementById("formsSelect"), {
            shouldSort: false,
            position: 'bottom',
            classNames: {
                containerInner: 'choices__inner',
                input: 'form-control',
                item: 'choices__item sa',
                highlightedState: 'text-info',
                selectedState: 'text-primary',
            },
            });
        const sch=new Choices(document.getElementById("acteur"), {
          shouldSort: false,
          position: 'bottom',

          classNames: {
            containerInner: 'choices__inner',
            input: 'form-control',
            item: 'choices__item sa',
            highlightedState: 'text-info',
            selectedState: 'text-primary',
          },
        });
            var urlParams = new URLSearchParams(window.location.search);
            var query = urlParams.get('formulaire') || '';
            $('#searchForm').val(query);
            query=urlParams.get("acteur")||"";
            schema.setValue([query]);
            schema.setChoiceByValue(query);
             function updateActeur() {
                let query =  $('#searchForm').val();
                var acteur=$("#selectActeur").val();
                let data={
                    formulaire:query,
                }
                if(acteur.length>0)
                    data["acteur"]=acteur
                console.log(data)
                $.ajax({
                    url: "/formules",
                    method: 'GET',
                    data:data,
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
                history.replaceState(null, null, "?formulaire="+ encodeURIComponent(query)+"&acteur="+encodeURIComponent(acteur));
            };
            $('#searchForm').on('keyup', function() {
                updateActeur();
            })
            $("#selectActeur").on("change",function(){
                updateActeur();
            })
            $('#acteur').change(function() {
                var actorId = $(this).val();

                $.ajax({
                    url: '/getEveryForm/' + actorId,
                    type: 'GET',
                    success: function(response) {
                        schema2.destroy()
                        $('#formsSelect').html(response).prop('disabled', false);
                        $('#formsSelect').html(response).prop('required',true);
                         schema2= new Choices(document.getElementById("formsSelect"), {
                        shouldSort: false,
                        position: 'bottom',
                        classNames: {
                            containerInner: 'choices__inner',
                            input: 'form-control',
                            item: 'choices__item sa',
                            highlightedState: 'text-info',
                            selectedState: 'text-primary',
                        },
                        });
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
            });
        updateActeur=function(acteur){
            $("#idFormule").val(acteur.id);
            var newOption = $('<option>', {
                value: acteur.operateur_id,
                text: acteur.acteur,
                selected:true,
            });
            $("#acteur2").empty();
            $("#acteur2").append(newOption);
            var newOption = $('<option>', {
                value: acteur.form_id,
                text: acteur.name,
                selected:true
            });
            $("#acteur2").val(acteur.operateur_id);
            $("#formsSelect2").empty();
            $("#formsSelect2").append(newOption);
            $("#formsSelect2").val(acteur.form_id);

            $("#operation2").val(acteur.operation);
            $("#pourcentage2").val(acteur.pourcentage)
        }
        });
        deleteActeur=function(id){
            idInput=document.getElementById("idActeur");
            idInput.value=id;
        }

    </script>
@endsection
