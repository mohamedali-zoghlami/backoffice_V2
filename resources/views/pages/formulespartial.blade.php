<table class="table align-middle table-nowrap" id="customerTable">
    <thead class="table-light">
        <tr>

            <th class="sort" data-sort="customer_name">Formulaires</th>
            <th class="sort" data-sort="action">Acteur</th>
            <th class="sort" data-sort="action">Pourcentage</th>
            <th class="sort" data-sort="action">Action</th>
        </tr>
    </thead>
    <tbody class="list form-check-all">
        @foreach($formules as $formule)
        <tr>


            <td class="customer_name">
                {{$formule->name}}
            </td>
            <td class="phone">
                @php
                if($formule->operateur_id%4===1)
                    $bg="btn-danger";
                else if($formule->operateur_id%4===2)
                    $bg="btn-warning";
                else if($formule->operateur_id%4===3)
                    $bg="btn-primary";
                else
                    $bg="btn-success";
            @endphp
            <div class="btn btn-sm {{$bg}}">
            {{strtoupper($formule->acteur)}}
            </div>

            </td>
            <td class="phone">
                {{$formule->operation." ".$formule->pourcentage}}%
            </td>
            <td>
                <div class="d-flex gap-2">
                    <div class="edit">
                        <button onclick="updateActeur({{json_encode($formule)}})" class="btn btn-sm btn-primary edit-item-btn" data-bs-toggle="modal" data-bs-target="#updateModal">Modifier</button>
                    </div>
                    <div class="remove">
                        <button class="btn btn-sm btn-success remove-item-btn" onclick="deleteActeur({{$formule->id}})" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Supprimer</button>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>
<div class="d-flex justify-content-end">
    <div class="pagination-wrap hstack gap-2">
        {{$formules->appends(['formulaire' => request('formulaire'),"acteur"=>request("acteur")])->links()}}
    </div>
</div>
