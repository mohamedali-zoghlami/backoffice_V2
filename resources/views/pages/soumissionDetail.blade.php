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
</style>
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">@if(isset($acteurName))Soumissions > <a href="/soumissions?acteur={{$acteur}}" class="primary-link">{{$acteurName}}</a>@else Soumissions Internes @endif</h4>

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
            <div class="row">
                <div class="col-3">

                </div>
                <div class="col-2"></div>
                <div class="col-2">
                    <select id="annee" class="form-control m-3">
                            <option value=""> Année</option>
                             @for($i=date('Y');$i>=2014;$i--)
                                <option value="{{$i}}">{{$i}}</option>
                             @endfor
                    </select>
                    </div>
                    <div class="col-2">
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
                <div class="col">
                    <div class="d-flex justify-content-end m-3">
                        <div class="search-box">
                            <input type="text" id="searchDomaine" class="form-control search" placeholder="Rechercher...">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                </div>
            </div>


                <div class="">

                                <div class="row align-items-center">


                                <div id="items-list" >
                                    @include("pages.soumissionDetailpartial")
                                </div>


                        <!-- end card -->
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
            <div class="modal modal-xl" id="formRender1" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                                <div>
                                    <div>
                                        <h6 id="nomform1" class="fs-16 mb-2 flex-grow-1 text-truncate task-title text-primary  fw-bold">
                                        </h6>
                                    </div>
                                    <div>
                                        <h6 id="createdAt1" class="fw-bold">
                                        </h6>
                                    </div>
                                    <div>
                                        <h6 id="updatedAt1" class="fw-bold">
                                        </h6>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" id="closeModalBtn4" data-dismiss="modal" aria-label="Close">
                                </button>
                             </div>
                        <div class="form">
                            <div id="alertMessage" class="alert-warning alert text-center d-none mx-4 my-2"> </div>
                        <form class="modal-body" id="formdatamodal1" enctype="multipart/form-data" method="POST" action="">
                            @csrf

                        </form>




                        <div id="submissionSuccess" class="alert-success alert text-center d-none mx-4 my-2"> </div>
                        <div id="errorMessages" ></div>
                        <div class=" mx-4 my-4 d-flex justify-content-end " id="">
                            <button id="submit_btn1" class="btn btn-primary confirm-form mx-1 " data-form="submitForm" >
                                <i class="fa fa-submit"></i> Envoyer
                            </button>
                            <button id="reset_btn1" class="btn btn-danger confirm-form mx-1 " data-form="submitForm" >
                                <i class="fa fa-submit"></i> Vider
                            </button>
                            <button id="closeModalBtn3" class="btn btn-dark confirm-form mx-1 " data-dismiss="modal" aria-label="Close" >
                                <i class="fa fa-submit"></i> Quitter
                            </button>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="modal modal-xl" id="formRender" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
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
                                <button type="button" class="btn-close" id="closeModalBtn" data-dismiss="modal" aria-label="Close">
                                </button>
                             </div>
                        <div class="form">
                            <div id="alertMessage" class="alert-warning alert text-center d-none mx-4 my-2"> </div>
                        <form class="modal-body" id="formdatamodal" enctype="multipart/form-data" method="POST" action="">
                            @csrf

                        </form>




                        <div id="submissionSuccess" class="alert-success alert text-center d-none mx-4 my-2"> </div>
                        <div id="errorMessages" ></div>
                        <div class=" mx-4 my-4 d-flex justify-content-end " id="">
                            <button id="submit_btn" class="btn btn-primary confirm-form mx-1 " data-form="submitForm" >
                                <i class="fa fa-submit"></i> Envoyer
                            </button>
                            <button id="save_btn" class="btn btn-success confirm-form mx-1" data-form="submitForm" >
                                <i class="fa fa-submit"></i> Enregistrer brouillon
                            </button>
                            <button id="reset_btn" class="btn btn-danger confirm-form mx-1 " data-form="submitForm" >
                                <i class="fa fa-submit"></i> Vider
                            </button>
                            <button id="closeModalBtn2" class="btn btn-dark confirm-form mx-1 " data-dismiss="modal" aria-label="Close" >
                                <i class="fa fa-submit"></i> Quitter
                            </button>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="showModalComm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel">Renvoi Formulaire/Fichier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                    </div>
                    <form class="tablelist-form" method="POST" action="{{route('renvoi')}}" id="renvoiForm" autocomplete="off">
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
                                <input type="text" id="acteurName" name="acteurName" class="form-control" @if(isset($acteurName))value="{{$acteurName}}"@endif readonly>
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
                                <button type="submit" class="btn btn-success" id="renv-btn">Renvoyer</button>
                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
        <div id="templateError" style="display:none" class="alert-danger alert text-center mx-4 my-2"></div>
        <div class="modal fade" id="saisieAuto" hidden>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                    </div>
                    <form class="tablelist-form" id="formSaisieAuto" action="{{route('formulaire.saisie')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div>
                                <label for="dom" class="form-label">Acteur</label>
                                <input class="form-control" name="acteur" id="acteur2" hidden>

                            </div>
                            <br>
                            <div>
                                <label for="dom" class="form-label">Formulaire</label>
                                <input id="formsSelect2" class="form-control" name="formulaire" hidden>
                            </div>
                            <br>
                            <div>
                                <label for="dom" class="form-label">Année</label>
                                <input id="annee" class="form-control" name="annee" hidden  >

                            </div>
                            <br>
                            <div>
                                <label for="dom" class="form-label">Periodicite</label>
                                <input id="periodicite2" hidden class="form-control" name="periodicite"  >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
   <script>
        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            var query = urlParams.get('type') || 'publique';
            $('#selectType').val(query);
            query=urlParams.get('name') || '';
            $("#searchDomaine").val(query);
            query=urlParams.get('year') || '';
            $("#annee").val(query);
            query=urlParams.get('periodicite') || '';
            $("#periodicite").val(query);
             function updateActeur() {
                var name=$("#searchDomaine").val();
                var year=$("#annee").val();
                var periodicite=$("#periodicite").val();
                $.ajax({
                    url: window.location.href,
                    method: 'GET',
                    data:{
                        name:name,
                        year:year,
                        periodicite:periodicite,
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
                history.replaceState(null, null, "?name="+ encodeURIComponent(name)+"&year="+encodeURIComponent(year)+"&periodicite="+encodeURIComponent(periodicite));
            };
            $("#annee").on("change",function(){
                updateActeur();
                });
                $("#periodicite").on("change",function(){
                updateActeur();
                });
                $("#selectType").on("change",function(){
                updateActeur();
                });
            $("#searchDomaine").on("keyup",function(){
                updateActeur();
                });
            $("#renvoiForm").on("submit",function(){
                $("#renv-btn").attr("disabled",true);
            })
            $("#clearall").on("click",function(){
            $('#selectType').val("publique");
            $("#searchDomaine").val("");
            $("#annee").val("");
            $("#periodicite").val("");
            updateActeur();
            });
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
            const diffVal=function(json,jsonData,lastMonths)
            {      function diff(array1, array2, labels) {
                    result=[]
                    for (let i = 0; i < array2.length; i++) {
                    const item1 = array1[i];
                    const item2 = array2[i];
                    let isDifferent = true;

                    for (const label of labels) {
                        if (item1[label] === item2[label]) {
                        isDifferent = false;
                        result.push(label)
                        }
                    }
                    }
                    return result;
                }
                function hasSubComp(json)
                {
                    json=JSON.parse(json)
                    json=JSON.parse(json)
                    const components = json.components;
                    for (const component of components) {
                    const subComponents = component.components;
                    if (subComponents)
                        return true;
                    else
                        return false;
                }
                }
                function processJson2(json)
                {
                    json=JSON.parse(json)
                    json=JSON.parse(json)
                    const components = json.components;
                    const result = {};
                    for (const component of components) {
                        if(component.difflastval===true)
                            result[component.key]=true
                    }

                    return result;
                }
                function processJson(json)
                {
                    json=JSON.parse(json)
                    json=JSON.parse(json)
                    const components = json.components;
                    const result = {};
                    for (const component of components) {
                    const subComponents = component.components;
                    const key = component.key;
                    let labels=[]
                        if (subComponents) {
                        for (const subComponent of subComponents) {

                            if (subComponent.difflastval === true) {
                            const label = subComponent.key;
                            labels.push(label)
                            }
                        }
                        }
                        else
                        {
                            if(component.evolution===true)
                            labels.push(component.key)
                        }
                        result[key]=labels
                    }
                    return result;

                }
                function transform(json,resultat)
                {
                    json=JSON.parse(json)
                    json=JSON.parse(json)

                    const components = json.components;
                    const result = {};
                    for(const key in resultat)
                    {
                    for (const component of components) {
                    const key2 = component.key;
                        if(key===key2)
                            {result[component.label]=resultat[key];
                            }
                    }

                     }
                     return result;
                    }
                if(lastMonths[0]===null)
                    {
                        var data={};
                    return data;
                    }
                else
                    {
                        const data=JSON.parse(jsonData);
                        const moisPrec=JSON.parse(lastMonths[0].formJson);
                    if(hasSubComp(json))
                    {
                    const resultat=processJson(json)
                    last={};
                        if(Object.keys(resultat).length > 0){
                            for (const key in resultat) {

                                if(moisPrec.data[key]!=undefined)
                            {
                                let tempTest=diff(data.data[key],moisPrec.data[key],resultat[key])
                                if(tempTest.length>0)
                                last[key]=tempTest
                            }
                            }
                            }
                    }
                    else{
                        const resultat=processJson2(json);

                        last={};
                        if(Object.keys(resultat).length > 0){
                            for (const key in resultat) {
                                if(moisPrec.data[key]!=undefined)
                            {
                                if(moisPrec.data[key]===data.data[key])
                                    last[key]=true
                            }
                            }
                            }
                    }
                            return last;
                    }
                }
            evolution=function(json,jsonData,lastMonths){
                        function processJSON(json) {
                            json=JSON.parse(json)
                            json=JSON.parse(json)
                        const components = json.components;
                        const result = {};

                        for (const component of components) {
                            let subComponents = component.components;
                        const key = component.key;
                        let labels=[]
                            if (subComponents===undefined) {
                                if(component.evolution===true)
                                labels.push(component.key)
                            }
                            else
                            for (const subComponent of subComponents) {
                                if (subComponent.evolution === true) {
                                const label = subComponent.key;
                                if(label.length)
                                labels.push(label)
                                }
                            }

                            result[key]=labels
                        }

                        return result;
                        }
                        function hasSubComp(json)
                        {
                            json=JSON.parse(json)
                            json=JSON.parse(json)
                        const components = json.components;

                        for (const component of components) {
                            let subComponents = component.components;
                        const key = component.key;

                            if (subComponents===undefined) {
                                return false
                            }
                            else
                                return true
                            }

                        }

                        function processJson2(json) {
                            json=JSON.parse(json)
                            json=JSON.parse(json)
                        const components = json.components;
                        const result = {};

                        for (const component of components) {
                        const key = component.key;

                                if (component.evolution === true) {
                                result[key]=true
                                }
                            }


                        return result;
                        }

                        function diff(array1, array2,array3,data, labels) {
                        let test = false;
                        for (let i = 0; i < array2.length; i++) {
                            const item1 = array1[i];
                            const item2 = array2[i];
                            const item3=  array3[i];
                            const actual=data[i];
                            let result={}
                            for (const label of labels) {
                            sum=item1[label]+item2[label]+item3[label]
                            min=(sum/3)*0.9
                            max=(sum/3)*1.1
                            if (actual[label]>max || actual[label]<min) {
                                result[labe]={
                                    min:min,
                                    max:max,
                                }
                            }
                            }
                        }
                        return result;
                        }
                        if(lastMonths[0]===null||lastMonths[1]===null||lastMonths[2]===null)
                                return {};

                        const parsedData =JSON.parse(jsonData);
                        let mois1=JSON.parse(lastMonths[0].dataJson);
                        let mois2=JSON.parse(lastMonths[1].dataJson);
                        let mois3=JSON.parse(lastMonths[2].dataJson);
                        let last={}
                        if(hasSubComp(json))
                        {
                        const result = processJSON(json);
                        if(Object.keys(result).length > 0){
                        for (const key in result) {
                            if(mois1.data[key]!=undefined)
                        {
                                let tempTest=diff(mois1.data[key],mois2.data[key],mois3.data[key],parsedData.data[key],result[key])
                                if(tempTest.size>0)
                                    last[key]=true;
                        }
                        }
                        }
                        }
                        else
                        {
                            const result=processJson2(json);

                            if(Object.keys(result).length > 0){
                            for (const key in result) {
                                if(mois1.data[key]!==undefined&&mois2.data[key]!==undefined&&mois3.data[key]!==undefined&&parsedData.data[key]!==undefined)
                            {
                                sum=mois1.data[key]+mois2.data[key]+mois3.data[key]
                                min=(sum/3)*0.9
                                max=(sum/3)*1.1
                                if (parsedData.data[key]>max || parsedData.data[key]<min) {
                                    last[key]={
                                        min:min,
                                        max:max,
                                    }
                                }
                            }
                            }
                        }}
                        return last;

                    }
    handleClickk=function(form)
    {
        console.log(form)
     event.preventDefault();
     $('#submissionSuccess').addClass('d-none');
     $('#alertMessage').addClass('d-none');
     $("#formRender").modal("show");

        formData=JSON.parse(form.formJson);
        if(form.dataJson=== undefined)
            dataPrec={};
        else
           dataPrec=JSON.parse(form.dataJson);
    if(form.message)
        {
            $('#alertMessage').removeClass('d-none');
            $("#alertMessage").text(form.message);
        }
    var classfooter=document.getElementById("classfooter");
    var changement;
    if((form.type!==undefined&&form.type==="final"))
    {
            $("#submit_btn").attr("disabled", true);
            $("#save_btn").attr("disabled", true);
            $("#reset_btn").attr("disabled", true);
            $("#classfooter").addClass("d-none")
             changement=false;
    }
    else
    {
            $("#submit_btn").attr("disabled", false);
            $("#save_btn").attr("disabled", false);
            $("#reset_btn").attr("disabled", false);
            $("#classfooter").removeClass("d-none")
              changement=true
    }
    if(form.type==="refaire")
            {
                $("#save_btn").attr("hidden", true);
            }
        else
            {
                $("#save_btn").attr("hidden", false);
            }
    $('#nomform').text(form.name);
    if(form.type==="final"){
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
        }
    let sub;

    var formioElement =  document.getElementById('formdatamodal');

    var formulaires=Formio.createForm(formioElement,JSON.parse(form.formJson),{
            readOnly:  form.type==="final",
            highlightErrors : true,
            } ).then(function(forme){forme.submission={data:dataPrec.data};
            initialData = JSON.stringify(forme.submission);
            forme.on('change', function() {
                    sub = JSON.stringify(forme.submission);
                });
                $('#closeModalBtn').off('click').on("click", function () {
                    if (changement) {
                        const result = Swal.fire({
                            title: "Etes-vous sûr de vouloir quitter le formulaire sans l'enregistrer ?",
                            html: 'Toutes les données que vous avez saisies seront perdues !<br>Si vous souhaitez conserver vos modifications, veuillez enregistrer le formulaire avant de quitter.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Oui',
                            cancelButtonText: 'Non'
                        }).then((result) => {

                        if (result.isConfirmed) {
                            $('#formRender').modal('hide');
                        }})
                    } else {
                        // Close the modal immediately if there are no changes
                        $('#formRender').modal('hide');
                    }
                });
                $('#closeModalBtn2').off('click').on("click", function () {
                    if (changement) {
                        const result = Swal.fire({
                            title: "Etes-vous sûr de vouloir quitter le formulaire sans l'enregistrer ?",
                            html: 'Toutes les données que vous avez saisies seront perdues !<br>Si vous souhaitez conserver vos modifications, veuillez enregistrer le formulaire avant de quitter.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Oui',
                            cancelButtonText: 'Non'
                        }).then((result) => {

                        if (result.isConfirmed) {
                            $('#formRender').modal('hide');
                        }})
                    } else {
                        // Close the modal immediately if there are no changes
                        $('#formRender').modal('hide');
                    }
                });
            $("#submit_btn").click( function(e){

                $("#errorMessages").empty();

                        $("#submit_btn").attr("disabled", true);
                        $("#save_btn").attr("disabled", true);
                        $("#reset_btn").attr("disabled", true);

                        $("#closeModalBtn2").attr("disabled",true);
						e.preventDefault();

              			var dataJson = sub;
						var data={dataJson:dataJson,
									form_id:form.id,
                                    acteur:@json($acteur),
									type:"final",
                                    type_form:$('#selectType').val(),
									formHistoric_id:0,
                                    year:form.year,
                                    periodicite:form.date_to,
									historique:"L",
									_token:"{{csrf_token()}}"};

                           const validation= forme.checkValidity(forme.submission.data,(isValid)=>
                            {
                                return isValid;
                                })
                            if(validation)
                            {
                            $.ajax(
                                {
                                    url:"/getForVerification",
                                    type:"GET",
                                    data:
                                    {   acteur:@json($acteur),
                                        form_id:form.id,
                                        periodicite:form.periodicite
                                    },
                                    success: async function(response)
                                    {   console.log(response.lastMonth)
                                        const diffval=diffVal(JSON.stringify(form.formJson),dataJson,response.lastMonth)
                                        const evo=evolution(JSON.stringify(form.formJson),dataJson,response.lastMonth)
                                        if(Object.keys(diffval).length===0 && Object.keys(evo).length==0)
                                            {   const result= await Swal.fire({
                                                icon: 'warning',
                                                title: 'Êtes vous sûr ?',
                                                text: " Est-ce que vous confirmez l'envoi de vos données ? ",
                                                showCancelButton: true,
                                                confirmButtonText: 'Oui',
                                                cancelButtonText: 'Non',
                                                allowOutsideClick: false,
                                                });
                                        if(result.isDismissed)
                                                return;
                                                $.ajax({
                                                url:"{{route('submitForm')}}",
                                                type: 'POST',
                                                data:data,
                                                    success: function(response){
                                                        if(response.final){
                                                            Swal.fire({
                                                            icon: 'success',
                                                            title: 'Success',
                                                            text: "Soumission faite avec succès !",
                                                            confirmButtonText: 'OK'
                                                            }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                location.reload();
                                                                }
                                                           }).then(() => {
                                                            location.reload();
                                                        });
                                                        }
                                                        else if(response.error)
                                                        {
                                                            console.log(response)
                                                            Swal.fire({
                                                            icon: 'error',
                                                            title: 'Erreur',
                                                            text:   response.error,
                                                            confirmButtonText: 'OK'
                                                            })
                                                            $("#submit_btn").attr("disabled", false);

                                                        }

                                                    },
                                                    error:function(xhr,status,error)
                                                    {
                                                        $("#submit_btn").attr("disabled", false);
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
                                        else
                                            {
                                                $("#save_btn").attr("disabled", false);
                                                $("#reset_btn").attr("disabled", false);
                                                $("#submit_btn").attr("disabled", false);
                                                $("#closeModalBtn2").attr("disabled",false);
                                                for(const key in diffval)
                                                    {   const value=diffval[key];

                                                        if(value===true)
                                                        {
                                                            var template=$("#templateError").clone();
                                                            template.removeAttr("id").removeAttr("style");
                                                            template.text("Le "+ key+" doit être différent à la soumissions précedante !")
                                                            $("#errorMessages").append(template);
                                                        }
                                                        else
                                                        {
                                                        for(const val of value)
                                                            {
                                                            var template=$("#templateError").clone();
                                                            template.removeAttr("id").removeAttr("style");
                                                            template.text("Le "+val+" dans "+key+" doit être différent à la soumissions précedante !")
                                                            $("#errorMessages").append(template);
                                                            }
                                                        }
                                                    }
                                                for(const key in evo)
                                                    {  let value=evo[key]

                                                            if(evo[key].min!==undefined)
                                                                {
                                                                 var template=$("#templateError").clone();
                                                                template.removeAttr("id").removeAttr("style");
                                                                template.text("Le "+key+" doit être entre "+evo[key].min.toFixed(2)+" et "+evo[key].max.toFixed(2))
                                                                $("#errorMessages").append(template);
                                                                }
                                                            else
                                                            {
                                                                for(const val in value)
                                                                    {
                                                                    var template=$("#templateError").clone();
                                                                    template.removeAttr("id").removeAttr("style");
                                                                    template.text("Le "+val+" doit être entre "+value[val].min.toFixed(2)+" et "+value[val].max.toFixed(2))
                                                                    $("#errorMessages").append(template);
                                                                    }
                                                            }
                                                    }
                                            }
                                    },
                                    error:function(xhr,statu,error)
                                    {
                                        console.log(xhr.responseText);
                                    }
                                }
                            ).fail(function (jqXHR) {
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
                            else
                            {   $("#save_btn").attr("disabled", false);
                                $("#reset_btn").attr("disabled", false);
                                $("#submit_btn").attr("disabled", false);
                                $("#closeModalBtn2").attr("disabled",false);
                            }

				});
                $("#save_btn").click(function(e){
                        $("#save_btn").attr("disabled", true);
                        $("#errorMessages").empty();
						e.preventDefault();
						var token = $("input[name='_token']").val();
              			var dataJson = sub;
                        console.log(sub)
						  	var data={dataJson:dataJson,
									form_id:form.id,
									type:"draft",
									formHistoric_id:0,
                                    acteur:@json($acteur),
                                    year:form.year,
                                    periodicite:form.date_to,
                                    type_form:$('#selectType').val(),
									historique:"L",
									_token:"{{csrf_token()}}"};

							console.log(data);
							$.ajax({
							url:"{{route('submitForm')}}",
							type: 'POST',
							data:data,
								success: function(response){
									if(response.draft){
                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Success',
                                                            text: "Enregistrement fait avec succès !",
                                                            confirmButtonText: 'OK'
                                                            }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                location.reload();
                                                                }
                                                           }).then(() => {
                                                            location.reload();
                                                        });
									}
                                    else
                                    {
                                        $("#submit_btn").attr("disabled", false);
                                    }

                                },
                                error:function(xhr,status,error)
                                {
                                    $("#submit_btn").attr("disabled", false);
                                    $("#save_btn").attr("disabled", false);
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
				})
                $("#reset_btn").click(function(e)
            {
                e.preventDefault();
                console.log(dataPrec)
                forme.setValue({});
            })
            forme.on('error', (errors) => {
            // console.log('Validation errors:', errors);
            });
        });



    }
    handleClickk1=function(form)
    {   $("#formRender").modal("show");
        let changement=false
        if(form.type==="final"){
        $("#submit_btn").attr("disabled", true);
       $("#save_btn").attr("disabled", true);
        $("#reset_btn").attr("disabled", true);
        }
        else
         {  changement=true;
            $("#submit_btn").attr("disabled", false);
       $("#save_btn").attr("disabled", false);
        $("#reset_btn").attr("disabled", false);
         }

     event.preventDefault();
     $('#submissionSuccess').addClass('d-none');
        formData=JSON.parse(form.formJson);
        if(form.dataJson=== undefined)
            dataPrec={};
        else
           dataPrec=JSON.parse(form.dataJson);

    $('#nomform').text(form.name);
    var sub;
    var subJSON;
    var formioElement =  document.getElementById('formdatamodal');

    var formulaires=Formio.createForm(formioElement,JSON.parse(form.formJson),{
        readOnly:  form.type==="final",
        highlightErrors : true,
            } ).then(function(forme){forme.submission={data:dataPrec.data};

            forme.on('change', function() {
                       sub = JSON.stringify(forme.submission);
                });
                $('#closeModalBtn').off('click').on("click", function () {
                    if (changement) {
                        const result = Swal.fire({
                            title: "Etes-vous sûr de vouloir quitter le formulaire sans l'enregistrer ?",
                            html: 'Toutes les données que vous avez saisies seront perdues !<br>Si vous souhaitez conserver vos modifications, veuillez enregistrer le formulaire avant de quitter.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Oui',
                            cancelButtonText: 'Non'
                        }).then((result) => {

                        if (result.isConfirmed) {
                            $('#formRender').modal('hide');
                        }})
                    } else {
                        // Close the modal immediately if there are no changes
                        $('#formRender').modal('hide');
                    }
                });
                $('#closeModalBtn2').off('click').on("click", function () {
                    if (changement) {
                        const result = Swal.fire({
                            title: "Etes-vous sûr de vouloir quitter le formulaire sans l'enregistrer ?",
                            html: 'Toutes les données que vous avez saisies seront perdues !<br>Si vous souhaitez conserver vos modifications, veuillez enregistrer le formulaire avant de quitter.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Oui',
                            cancelButtonText: 'Non'
                        }).then((result) => {

                        if (result.isConfirmed) {
                            $('#formRender').modal('hide');
                        }})
                    } else {
                        // Close the modal immediately if there are no changes
                        $('#formRender').modal('hide');
                    }
                });
            $("#submit_btn").click(async function(e){
                const result= Swal.fire({
                        icon: 'warning',
                        title: 'Êtes vous sûr ?',
                        text: " Est-ce que vous confirmez l'envoi de vos données ? ",
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non',
                        allowOutsideClick: false,
                        });
                        $("#submit_btn").attr("disabled", true);
                        $("#save_btn").attr("disabled", true);
                        $("#reset_btn").attr("disabled", true);
                        $("#errorMessages").empty();
						e.preventDefault();
                        if(result.isDismissed)
                            return;
              			var dataJson = sub;
						var data={dataJson:dataJson,
									form_id:form.id,
                                    acteur:@json($acteur),
									type:"final",
									formHistoric_id:0,
                                    periodicite:form.date_to,
									historique:"L",
                                    year:form.year,
									_token:"{{csrf_token()}}"};

                           const validation= forme.checkValidity(forme.submission.data,(isValid)=>
                            {
                                return isValid;
                                })
                            if(validation)
                            {
                                var headers = {
                                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                                    'Content-Type': 'application/json'
                                };


                                $.ajax({
                                url: '/soumissionCU',
                                method: 'POST',
                                headers:headers,
                                data: JSON.stringify(data),
                                success: function(response) {
                                    Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: "Soumission faite avec succès !",
                                    confirmButtonText: 'OK'
                                     }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Redirect to the previous page
                                        window.location.href = response.redirect_url;
                                        }
                                    }).then(() => {
                                        // Refresh the page when the Swal modal is closed
                                        location.reload();
                                    });
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
                            }
                            else
                            {
                                $("#submit_btn").attr("disabled", false);
                                $("#save_btn").attr("disabled", false);
                                $("#reset_btn").attr("disabled", false);
                            }

				});
                $("#save_btn").click(function(e){
                    $('#submissionSuccess').addClass('d-none');
                    e.preventDefault();
              			var dataJson = sub;
						var data={dataJson:dataJson,
									form_id:form.id,
                                    acteur:@json($acteur),
									type:"draft",
									formHistoric_id:0,
									historique:"L",
                                    year:form.year,
                                    periodicite:form.date_to,
									_token:"{{csrf_token()}}"};


                                var headers = {
                                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                                    'Content-Type': 'application/json'
                                };


                                $.ajax({
                                url: '/soumissionCU',
                                method: 'POST',
                                headers:headers,
                                data: JSON.stringify(data),
                                success: function(response) {
                                    Swal.fire({
                                                            icon: 'success',
                                                            title: 'Success',
                                                            text: "Enregistrement fait avec succès !",
                                                            confirmButtonText: 'OK'
                                                            }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                location.reload();
                                                                }
                                                           }).then(() => {
                                                            location.reload();
                                                        });
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
                $("#reset_btn").click(function(e)
            {
                e.preventDefault();
                forme.setValue({});
            })
            forme.on('error', (errors) => {
            // console.log('Validation errors:', errors);
            });
        });

    }
    handleClickk2=function(form,type)
    {
     event.preventDefault();
     $('#submissionSuccess').addClass('d-none');
    formData=JSON.parse(form.formJson);
        if(form.dataJson=== undefined)
            dataPrec={};
        else
           dataPrec=JSON.parse(form.dataJson);

    $('#nomform1').text(form.name);
    var sub;
    var subJSON;
    var formioElement =  document.getElementById('formdatamodal1');

    var formulaires=Formio.createForm(formioElement,JSON.parse(form.formJson),{
        highlightErrors : true,
            } ).then(function(forme){forme.submission={data:dataPrec.data};

            forme.on('change', function() {
                       sub = JSON.stringify(forme.submission);
                });
                $('#closeModalBtn4').off('click').on("click", function () {

                        const result = Swal.fire({
                            title: "Etes-vous sûr de vouloir quitter le formulaire sans l'enregistrer ?",
                            html: 'Toutes les données que vous avez saisies seront perdues !<br>Si vous souhaitez conserver vos modifications, veuillez enregistrer le formulaire avant de quitter.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Oui',
                            cancelButtonText: 'Non'
                        }).then((result) => {

                        if (result.isConfirmed) {
                            $('#formRender').modal('hide');
                        }})
                });
                $('#closeModalBtn3').off('click').on("click", function () {
                        const result = Swal.fire({
                            title: "Etes-vous sûr de vouloir quitter le formulaire sans l'enregistrer ?",
                            html: 'Toutes les données que vous avez saisies seront perdues !<br>Si vous souhaitez conserver vos modifications, veuillez enregistrer le formulaire avant de quitter.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Oui',
                            cancelButtonText: 'Non'
                        }).then((result) => {

                        if (result.isConfirmed) {
                            $('#formRender').modal('hide');
                        }})
                });
            $("#submit_btn1").click(async function(e){
                const result=await Swal.fire({
                        icon: 'warning',
                        title: 'Êtes vous sur ?',
                        text: " Est-ce que vous confirmez l'envoi de vos données ? ",
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non',
                        showCancelButton:true,
                        allowOutsideClick: false,
                        });
                        $("#errorMessages").empty();
						e.preventDefault();
                        if(result.isDismissed)
                            return;
                        $("#submit_btn1").attr("disabled", true);
                        $("#reset_btn1").attr("disabled", true);
              			var dataJson = sub;
                          var data={data:dataJson,
									id:form.sub_id,
									type:type,
									};




                           const validation= forme.checkValidity(forme.submission.data,(isValid)=>
                            {
                                return isValid;
                                })
                            if(validation)
                            {

                                var headers = {
                                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                                    'Content-Type': 'application/json'
                                };


                                $.ajax({
                                url: '/modifySub',
                                method: 'POST',
                                headers:headers,
                                data: JSON.stringify(data),
                                success: function(response) {
                                    Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: "Modiciation faite avec succès !",
                                    confirmButtonText: 'OK'
                                     }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Redirect to the previous page
                                        window.location.href = response.redirect_url;
                                        }
                                    }).then(() => {
                                        // Refresh the page when the Swal modal is closed
                                        location.reload();
                                    });
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
                            }
                            else
                            {
                                $("#submit_btn1").attr("disabled", false);
                                $("#reset_btn1").attr("disabled", false);
                            }

				});

                $("#reset_btn1").click(function(e)
            {
                e.preventDefault();
                forme.setValue({});
            })
            forme.on('error', (errors) => {
            // console.log('Validation errors:', errors);
            });
        });

    }
    modification=async function (form,type) {
        let allowSubmit = true;
        Swal.fire({
            title: "S'authentifier",
            html: `
            <form id="login-form">
                    @csrf
            <input type="email" name="email" class="swal2-input mx-auto" placeholder="Email">
            <input type="password" name="password" class="swal2-input mx-auto" placeholder="Mot de passe">
            </form>`,
            confirmButtonText: 'Vérifier',
            showLoaderOnConfirm: true,
            focusConfirm: false,
            allowOutsideClick: () => {
                return allowSubmit;
            },
            preConfirm: () => {
                return new Promise((resolve) => {
                    var formData = $('#login-form').serialize();
                    $.ajax({
                    url:"/verifySuper",
                    type:"POST",
                    data:formData,
                    success: function(result)
                    {
                        if (result.error)
                            {
                                Swal.showValidationMessage(result.error);
                                allowSubmit = true;
                                resolve(false);
                            }
                        else
                        {
                            resolve();
                            $("#formRender1").modal("show");
                            handleClickk2(form,type);
                        }
                    }
                    })
                })

            }
            })
    }
    reouvrir=async function(form,acteur,type)
    {   const result= await Swal.fire({
                        icon: 'warning',
                        title: 'Réouvrir un '+type,
                        text: " Est-ce que vous confirmez la réouveture de ce "+type+" ? ",
                        showCancelButton:true,
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non',
                        allowOutsideClick: false,
                        });
        if(result.isDismissed)
            return;
        $.ajax({
            url:"/reouvrirForm",
            type:"POST",
            data:
            {acteur:acteur,
                formulaire:form.id,
                type:type,
                annee:form.year,
                periodicite:form.date_to,
                _token:"{{csrf_token()}}"
            },
            success:function(response){
                if(response.success)
                {Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: response.success,
                        confirmButtonText: 'OK'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                            }
                        }).then(() => {
                        location.reload();
                    });}
                else
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: response.error,
                        confirmButtonText: 'OK'
                        })
                }
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
    renvoyer=function(form,type){
        console.log(form)
        $("#id").val(form.sub_id);
        $("#formfileName").val(form.name);
        $("#type").val(type)
    }
    ouvrir=function(form){
        handleClickk(form);
        $("#formRender").modal("show");
    }
    soumissionAutomatique=function(form,acteur)
    {
        $.ajax({
            url:"/formulaire/saisie",
            type:'POST',
            data:
            {acteur:acteur,
                formulaire:form.id,
                _token:"{{csrf_token()}}"
            },
            success: async function(response){
                if(response.error)
                {
                    const result= await Swal.fire({
                        icon: 'warning',
                        title: response.error,
                        text: " Est-ce que vous voulez continuer et remplir ce formulaire manuellement ? ",
                        showCancelButton: true,
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non',
                        allowOutsideClick: false,
                        });
                        if(result.isDismissed)
                            return;
                        else
                        {handleClickk(form)
                            $("#formRender").modal("show");
                        }

                }
                else
                {
                    form.dataJson=response.data;
                    handleClickk(form)
                    $("#formRender").modal("show");
                }
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

})




   </script>
@endsection
