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
                        <h4 class="mb-sm-0">Données</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Données</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
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
            <!-- end page title -->
            <div class="d-flex">
                <div class="flex-grow-1">
                    <h5 class="fs-16">Filtres</h5>
                </div>
                <div class="flex-shrink-0">
                    <a href="" class="link-secondary text-decoration-underline" id="clearall">Effacer tout</a>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                <select class="form-control m-3 choices-single w-100" name="acteur" id="selectActeur" required >
                    <option value="">Sélectionnez un opérateur</option>
                    @foreach ($acteurs as $acteur )
                        <option class="mx-2" data-tokens="{{$acteur->nom_acteur}}" value="{{$acteur->id}}">{{ strtoupper($acteur->nom_acteur) }}</option>
                    @endforeach
                </select>
                </div>
                <div class="col-3">
                <select id="selectFiches" class="form-control m-3">
                    <option value="">Toutes les fiches</option>
                    @foreach ($fiches as $fiche )
                        <option value="{{$fiche->id}}">{{$fiche->name}}</option>
                    @endforeach
                </select>
                </div>
                <div class="col-3">
                <input class="form-control m-3" id="searchForm" placeholder="Entrer le nom du formulaire/fichier...">
                </div>
                <div class="col">
                <select id="annee" class="form-control m-3">
                        <option value=""> Année</option>
                         @for($i=date('Y');$i>=2014;$i--)
                            <option value="{{$i}}">{{$i}}</option>
                         @endfor
                </select>
                </div>
                <div class="col">
                <select id="periodicite" class="form-control m-3">
                        <option value=""> Périodicité</option>
                         @for($i=1;$i<=12;$i++)
                            <option value="{{'M'.$i}}" >M{{$i}}</option>
                         @endfor
                         @for($i=1;$i<=4;$i++)
                            <option value="{{'TR'.$i}}" >TR{{$i}}</option>
                         @endfor
                         <option value="S1" >S1</option>
                         <option value="S2" >S2</option>
                         <option value="A" >A</option>
                </select>
                </div>
            </div>


                <div class="">
                    <div>
                        <div class="card">

                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                            <li class="nav-item">
                                                <form method="POST" action="/deleteType">
                                                    @csrf
                                                    <button type="submit" style="background-color:transparent"  class="nav-link @if(session()->has('fichier')===false&&session()->has('intern')===false&&session()->has('pdf')===false) active @endif fw-semibold" data-bs-toggle="tab" id="formButton" role="tab" @if(session()->has('fichier')===false&&session()->has('intern')===false&&session()->has('pdf')===false) disabled @endif>
                                                    Formulaires publique
                                                </button>
                                            </form>
                                            </li>
                                            <li class="nav-item">
                                                <form method="POST" action="/setType">
                                                    @csrf
                                                    <button type="submit" style="background-color:transparent"  class="nav-link @if(session()->has('fichier')) active @endif fw-semibold" data-bs-toggle="tab" id="fileButton"  role="tab" @if(session()->has("fichier")) disabled @endif>
                                                    Fichiers
                                                </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form method="POST" action="/setInt">
                                                    @csrf
                                                <button type="submit" style="background-color:transparent"  class="nav-link @if(session()->has('intern')) active @endif fw-semibold" data-bs-toggle="tab" id="fileButton"  role="tab" @if(session()->has("intern")) disabled @endif>
                                                    Formulaires Interne
                                                </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form method="POST" action="/setInt2">
                                                    @csrf
                                                <button type="submit" style="background-color:transparent"  class="nav-link @if(session()->has('pdf')) active @endif fw-semibold" data-bs-toggle="tab" id="fileButton"  role="tab" @if(session()->has("pdf")) disabled @endif>
                                                    Fichier PDF
                                                </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                <div id="items-list" class="table-responsive table-card mt-3 mb-1">
                                    @include("pages.datapartial")
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
            <div class="modal fade" id="showModalComm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel">Renvoi Formulaire/Fichier</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" method="POST" action="{{route('renvoi')}}" autocomplete="off">
                            @csrf
                            <input id="id" name="id" hidden>
                            <input id="type" name="type" hidden>
                            <div class="modal-body">
                                <div>
                                <label for="id-field" class="form-label">Name</label>
                                <input type="text" id="formfileName" name="formName" class="form-control" readonly>
                                </div>
                                <br>
                                <div>
                                    <label for="id-field" class="form-label">Acteur</label>
                                    <input type="text" id="acteurName" name="acteurName" class="form-control" readonly>
                                    </div>
                                <br>
                                <div>
                                    <label for="id-field" class="form-label">Commentaire</label>
                                    <textarea name="commentaire" maxlength="255" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-success" id="add-btn">Renvoyer</button>
                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                                </div>
                                <div>
                                    <label for="status-field" class="form-label">Année</label>
                                    <select class="form-control" data-trigger name="status-field" id="status-field" required>
                                        <option value="">2023</option>
                                        <option value="Active">2022</option>
                                        <option value="Block">2021</option>
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="status-field" class="form-label">Périodicité</label>
                                    <select class="form-control" data-trigger name="status-field" id="status-field" required>
                                        <option value="">T1</option>
                                        <option value="Active">T2</option>
                                        <option value="Block">T3</option>
                                        <option value="Block">T4</option>
                                    </select>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-success" id="add-btn">Générer</button>
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
                        <form class="tablelist-form" >
                            <div class="modal-body">
                                <div>
                                    <label for="dom" class="form-label">Acteur</label>
                                    <select class="form-control" id="acteur2" disabled >
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="dom" class="form-label">Formulaire</label>
                                    <select id="formsSelect3" class="form-control" disabled>
                                    </select>
                                </div>
                                <br>
                                <label for="dom" class="form-label">Pourcentage</label>
                                <div class="d-flex form-inline">
                                        <select class="form-control w-auto" id="operation2" name="operation" disabled>
                                            <option value=""></option>
                                            <option value="+">+</option>
                                            <option value="-">-</option>
                                        </select>

                                        <input type="number" class="form-control flex-grow-1" id="pourcentage2" name="pourcentage" disabled placeholder="La formule est inexistante ">
                                            <button class="btn btn-secondary" type="button" disabled>%</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal modal-xl" id="formRender" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <div>
                                    <h6 id="nomform" class="fs-16 mb-2 flex-grow-1 text-truncate task-title text-primary  fw-bold">
                                    </h6>
                                </div>
                                <div>
                                    <h6 id="createdAt" class="fw-bold">
                                    </h6>
                                </div>
                                <div>
                                    <h6 id="updatedAt" class="fw-bold">
                                    </h6>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                        </div>
                        <div class="form">

                            <form class="modal-body" id="formdatamodal" enctype="multipart/form-data" method="POST" action="">
                            </form>

                            <div id="dataButton" class="m-3 d-flex justify-content-end">
                                <button id="showButton" class="btn btn-primary">Json du Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
