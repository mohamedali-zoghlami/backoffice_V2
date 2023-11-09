<!DOCTYPE html>
<html>
<head>
    <title>Domaines</title>
    <style>
        table, tr, td,th {
  border: 1px solid black;
}
    </style>
</head>
<body>
    <h1 style="width: 100%;text-align:center;">Domaines</h1>
    <table style="width: 100%;text-align:center;">
        <thead>
            <tr>
                <th style="color:darkblue;" >Nom</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $acteur)
            <tr>
                <td class="customer_name">
                    <b>{{$acteur->nom_domaine}}</b>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
