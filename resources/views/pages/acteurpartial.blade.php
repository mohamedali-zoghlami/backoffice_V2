<table class="table align-middle table-nowrap" id="customerTable">
    <thead class="table-light">
        <tr>
            
            <th class="sort" data-sort="phone">Acteur</th>
            <th class="sort" data-sort="customer_name">Domaine</th>
            <th class="sort" data-sort="action">Action</th>
        </tr>
    </thead>
    <tbody class="list form-check-all">
        @foreach($acteurs as $acteur)
        <tr>
           
            <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ2101</a></td>

            <td class="customer_name">
                {{$acteur->nom_acteur}}
            </td>
            <td class="phone">
            @foreach ($acteur->domaines as $domaine )
                @php
                    if($domaine->id%4===1)
                        $bg="btn-danger";
                    else if($domaine->id%4===2)
                        $bg="btn-warning";
                    else if($domaine->id%4===3)
                        $bg="btn-primary";
                    else
                        $bg="btn-success";

                @endphp
                <div class="btn btn-sm {{$bg}}">
                {{strtoupper($domaine->nom_domaine)}}
                </div>
            @endforeach</td>
            <td>
                <div class="d-flex gap-2">
                    <div class="edit">
                        <button onclick="updateActeur({{json_encode($acteur)}})" class="btn btn-sm btn-primary edit-item-btn" data-bs-toggle="modal" data-bs-target="#updateModal">Modifier</button>
                    </div>
                    <div class="remove">
                        <button class="btn btn-sm btn-success remove-item-btn" onclick="deleteActeur({{$acteur->id}})" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Supprimer</button>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>
<div class="d-flex justify-content-end">
    <div class="pagination-wrap hstack gap-2">
        {{$acteurs->appends(['name' => request('name')])->links()}}
    </div>
</div>
