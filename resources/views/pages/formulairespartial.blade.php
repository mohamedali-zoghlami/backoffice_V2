<table class="table align-middle table-nowrap" id="customerTable">
    <thead class="table-light">
        <tr>
            <th class="sort" data-sort="customer_name">Nom</th>
            <th class="sort" data-sort="customer_name">Périodicité</th>
            <th class="sort" data-sort="email">Visibilité</th>
            <th class="sort" data-sort="action">Action</th>
        </tr>
    </thead>
    <tbody class="list form-check-all" id="formsDisplay"  @if(session()->has("fichier")||session()->has("intern")||session()->has("pdf"))style="display: none"@endif>
    @foreach($forms as $form)
        <tr>
            <td class="customer_name">
            <h6>
                <button type="button" onclick="handleClickk({{json_encode($form)}})" class="text-primary text-decoration-underline fw-bold mb-0 btn p-0 " data-bs-toggle="modal" data-bs-target="#formRender">{{$form->name}}</button>
            </h6>
            </td>
            @php
                if($form->periodicite==="mensuelle")
                    $bg="bg-primary";
                else if($form->periodicite==="trimestrielle")
                    $bg="bg-success";
                else if($form->periodicite==="annuelle")
                    $bg="bg-dark";
                else
                    $bg="bg-danger";
            @endphp
            <td>
                <div class="btn btn-sm {{$bg}} text-white">
                    {{ucfirst($form->periodicite)}}
                </div>
            </td>
            <td class="email">
            <div class="d-flex gap-2">
                {{$form->visibility}}
             </div>
            </td>
            <td>
                <div class="d-flex gap-2">
                    <div>
                        <button class="btn-primary btn-sm btn" onclick="handleClickk({{json_encode($form)}})" data-bs-toggle="modal" data-bs-target="#formRender">Ouvrir</button>
                    </div>
                    <div>
                        <form action="/formulairesCopie" id="copieFormForm" method="POST" hidden>
                            @csrf
                            <input id="idFormCopie" name="id" hidden>
                            <input id="typeFormCopie" name="type" hidden value="formulaire">
                            <input id="fiche_idFormCopie" name="fiche_id" hidden>
                        </form>
                        <button onclick="copieFile({{json_encode($form)}},false)" class="btn-success btn-sm btn">Copier</button>
                    </div>
                    <div class="hstack gap-3 flex-wrap">
                        <form action="/formulairesUpdate" id="updateFormForm" method="post" hidden>
                            @csrf
                            <input id="idFormUpdate" name="id" hidden >
                            <input id="typeFormUpdate" name="type" hidden value="formulaire">
                            <input id="fiche_idFormUpdate" name="fiche_id" hidden>
                        </form>
                        <button onclick="updateFile({{json_encode($form)}},false)"  class="btn-warning btn-sm btn">Modifier</button>
                    </div>

                    <div>
                        <button class="btn-danger btn-sm btn" onclick="deleteForm({{$form->id}},'public')" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Supprimer</button>
                    </div>

                </div>

            </td>
        </tr>
    @endforeach
    </tbody>
    <tbody class="list form-check-all" id="formsDisplay"  @if(session()->has("intern")===false)style="display: none"@endif>
        @foreach($intern as $form)
            <tr>
                <td class="customer_name">
                <h6>
                    <button type="button" onclick="handleClickk({{json_encode($form)}})" class="text-primary text-decoration-underline fw-bold mb-0 btn p-0 " data-bs-toggle="modal" data-bs-target="#formRender">{{$form->name}}</button>
                </h6>
                </td>
                @php
                    if($form->periodicite==="mensuelle")
                        $bg="bg-primary";
                    else if($form->periodicite==="trimestrielle")
                        $bg="bg-success";
                    else if($form->periodicite==="annuelle")
                        $bg="bg-dark";
                    else
                        $bg="bg-danger";
                @endphp
                <td>
                    <div class="btn btn-sm {{$bg}} text-white">
                        {{ucfirst($form->periodicite)}}
                    </div>
                </td>
                <td class="email">
                <div class="d-flex gap-2">
                    {{$form->visibility}}
                 </div>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <div>
                            <button class="btn-primary btn-sm btn" onclick="handleClickk({{json_encode($form)}})" data-bs-toggle="modal" data-bs-target="#formRender">Ouvrir</button>
                        </div>
                        <div>
                            <form action="/formulairesCopie" id="copieFormForm2" method="POST" hidden>
                                @csrf
                                <input id="idInternCopie" name="id" hidden>
                                <input id="typeInternCopie" name="type" hidden value="intern">
                                <input id="fiche_idInternCopie" name="fiche_id" hidden>
                            </form>
                            <button onclick="copieFile({{json_encode($form)}},true)" class="btn-success btn-sm btn">Copier</button>
                        </div>
                        <div class="hstack gap-3 flex-wrap">
                            <form action="/formulairesUpdate" id="updateFormForm2" method="POST" hidden>
                                @csrf
                                <input id="idInternUpdate" name="id" hidden >
                                <input id="typeInternUpdate" name="type" hidden value="intern">
                                <input id="fiche_idInternUpdate" name="fiche_id" hidden >
                            </form>
                            <button onclick="updateFile({{json_encode($form)}},true)"  class="btn-warning btn-sm btn">Modifier</button>
                        </div>

                        <div>
                            <button class="btn-danger btn-sm btn" onclick="deleteForm({{$form->id}},'intern')" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Supprimer</button>
                        </div>

                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tbody class="list form-check-all" id="filesDisplay" @if(session()->has("fichier")===false)style="display: none"@endif>
        @foreach($files as $file)
            <tr>
                <td class="customer_name" >
                <h6 class="text-primary fw-bold mb-0 btn p-0">
                    {{$file->name}}
                </h6>
                </td>
                @php
                    if($file->periodicite==="mensuelle")
                        $bg="bg-primary";
                    else if($file->periodicite==="trimestrielle")
                        $bg="bg-success";
                    else if($file->periodicite==="annuelle")
                        $bg="bg-dark";
                    else
                        $bg="bg-danger";
                @endphp
                <td>
                    <div class="btn btn-sm {{$bg}} text-white">
                        {{ucfirst($file->periodicite)}}
                    </div>
                </td>
                <td class="email">
                <div class="d-flex gap-2">
                    {{$file->visibility}}
                 </div>
                </td>
                <td>
                    <div class="d-flex gap-2">

                        <div class="edit">
                            <button class="btn btn-sm btn-success edit-item-btn" onclick="download({{json_encode($file->id)}})" data-bs-toggle="modal" data-bs-target="#showModalUpdate">Télécharger</button>
                        </div>
                        <div class="edit">
                            <button class="btn btn-sm btn-primary edit-item-btn" onclick="updateFichier({{json_encode($file->id)}},{{json_encode($file->name)}},{{json_encode($file->periodicite)}},{{json_encode($file->visibilite)}})" data-bs-toggle="modal" data-bs-target="#showModalformulaireUpdate">Modifier</button>
                        </div>
                        <div class="remove">
                            <button class="btn btn-sm btn-danger remove-item-btn" onclick="deleteFichier({{$file->id}})" data-bs-toggle="modal" data-bs-target="#deleteRecordModal2">Supprimer</button>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tbody class="list form-check-all" id="filesPdf" @if(session()->has("pdf")===false)style="display: none"@endif>
            @foreach($pdf as $file)
                <tr>
                    <td class="customer_name" >
                    <h6 class="text-primary fw-bold mb-0 btn p-0">
                        {{$file->name}}
                    </h6>
                    </td>
                    @php
                        if($file->periodicite==="mensuelle")
                            $bg="bg-primary";
                        else if($file->periodicite==="trimestrielle")
                            $bg="bg-success";
                        else if($file->periodicite==="annuelle")
                            $bg="bg-dark";
                        else
                            $bg="bg-danger";
                    @endphp
                    <td>
                        <div class="btn btn-sm {{$bg}} text-white">
                            {{ucfirst($file->periodicite)}}
                        </div>
                    </td>
                    <td class="email">
                    <div class="d-flex gap-2">
                        Description : {{$file->description}}
                     </div>
                    </td>
                    <td>
                        <div class="d-flex gap-2">

                            <div class="edit">
                                <button class="btn btn-sm btn-primary edit-item-btn" onclick="updatePDF({{json_encode($file->id)}},{{json_encode($file->name)}},{{json_encode($file->periodicite)}},{{json_encode($file->description)}})" data-bs-toggle="modal" data-bs-target="#showModalPDFUpdate">Modifier</button>
                            </div>
                            <div class="remove">
                                <button class="btn btn-sm btn-danger remove-item-btn" onclick="deletePDF({{$file->id}})" data-bs-toggle="modal" data-bs-target="#deleteRecordModal15">Supprimer</button>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
</table>

<div class="d-flex justify-content-end">
    <div class="pagination-wrap hstack gap-2" id="formLink"  @if(session()->has("pdf")===false)style="display: none"@endif>
        {{$pdf->appends(['name' => request('name'),'visibility' => request('visibility'),'periodicite' => request('periodicite')])->links()}}
    </div>
    <div class="pagination-wrap hstack gap-2" id="formLink"  @if(session()->has("fichier")||session()->has("intern")||session()->has("pdf"))style="display: none"@endif>
        {{$forms->appends(['name' => request('name'),'visibility' => request('visibility'),'periodicite' => request('periodicite')])->links()}}
    </div>
    <div class="pagination-wrap hstack gap-2" id="fileLink"  @if(session()->has("fichier")===false)style="display: none"@endif>
        {{$files->appends(['name' => request('name'),'visibility' => request('visibility'),'periodicite' => request('periodicite')])->links()}}
    </div>
    <div class="pagination-wrap hstack gap-2" id="fileLink"  @if(session()->has("intern")===false)style="display: none"@endif>
        {{$intern->appends(['name' => request('name'),'visibility' => request('visibility'),'periodicite' => request('periodicite')])->links()}}
    </div>

</div>
