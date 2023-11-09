<!DOCTYPE html>
<html>
<head>
    <title>Administrateur</title>
    <style>
        table, tr, td,th {
  border: 1px solid black;
}
    </style>
</head>
<body>
    <h1 style="width: 100%;text-align:center;">Administrateur</h1>
    <table style="width: 100%;text-align:center;">
        <thead>
            <tr>
                <th style="color:darkblue;" >Nom</th>
                <th style="color:darkblue;" >Operateur</th>

            </tr>
        </thead>
        <tbody>
            @foreach($data as $acteur)
            <tr style="margin-bottom: 5cm">
                <td class="customer_name">
                    <b>{{$acteur->name}}</b>
                </td>
                <td class="customer_name">
                    @if($acteur->operateur->count()>0)||@endif
                    @foreach ($acteur->operateur as $id => $name)
                    {{strtoupper($name)." || "}}
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
