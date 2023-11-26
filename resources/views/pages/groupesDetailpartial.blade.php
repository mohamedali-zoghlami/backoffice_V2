<table class="table align-middle table-nowrap" id="customerTable">
    <thead class="table-light">
        <tr>

            <th class="sort" data-sort="customer_name">Nom du formulaire</th>
            <th class="sort" data-sort="customer_name">Priorite</th>
            <th class="sort" data-sort="customer_name">Type</th>
            <th class="sort" data-sort="customer_name">D�pendance</th>
            <th class="sort" data-sort="action">Action</th>
        </tr>
    </thead>
    <tbody class="list form-check-all">
    @foreach($form as $domaine)
        <tr>
            <td class="customer_name">{{$domaine->name}}</td>
            <td>{{$domaine->priorite}}</td>
            <td>
                {{strtoupper($domaine->type)}}
            </td>
            <td class="customer_name">@if($domaine->dep==="O") Oui @else Non @endif</td>
            <td>
                <div class="d-flex gap-2">
                    <div class="edit">
                        <button class="btn btn-sm btn-primary edit-item-btn" onclick="updateDomaine({{$domaine->id}},{{json_encode($domaine->name)}},{{$domaine->priorite}},{{json_encode($domaine->type)}},{{json_encode($domaine->dep)}})" data-bs-toggle="modal" data-bs-target="#showModal2">Modifier</button>
                    </div>
                    <div class="remove">
                        <button class="btn btn-sm btn-success remove-item-btn" onclick="deleteDomaine({{$domaine->id}},{{json_encode($domaine->type)}})" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Supprimer</button>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-end">
    <div class="pagination-wrap hstack gap-2">
        {{$form->links()}}
    </div>
</div>
