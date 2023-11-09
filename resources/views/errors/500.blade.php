@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
    <div class="alert alert-danger">
        Le serveur de base de données distant est injoignable ! <a href="{{ route('data') }}">Données</a>.
    </div>
</div>
</div>
@endsection
