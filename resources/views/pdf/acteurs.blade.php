<!DOCTYPE html>
<html>
<head>
    <title>Acteurs</title>
    <style>
        table, tr, td,th {
  border: 1px solid black;
}
    </style>
</head>
<body>
    <h1>Acteurs</h1>
    <table>
        <thead>
            <tr>
                <th >Acteur</th>
                <th >Domaine</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $acteur)
            <tr>
                <td class="customer_name">
                    {{$acteur->nom_acteur}}
                </td>
                <td class="phone">
                    @if($acteur->domaines->count()>0)||@endif
                @foreach ($acteur->domaines as $domaine )
                    {{strtoupper($domaine->nom_domaine)." || "}}
                @endforeach</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
