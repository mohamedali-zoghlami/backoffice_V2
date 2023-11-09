<!DOCTYPE html>
<html>
<head>
    <title>Utilisateur</title>
    <style>
        table, tr, td,th {
  border: 1px solid black;
}
    </style>
</head>
<body>
    <h1 style="width: 100%;text-align:center;">Utilisateur</h1>
    <table style="width: 100%;text-align:center;">
        <thead>
            <tr>
                <th style="color:darkblue;" >Nom</th>
                <th style="color:darkblue;" >Email</th>
                <th style="color:darkblue;" >Operateur</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $acteur)
            <tr>
                <td class="customer_name">
                    <b>{{$acteur->name}}</b>
                </td>
                <td class="customer_name">
                    <b>{{$acteur->email}}</b>
                </td>
                <td class="customer_name">
                    <b>{{$acteur->operateur_name}}</b>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
