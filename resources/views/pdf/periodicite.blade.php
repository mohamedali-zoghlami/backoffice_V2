<!DOCTYPE html>
<html>
<head>
    <title>Periodicite</title>
    <style>
        table, tr, td,th {
  border: 1px solid black;
}
    </style>
</head>
<body>
    <h1>Periodicite</h1>
    <table style="width:100%" >
        <thead class="table-light">
            <tr>
                <th class="sort" data-sort="customer_name">Periodicite</th>
                <th class="sort" data-sort="email">Jour de début   </th>
                <th class="sort" data-sort="email">Mois de début </th>
                <th class="sort" data-sort="action">Jour de fin</th>
                <th class="sort" data-sort="email">Mois de fin </th>
            </tr>
        </thead>
        <tbody >
            @foreach ($data as $valid )
                <tr>
                    <td class="customer_name">{{strtoupper($valid->periodicite)}}</td>
                    <td class="customer_name">{{$valid->start_day}}</td>
                    <td class="customer_name">M+{{$valid->increment_start}}</td>
                    <td class="customer_name">{{$valid->final_day}}</td>
                    <td class="customer_name">M+{{$valid->increment_final}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
