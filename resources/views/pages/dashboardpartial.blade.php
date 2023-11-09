<table class="table align-middle table-nowrap" id="customerTable">
    <thead class="table-light">
        <tr>

            <th >Nom du dashboard</th>
            <th >Lien</th>
            <th >Visible</th>
            <th> Action</th>
        </tr>
    </thead>
    <tbody class="list form-check-all">
        @foreach($dashboard as $dash)
        <tr>

            <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ2101</a></td>

            <td class="customer_name">
                {{$dash->name}}
            </td>
            <td>
            <div class="truncated-text" data-toggle="tooltip" data-placement="top" title="{{strtoupper($dash->lien)}}">
                <a href="{{$dash->lien}}">{{ \Illuminate\Support\Str::limit(strtoupper($dash->lien), 40, $end = '...') }}</a>
            </div></td>
            <td>
                {{strtoupper($dash->visible) }}

            </td>
            <td>
                <div class="d-flex gap-2">
                    <div class="edit">
                        <button onclick="updateActeur({{json_encode($dash)}})" class="btn btn-sm btn-primary edit-item-btn" data-bs-toggle="modal" data-bs-target="#updateModal">Modifier</button>
                    </div>
                    <div class="remove">
                        <button class="btn btn-sm btn-success remove-item-btn" onclick="deleteActeur({{$dash->id}})" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Supprimer</button>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>
<div class="d-flex justify-content-end">
    <div class="pagination-wrap hstack gap-2">
        {{$dashboard->appends(['name' => request('name')])->links()}}
    </div>
</div>
