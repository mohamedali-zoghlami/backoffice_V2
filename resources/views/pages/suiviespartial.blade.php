<table class="table align-middle table-nowrap" id="customerTable">
    <thead class="table-light">
        <tr>

            <th  data-sort="email">Operateur</th>
            <th  data-sort="action">À faire</th>
            <th  data-sort="action">En cours</th>
            <th  data-sort="action">Envoyées</th>
            <th  data-sort="action">À refaire</th>
        </tr>
    </thead>
    <tbody class="list form-check-all">
        @foreach ($suivi as $period )
        <tr>
            <td class="customer_name">{{strtoupper($period->nom_acteur)}}</td>
            <td class="">
                <div class="btn btn-sm btn-primary">
                    {{$period->faire}}
                </div>

            </td>
            <td class="">
                <div class="btn btn-sm btn-warning">
                    {{$period->cours}}
                </div>
            </td>
            <td class="">
                <div class="btn btn-sm btn-success">
                    {{$period->final}}
                </div>
            </td>
            <td class="">
                <div class="btn btn-sm btn-danger">
                    {{$period->redo}}
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="pagination-wrap justify-content-end hstack gap-2">
    {{$suivi->appends(['name' => request('name'),'periodicite'=>request("periodicite"),'fiche'=>request("fiche"),'acteur'=>request("acteur"),"annee"=>request("annee")])->links()}}
</div>
