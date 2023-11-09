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

    <h1 style="width: 100%;text-align:center;">{{$data->name}}</h1>

    <table style="width: 100%;border:1px solid">
        <tbody >
            <tr style="width: 100%;border:1px solid">
                <td style="color:darkblue;text-align:start;font-weight:bold" >Nom</td>
                <td style="color:darkblue;text-align:start;font-weight:bold" >Periodicite</td>
            </tr>
            @if($data->formulaire->count()>0)
            <tr>
                <td colspan="2">
    <h2 style="width: 100%;text-align:center;">Formulaires publique</h2>
                </td>
            </tr>
    @endif
            @foreach($data->formulaire as $acteur)
            <tr>
                <td class="customer_name">
                    <b>{{$acteur->name}}</b>
                </td>
                <td class="customer_name">
                    <b>{{$acteur->periodicite}}</b>
                </td>

            </tr>
            @endforeach

    @if($data->fichier->count()>0)
    <tr>
        <td colspan="2">
    <h2 style="width: 100%;text-align:center;">Fichier</h2>
        </td>
    </tr>
    @endif
            @foreach($data->fichier as $acteur)
            <tr>
                <td class="customer_name">
                    <b>{{$acteur->name}}</b>
                </td>
                <td class="customer_name">
                    <b>{{$acteur->periodicite}}</b>
                </td>
            </tr>
            @endforeach
    @if($data->intern->count()>0)
    <tr>
        <td colspan="2">
    <h2 style="width: 100%;text-align:center;">Formulaire Interne</h2>
        </td>
    </tr>
    @endif

            @foreach($data->intern as $acteur)
            <tr>
                <td class="customer_name">
                    <b>{{$acteur->name}}</b>
                </td>
                <td class="customer_name">
                    <b>{{$acteur->periodicite}}</b>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


</body>
</html>
