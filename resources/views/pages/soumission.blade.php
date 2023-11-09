@extends("layouts.app")
@section("head")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.js"></script>
@endsection
@section('content')
<style>
    .custom-border {
    border-left: 5px solid ;
    }
    .sa{
        margin-left: 10px
    }
    .choices__list--dropdown,
.choices__list[aria-expanded] {
  word-break: break-word;
  width: max-content;
}
</style>
    <div class="page-content" id="body" style="display: none">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Soumissions </h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Soumissions</a></li>
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
                    <a href="" class="link-secondary text-decoration-underline" id="clearall"> Effacer tout</a>
                </div>
            </div>
            <div class="d-flex">
                <select class="choices-single w-100" name="acteur" id="selectActeur" required >
                    <option value="">Sélectionnez un opérateur</option>
                    @foreach ($acteurs as $acteur )
                        <option class="mx-2" data-tokens="{{$acteur->nom_acteur}}" value="{{$acteur->id}}">{{ strtoupper($acteur->nom_acteur) }}</option>
                    @endforeach
                </select>


            </div>


                <div class="">
                    <div>
                        <div class="card">

                            <div class="card-body">
                                <div class="row align-items-center">


                                <div id="items-list" class="table-responsive table-card mt-3 mb-1">
                                    @include("pages.soumissionpartial")
                                </div>
                                <div class="text-center" id="templateSpinner" style="display:none">
                                    <div class="spinner-border text-primary" id="spinner" style="display:none">

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
            </div>
            <!-- end row -->
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
                            @csrf

                        </form>

                        <div id="submissionSuccess" class="alert-success alert text-center d-none mx-2 my-2"> </div>
                        <div class="my-4 mx-4 d-flex justify-content-end" id="classfooter">
                            <button id="submit_btn" class="btn btn-primary confirm-form mx-1 " data-form="submitForm" >
                                <i class="fa fa-submit"></i> Envoyer
                            </button>
                            <button id="save_btn" class="btn btn-success confirm-form mx-1" data-form="submitForm" >
                                <i class="fa fa-submit"></i> Enregistrer brouillon
                            </button>
                            <button id="reset_btn" class="btn btn-danger confirm-form mx-1 " data-form="submitForm" >
                                <i class="fa fa-submit"></i> Vider
                            </button>
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
        $(document).ready(function() {
           const schema=new Choices("#selectActeur", {
                shouldSort: false,
                position: 'bottom',
                classNames: {
                containerInner: 'choices__inner mt-2 mb-4',
                input: 'form-control',
                item: 'choices__item sa', // Add a custom class here
                highlightedState: 'text-info',
                selectedState: 'text-primary',
                },
            });
            var urlParams = new URLSearchParams(window.location.search);
            var query = urlParams.get('acteur') || '';
            schema.setValue([query]);
            schema.setChoiceByValue(query);
            $("#body").removeAttr("style");
            const template=$('#templateSpinner').clone();
                    template.removeAttr("style");
                    template.find('#spinner').removeAttr("style");
             function updateActeur() {
                    $('#items-list').html(template);
                var acteur=$("#selectActeur").val();
                $.ajax({
                    url: "/soumissions",
                    method: 'GET',
                    data:{
                        acteur:acteur,

                    },
                    success: function(data) {
                        $('#items-list').html(data);
                    },
                    error:function(xhr,staut,error){
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
                history.replaceState(null, null, "?acteur="+ encodeURIComponent(acteur));
            };
            $("#periodicite").on("change",function(){
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
            $("#periodicite").val("");
            $("#selectFiches").val("");
            updateActeur();
            })
        })

   </script>
@endsection
