<table class="table align-middle table-nowrap" id="customerTable">
    <thead class="table-light">
        <tr>
           
            <th class="sort" data-sort="customer_name">Nom du domaine</th>
            <th class="sort" data-sort="action">Action</th>
        </tr>
    </thead>
    <tbody class="list form-check-all">
    @foreach($domaines as $domaine)
        <tr>
            
            <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ2101</a></td>
            <td class="customer_name">{{$domaine->nom_domaine}}</td>
            <td>
                <div class="d-flex gap-2">
                    <div class="edit">
                        <button class="btn btn-sm btn-primary edit-item-btn" onclick="updateDomaine({{$domaine->id}},{{json_encode($domaine->nom_domaine)}})" data-bs-toggle="modal" data-bs-target="#showModal">Modifier</button>
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
        {{$domaines->appends(['name' => request('name')])->links()}}
    </div>
</div>
