<table class="table align-middle table-nowrap" id="customerTable">
    <thead class="table-light">
        <tr>

            <th class="sort" data-sort="phone">Role</th>
            <th class="sort" data-sort="customer_name">Privilèges</th>
            <th class="sort" data-sort="action">Action</th>
        </tr>
    </thead>
    <tbody class="list form-check-all">
        @foreach($roles as $acteur)
        <tr>

            <td class="customer_name">
                {{$acteur->name}}
            </td>
            <td class="phone">

                 {{$acteur->privilege}}
            </td>
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
        {{$roles->appends(['name' => request('name')])->links()}}
    </div>
</div>