@endsection

@section('script')
   <script>
        handleClickk=function(form)
            {
                $("#nomform").text(form.form.name);
                if(form.created_at)
            {
                const date=new Date(form.created_at)
                const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                };
                const formattedDate = date.toLocaleDateString(undefined, options);
                $("#createdAt").text("Créé le : "+formattedDate)

            }
    if(form.updated_at)
    {
                const date=new Date(form.updated_at)
                const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                };
                const formattedDate = date.toLocaleDateString(undefined, options);
                $("#updatedAt").text("Modifié le : "+formattedDate)
            }
            event.preventDefault();
                formData=form.form.formJson;
                dataJson=JSON.parse(form.formJson);
                var formioElement =  document.getElementById('formdatamodal');
                var formulaires=Formio.createForm(formioElement,JSON.parse(formData),{
            readOnly: true,
            highlightErrors : true,
            } ).then(function(forme){forme.submission={data:dataJson.data}});
            const jsonString=JSON.stringify(dataJson,null,2)
            $("#showButton").on("click",function(){
                Swal.fire({
                    title: "JSON Data",
                    html: `<pre style="text-align: left">${jsonString}</pre>`,
                    confirmButtonText: "Close",
                    showCancelButton:true,
                    cancelButtonText:"Copier",
                    didOpen: () => {
                        const confirmButton = document.querySelector(".swal2-confirm");
                        const closeButton = document.querySelector(".swal2-cancel");
                        console.log(closeButton);
                        confirmButton.addEventListener("click", () => {
                        Swal.close();
                        });
                        closeButton.addEventListener("click", () => {
                            console.log(jsonString);
                            navigator.clipboard.writeText(jsonString);
                            Swal.fire({
                             title: "Copier",
                             icon:"success",
                             text:"Data Json copié avec succès !",
                             confirmButtonText:"Fermer",
                            })
                        });

                            }})

                    });
            }


        $(document).ready(function() {
            const schema =new Choices(document.getElementById("selectActeur"), {
                shouldSort: false,
                classNames: {
                containerInner: 'choices__inner m-3',
                input: 'form-control',
                item: 'choices__item sa', // Add a custom class here
                highlightedState: 'text-info',
                selectedState: 'text-primary',
                },
            });
            const schema2 =new Choices(document.getElementById("acteur2"), {
                shouldSort: false,
                classNames: {
                containerInner: 'choices__inner',
                input: 'form-control',
                item: 'choices__item sa', // Add a custom class here
                highlightedState: 'text-info',
                selectedState: 'text-primary',
                },
            });
            var urlParams = new URLSearchParams(window.location.search);
            var query = urlParams.get('acteur') || '';
            var name = urlParams.get('name') || '' ;
            var periodicite = urlParams.get('periodicite') || '' ;
            var annee = urlParams.get('annee') || '' ;
            var fiche=urlParams.get("fiche")||'';
            schema.setValue([query]);
            schema.setChoiceByValue(query);
            $("#searchForm").val(name);
            $("#periodicite").val(periodicite);
            $("#annee").val(annee);
            $('#selectFiches').val(fiche);
             function updateActeur() {
                let name =  $('#searchForm').val();
                var acteur=$("#selectActeur").val();
                let periodicite=$("#periodicite").val();
                let annee=$("#annee").val();
                let fiche=$('#selectFiches').val();
                $.ajax({
                    url: "/data",
                    method: 'GET',
                    data:{
                        name:name,
                        acteur:acteur,
                        periodicite:periodicite,
                        annee:annee,
                        fiche:fiche
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
                history.replaceState(null, null, "?acteur="+ encodeURIComponent(acteur)+"&name="+encodeURIComponent(name)+"&annee="+encodeURIComponent(annee)+"&periodicite="+encodeURIComponent(periodicite)+"&fiche="+encodeURIComponent(fiche));
            };
            $("#periodicite").on("change",function(){
                 updateActeur();
                });
            $("#annee").on("change",function(){
                updateActeur();
                });
            $("#selectActeur").on("change",function(){
                updateActeur();
                });
                $("#selectFiches").on("change",function(){
                updateActeur();
                });
            $("#searchForm").on("keyup",function(){
                updateActeur();
                });
            $("#clearall").on("click",function(){
                schema.setValue([""]);
            schema.setChoiceByValue("");
            $("#searchForm").val("");
            $("#selectFiches").val("");
            $("#annee").val("");
            $("#periodicite").val("");
            updateActeur();
            })
        })
        renvoiFunction=function(form,type){
            $("#id").val(form.id);
            $("#type").val(type);
            $("#formfileName").val(form.form.name);
            $("#acteurName").val(form.name);
            $("#periodName").val(form.periodicity+"  - "+form.year)
        }
        download=function(file,type)
        {   console.log(file)
             $.ajax({
                url:"/file/download",
                type:'GET',
                data:{
                    id:file,
                    type:type,
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
        $('#acteur2').change(function() {
                var actorId = $("#acteur2").val();
                $.ajax({
                    url: '/getEveryForm/' + actorId,
                    type: 'GET',
                    success: function(response) {
                        $('#formsSelect2').html(response).prop('disabled', false);
                        $('#formsSelect2').html(response).prop('required',true);
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
        $('#formsSelect2').change(function() {
                var actorId = $("#acteur2").val();
                $.ajax({
                    url: '/getPeriodicite2',
                    type: 'GET',
                    data:{
                        form_id:$('#formsSelect2').val(),
                    },
                        success: function(response) {
                        console.log(response)
                        $('#periodicite2').html(response).prop('disabled', false);
                        $('#periodicite2').html(response).prop('required',true);
                    },
                    error:function(xhr,statu,error)
                    {
                        console.log(xhr.responseText)
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
   </script>
@endsection
