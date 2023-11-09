<!DOCTYPE html>
<html>
<head>
    <title>Formules</title>
    <style>
        table, tr, td,th {
  border: 1px solid black;
}
    </style>
</head>
<body>
    <h1>Formules</h1>
    <table>
        <thead>
            <tr>
                <th >Nom formulaire</th>
                <th >Nom Acteur</th>
                <th>Pourcentage</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $formule)
        <tr>


            <td class="customer_name">
                {{$formule->name}}
            </td>
            <td class="phone">
            {{strtoupper($formule->acteur)}}

            </td>
            <td class="phone">
                {{$formule->operation." ".$formule->pourcentage}}%
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
