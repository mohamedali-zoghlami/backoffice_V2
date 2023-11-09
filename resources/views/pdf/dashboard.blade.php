<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        table, tr, td,th {
  border: 1px solid black;
}
    </style>
</head>
<body>
    <h1 style="width: 100%;text-align:center;">Dashboard</h1>
    <table style="width: 100%;text-align:center;">
        <thead>
            <tr>
                <th >Nom</th>
                <th >Visible</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $acteur)
            <tr>
                <td class="customer_name">
                    <a href="{{$acteur->lien}}">{{$acteur->name}}</a>
                </td>
                <td class="phone">
                    {{$acteur->visible}}
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
