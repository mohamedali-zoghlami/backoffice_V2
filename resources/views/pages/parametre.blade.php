
@extends("layouts.app")

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Gestion des Périodicités</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Paramètres > Périodicité</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                            <button type="button" class="btn btn-warning add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#downloadModal"><i class="ri-file-download-line"></i> Télécharger</button>
                    </div>
                    <div class="card-body">

                        <div class="listjs-table" id="customerList">

                            <div id="items-list" class="table-responsive table-card mb-1">
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Périodicité</th>
                                            <th class="sort" data-sort="email">Jour de début   </th>
                                            <th class="sort" data-sort="email">Mois de début </th>
                                            <th class="sort" data-sort="action">Jour de fin</th>
                                            <th class="sort" data-sort="email">Mois de fin </th>
                                            <th class="sort" data-sort="email">Action  </th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($validation as $valid )
                                            <tr>
                                                <td class="customer_name">{{strtoupper($valid->periodicite)}}</td>
                                                <td class="customer_name">{{$valid->start_day}}</td>
                                                <td class="customer_name">M+{{$valid->increment_start}}</td>
                                                <td class="customer_name">{{$valid->final_day}}</td>
                                                <td class="customer_name">M+{{$valid->increment_final}}</td>
                                                <td class="customer_name"><button class="btn btn-success" onclick="update({{json_encode($valid)}})" data-bs-toggle="modal" id="create-btn" data-bs-target="#validTime">Modifier</button> </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end col -->
        </div>
        <div class="modal fade zoomIn" id="downloadModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Télécharger les formules en fichier :</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                    </div>
                    <div class="modal-body d-flex justify-content-center align-items-center">

                            <form action="/excel" class="m-4" method="POST">
                                @csrf
                                <input name="source" value="periodicite" hidden>
                                <button type="submit" class="btn btn-success"><i class="ri-file-download-line"></i> Excel</button>
                            </form>
                            <form action="/pdf" class="m-4" method="POST">
                                @csrf
                                <input name="source" value="periodicite" hidden>
                                <button type="submit" class="btn btn-warning"><i class="ri-file-download-line"></i> PDF</button>
                            </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="validTime" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel">Validation time</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                    </div>
                    <form class="tablelist-form" action="/changeValid" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input val="" name="periodicite" id="periodicite" hidden>
                            <div class="mb-3">
                                <label for="email-field" class="form-label">Periodicite</label>
                                <input type="text" class="form-control" val="" name="periodicite2" id="periodicite2" required readonly disabled>
                            </div>
                            <div class="mb-3">
                                <label for="email-field" class="form-label">Jour de début :</label>
                                <input class="form-control" type="number" name="start" id="start" min="1" max="31" required>
                            </div>
                            <div class="mb-3">
                                <label for="email-field" class="form-label">Mois de début : M + ?</label>
                                <input class="form-control" type="number" name="incs" id="incs" min="1" max="12" required>
                            </div>
                            <div class="mb-3">
                                <label for="email-field" class="form-label">Jour de fin</label>
                                <input class="form-control" type="number" name="final" id="final" min="1" max="31" required>
                            </div>
                            <div class="mb-3">
                                <label for="email-field" class="form-label">Mois de fin : M + ? :</label>
                                <input class="form-control" type="number" name="incf" id="incf" min="1" max="12" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-success" id="add-btn">Modifier</button>
                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section("script")
<script>
    update=function(valid){
        $("#periodicite").val(valid.periodicite);
        $("#periodicite2").val(valid.periodicite);
        $("#start").val(valid.start_day);
        $("#final").val(valid.final_day);
        $("#incs").val(valid.increment_start);
        $("#incf").val(valid.increment_final);
    }
</script>
@endsection
