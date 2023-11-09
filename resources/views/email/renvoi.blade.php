<!DOCTYPE html>
<html>
<head>
    <title>Fomulaire à modifier</title>
</head>
<body>
    <p>Bonjour</p>
    <br>
    <p>Votre soumission pour le formulaire {{$data->name}} de la periode {{$data->periodicite}} est rejetée !</p>
    <p>Pouvez vous le corriger : <a href="{{env('FRONT_OFFICE_WEB','').'/fiches/'.$data->id}}">Cliquer ici</p>
    <p>Cordialement</p>
    
</body>
</html>