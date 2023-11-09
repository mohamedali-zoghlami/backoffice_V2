<table class="table align-middle table-nowrap" id="customerTable">
    <thead class="table-light">
        <tr>

            <th class="sort" data-sort="customer_name">NOM DU GROUPE</th>
            <th class="sort" data-sort="customer_name">PRIORITE</th>
            <th class="sort" data-sort="customer_name">DEPENDANCE</th>
            <th class="sort" data-sort="action">ACTION</th>
        </tr>
    </thead>
    <tbody class="list form-check-all">
    @foreach($groupes as $domaine)
        <tr>
            <td class="customer_name"><a href="/groupes/{{$domaine->id}}" class="link-primary">{{$domaine->nom}}</a></td>
            <td class="customer_name">{{$domaine->priorite}}</td>
            <td class="customer_name">@if($domaine->dep==="O") Oui @else Non @endif</td>

            <td>
                <div class="d-flex gap-2">
                    <div class="edit">
                        <button class="btn btn-sm btn-primary edit-item-btn" onclick="updateDomaine({{$domaine->id}},{{json_encode($domaine->nom)}},{{$domaine->priorite}},{{json_encode($domaine->dep)}})" data-bs-toggle="modal" data-bs-target="#showModal2">Modifier</button>
                    </div>
                    <div class="remove">
                        <button class="btn btn-sm btn-success remove-item-btn" onclick="deleteDomaine({{$domaine->id}})" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Supprimer</button>                                                        </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-end">
    <div class="pagination-wrap hstack gap-2">
        {{$groupes->appends(['name' => request('name')])->links()}}
    </div>
</div>
