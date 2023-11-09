
@extends("layouts.app")
@section("head")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" crossorigin="anonymous">

@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div id="errorsMessage" class="alert alert-danger text-center" style="display: none">

        </div>
                <form id="createFormForm" action="/formulaire/create" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="row d-flex justify-content-around">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Nom de formulaire</label>
                                    <input id="name" type="text" class="form-control" name="name" maxlength="255" value="{{$form->name}}_copie" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="section" class="col-form-label">Section</label>
                                            <input id="section" type="text" class="form-control" maxlength="255" value="{{$form->section}}" name="section" required autofocus>
                                        </div>
                            </div>

                            <input id="id" name="id" value="{{$fiche->id}}" hidden>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fiche" class="col-form-label">Périodicité </label>

                                    <select name="periodicite" id="periodicite" class="form-control" required="required">
                                        <option value="" >Sélectionnez la périodicité </option>

                                            <option value="mensuelle"  @if($form->periodicite==="mensuelle")selected @endif>Mensuelle</option>
                                            <option value="trimestrielle" @if($form->periodicite==="trimestrielle")selected @endif>Trimestrielle</option>
                                            <option value="semestrielle" @if($form->periodicite==="semestrielle")selected @endif>Semestrielle</option>
                                            <option value="annuelle" @if($form->periodicite==="annuelle")selected @endif>Annuelle</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="visibility" class="col-form-label">Visibilité </label>

                                    <select name="visibility" id="visibility" class="form-control" required="required">
                                        <option value="">Sélectionnez la visibilité </option>
                                            <option value="PUBLIQUE" @if($form->visibility==="PUBLIQUE")selected @endif>Publique</option>
                                            <option value="PRIVE"  @if($form->visibility==="PRIVE")selected @endif>Privée</option>
                                    </select>
                                </div>
                            </div>

                            <!-- liste des fiches -->
                            <input name="formJson" id="formJson" hidden>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fiche" class="col-form-label">Fiche </label>

                                    <input name="fiche" id="fiche" class="form-control" readonly disabled="true" value="{{$fiche->name}}">

                                </div>
                            </div>
                        </div>

                        <!-- <div id="fb-editor" class="fb-editor"></div> -->

                        <div class="row">
                            <div id="fb-editor"></div>
                                <div class="card-footer text-right" id="fb-editor-footer">
                                    <button id="saveForm"  class="btn btn-danger">Ajouter le formulaire</button>
                                </div>
                        </div>

                    </div>



                </form>

    </div>
</div>

                <!-- <select id="dropdownId" class="form-select" aria-label="Default select example"> </select>-->

<script>
var form;
var formTemplateToSave; // this is the serialized form template to save

window.onload = function() {
    var form={!! json_encode($form) !!};
var builder = Formio.builder(document.getElementById('fb-editor'),JSON.parse(form.formJson), {
    display:"form",noDefaultSubmitButton: true, builder: {
        advanced:false,
        layout:false,
        premium:false
}
}).then((_form) => {
        form = _form;

        form.on('change', function(payload) {
            formTemplateToSave = JSON.stringify(form.schema, null, 4);
            formRender= JSON.stringify(form.schema, null,4);

        });

        formTemplateToSave = JSON.stringify(form.schema, null, 4);
        formTemplateToSave = form.schema;
        $('#saveForm').click(function(e){
            $("#saveForm").attr("disabled",true);
            e.preventDefault();
                $("#errorsMessage").attr("style", "display: none");
                var name = $("input[name='name']").val();
                var section = $("input[name='section']").val();
                var token = $("input[name='_token']").val();
                var visibility = $("select[name='visibility']").val();
                var id = $("input[name='id']").val();
                var periodicite = $("select[name='periodicite']").val();
                var formJson = formTemplateToSave;
                if(formJson.components!==undefined&&Object.keys(formJson.components).length>0)
                    formJson=JSON.stringify(form.schema, null, 4);
                $("#formJson").val(formJson);
                if(name===""||visibility===""||periodicite===""||(formJson.components!==undefined&&Object.keys(formJson.components).length===0))
                    {$("#errorsMessage").removeAttr("style");
                    $("#saveForm").attr("disabled",false);
                }
                if(name==="")
                    $("#errorsMessage").text("Nom est obligatoire !");
                else if(visibility==="")
                    $("#errorsMessage").text("Visibilité est obligatoire !");
                else if(periodicite==="")
                    $("#errorsMessage").text("Périodicité est obligatoire !");
                else if(formJson.components!==undefined&&  Object.keys(formJson.components).length===0)
                    $("#errorsMessage").text("Form est vide !");
                else
                    $("#createFormForm").submit();
        })

    });

};


</script>
@endsection
