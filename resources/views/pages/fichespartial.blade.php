<table class="table align-middle table-nowrap" id="customerTable">
    <thead class="table-light">
        <tr>
            <th class="sort" data-sort="customer_name">Fiche</th>
            <th class="sort" data-sort="email">Acteurs</th>
            <th class="sort" data-sort="action">Action</th>
        </tr>
    </thead>
    <tbody id="item-body" class="list form-check-all">
    @foreach($fiches as $fiche)
        <tr>
            <td class="customer_name">
                @php
                    $url = route('fiche.detail', ['id' => $fiche->id]);
                @endphp
                <a href="{{$url}}" class="text-decoration-underline fw-bold">{{$fiche->name}}</a></td>
            <td class="email">
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($fiche->operateur as $id => $name)
                    @php
                        if($id%4===1)
                            $bg="btn-danger";
                        else if($id%4===2)
                            $bg="btn-warning";
                        else if($id%4===3)
                            $bg="btn-primary";
                        else
                            $bg="btn-success";

                    @endphp
                    <div class="btn btn-sm {{$bg}}">
                    {{strtoupper($name)}}
                    </div>
                    @endforeach
                 </div>
            </td>
            <td>
                <div class="d-flex gap-2">
                    <div class="edit">
                        <button class="btn btn-sm btn-primary edit-item-btn" onclick="updateFiche({{json_encode($fiche)}})" data-bs-toggle="modal" data-bs-target="#showModalUpdate">Modifier</button>
                    </div>
                    <div class="remove">
                        <button class="btn btn-sm btn-success remove-item-btn" onclick="deleteFiche({{$fiche->id}})" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Supprimer</button>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-end">
    <div class="pagination-wrap hstack gap-2">
        @php
             $operateurIds = request()->input('operateur_id');
                if (is_array($operateurIds)) {
                    $operateurIds= implode(',', $operateurIds);
                }
        @endphp
        {{$fiches->appends(['name' => request()->input('name'),'operateur_id'=>$operateurIds])->links()}}
    </div>
</div>
