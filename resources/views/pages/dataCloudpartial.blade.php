<div @if(session()->has("fichier")||session()->has("pdf"))style="display: none"@endif>
    <table class="table align-middle table-nowrap" id="customerTable">
        <thead class="table-light">
            <tr>

                <th class="sort" data-sort="customer_name">Formulaire</th>
                <th class="sort" data-sort="email">Acteurs</th>
                <th class="sort" data-sort="action">Period de creation</th>
                <th class="sort" data-sort="action">Action</th>
            </tr>
        </thead>
        <tbody class="list form-check-all">
            @foreach ($files as $file )


            <tr>
                <td class="customer_name">{{$file->form->name}}</td>
                <td class="email">
                    <div class="d-flex gap-2">
                        <div class="remove">
                            <button class="btn btn-sm btn-danger danger-item-btn" >{{$file->name}}</button>
                        </div>
                    </div>
                </td>
                <td class="customer_name">{{$file->periodicity}} - {{$file->year}}</td>
                <td>
                    <div class="d-flex gap-2">
                        <div class="edit">
                            <button class="btn btn-sm btn-primary edit-item-btn" onclick="handleClickk({{json_encode($file)}})" data-bs-toggle="modal" data-bs-target="#formRender">ouvrir</button>
                            <button class="btn btn-sm btn-warning edit-item-btn" onclick="showCom({{json_encode($file->comm)}},{{json_encode($file->name)}})" data-bs-toggle="modal" data-bs-target="#commModal">Commentaire</button>

                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrap justify-content-end hstack gap-2">
        {{$files->appends(['name' => request('name'),'periodicite'=>request("periodicite"),'fiche'=>request("fiche"),'acteur'=>request("acteur"),"annee"=>request("annee")])->links()}}
    </div>
    </div>
    <div @if(session()->has("fichier")===false)style="display: none"@endif>
        <table class="table align-middle table-nowrap" id="customerTable">
            <thead class="table-light">
                <tr>

                    <th class="sort" data-sort="customer_name">Fichier</th>
                    <th class="sort" data-sort="email">Acteurs</th>
                    <th class="sort" data-sort="action">Date de creation</th>
                    <th class="sort" data-sort="action">Action</th>
                </tr>
            </thead>
            <tbody class="list form-check-all">
                @foreach ($fichiers as $fichier )
                <tr>
                    <td class="customer_name">{{$fichier->form->name}}</td>
                    <td class="email">
                        <div class="d-flex gap-2">
                            <div class="remove">
                                <button class="btn btn-sm btn-danger danger-item-btn">{{$fichier->name}}</button>
                            </div>
                        </div>
                    </td>
                    <td class="customer_name">{{$fichier->periodicity}} - {{$fichier->year}}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <div class="edit">
                                <button class="btn btn-sm btn-primary edit-item-btn" onclick="download({{json_encode($fichier->id)}},'submission')" >Télécharger</button>
                                <button class="btn btn-sm btn-warning edit-item-btn" onclick="showCom({{json_encode($fichier->comm)}},{{json_encode($file->name)}})" data-bs-toggle="modal" data-bs-target="#commModal">Commentaire</button>

                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap justify-content-end hstack gap-2">
            {{$fichiers->appends(['name' => request('name'),'periodicite'=>request("periodicite"),'fiche'=>request("fiche"),'acteur'=>request("acteur"),"annee"=>request("annee")])->links()}}
        </div>
    </div>

    <div @if(session()->has("pdf")===false)style="display: none"@endif>
        <table class="table align-middle table-nowrap" id="customerTable">
            <thead class="table-light">
                <tr>

                    <th class="sort" data-sort="customer_name">Fichier</th>
                    <th class="sort" data-sort="email">Acteurs</th>
                    <th class="sort" data-sort="action">Date de creation</th>
                    <th class="sort" data-sort="action">Action</th>
                </tr>
            </thead>
            <tbody class="list form-check-all">
                @foreach ($pdf as $fichier )
                <tr>
                    <td class="customer_name">{{$fichier->form->name}}</td>
                    <td class="email">
                        <div class="d-flex gap-2">
                            <div class="remove">
                                <button class="btn btn-sm btn-danger danger-item-btn">{{$fichier->name}}</button>
                            </div>
                        </div>
                    </td>
                    <td class="customer_name">{{$fichier->periodicity}} - {{$fichier->year}}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <div class="edit">
                                <button class="btn btn-sm btn-primary edit-item-btn" onclick="download({{json_encode($fichier->id)}},'pdf2')" >Télécharger</button>

                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap justify-content-end hstack gap-2">
            {{$pdf->appends(['name' => request('name'),'periodicite'=>request("periodicite"),'fiche'=>request("fiche"),'acteur'=>request("acteur"),"annee"=>request("annee")])->links()}}
        </div>
    </div>
