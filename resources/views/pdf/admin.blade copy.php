<!DOCTYPE html>
<html>
<head>
    <title>Administrateur</title>
</head>
<body>
    <h1 style="width: 100%;text-align:center;">Administrateur</h1>
    <table style="width: 100%;text-align:center;border:1px">
        <thead>
            <tr>
                <th style="color:darkblue;" >Nom</th>
                <th style="color:darkblue;" >Email</th>
                <th style="color:darkblue;" >Role</th>
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
                   <b>
                        @if($acteur->role==="1")
                            Super admin
                        @elseif($acteur->role==="2")
                            Admin
                        @else
                            Acteur
                        @endif

                   </b>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
