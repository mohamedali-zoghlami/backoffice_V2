
@extends("layouts.app")
@section("head")

@endsection
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
                        <h4 class="mb-sm-0">Dashboards</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active"> Dashboard </li>
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
                <div class="col-4">
                <select class="form-control my-3 mr-1 choices-single w-100" name="acteur" id="selectActeur" required multiple >
                    <option value="">Sélectionnez un opérateur</option>
                    @foreach ($acteurs as $acteur )
                        <option class="mx-2" data-tokens="{{$acteur->nom_acteur}}" value="{{$acteur->id}}">{{ strtoupper($acteur->nom_acteur) }}</option>
                    @endforeach
                </select>
                </div>
                <div class="col-2">
                <select id="selectFiches" class="form-control my-3 mr-1">
                    <option value="">Toutes les fiches</option>
                    @foreach ($fiches as $fiche )
                        <option value="{{$fiche->id}}">{{$fiche->name}}</option>
                    @endforeach
                </select>
                </div>
                <div class="col-3">
                <input class="form-control my-3 mr-1" id="searchForm" placeholder="Entrer le nom du formulaire/fichier...">
                </div>
                <div class="col">
                <select id="annee" class="form-control my-3 mr-1">
                        <option value=""> Année</option>
                         @for($i=date('Y');$i>=2014;$i--)
                            <option value="{{$i}}">{{$i}}</option>
                         @endfor
                </select>
                </div>
                <div class="col">
                <select id="periodicite" class="form-control my-3 mr-1">
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="listjs-table" id="customerList">

                                <div id="items-list" class="table-responsive table-card mt-3 mb-1">
                                    @include("pages.suiviespartial")
                                </div>
                                <div class="text-center" id="templateSpinner" style="display:none">
                                    <div class="spinner-border text-primary" id="spinner" style="display:none">

                                    </div>
                                </div>

                            </div>
                        </div><!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
@endsection
@section("script")
<script src="https://choices-js.github.io/Choices/assets/scripts/choices.min.js" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
           schema= new Choices(document.querySelector(".choices-single"), {
          shouldSort: false,
          removeItemButton: true,
          classNames: {
            containerInner: 'choices__inner my-3 mr-1',
            input: 'form-control',
            item: 'choices__item sa',
            highlightedState: 'text-info',
            selectedState: 'text-primary',
          },
        });
        $('select[multiple]').each(function(){
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
        var urlParams = new URLSearchParams(window.location.search);
            var query = urlParams.get('acteur') || '';
            var name = urlParams.get('name') || '' ;
            var periodicite = urlParams.get('periodicite') || '' ;
            var annee = urlParams.get('annee') || '' ;
            var fiche=urlParams.get("fiche")||'';
            if(query!==null&&query!=='')
                {
                    var operateur=query.split(",");
                schema.setChoiceByValue(operateur);

            }
            $("#searchForm").val(name);
            $("#periodicite").val(periodicite);
            $("#annee").val(annee);
            $('#selectFiches').val(fiche);
            const template=$('#templateSpinner').clone();
                    template.removeAttr("style");
                    template.find('#spinner').removeAttr("style");
             function updateActeur() {
                $('#items-list').html(template);
                let name =  $('#searchForm').val();
                var acteur=$("#selectActeur").val();
                let periodicite=$("#periodicite").val();
                let annee=$("#annee").val();
                let fiche=$('#selectFiches').val();
                console.log(acteur);
                $.ajax({
                    url: "/suivi",
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
        });

    </script>
@endsection
