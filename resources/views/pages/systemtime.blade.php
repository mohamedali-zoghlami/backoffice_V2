
@extends("layouts.app")

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Gestion des dates système</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Paramètres > Système</li>
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
                    <div class="card-body">

                        <div class="listjs-table" id="customerList">
                            <div id="items-list" class="table-responsive table-card mb-1">
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Description</th>
                                            <th class="sort" data-sort="email">Année</th>
                                            <th class="sort" data-sort="email">Mois</th>
                                            <th class="sort" data-sort="email">Action  </th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        <tr>
                                            <td class="customer_name">Date de début de l'historique</td>
                                            <td>{{$system->year}}</td>
                                            <?php
                                            $numericMonth = $system->mois;
                                            $frenchMonths = [
                                                    1 => 'Janvier',
                                                    2 => 'Février',
                                                    3 => 'Mars',
                                                    4 => 'Avril',
                                                    5 => 'Mai',
                                                    6 => 'Juin',
                                                    7 => 'Juillet',
                                                    8 => 'Août',
                                                    9 => 'Septembre',
                                                    10 => 'Octobre',
                                                    11 => 'Novembre',
                                                    12 => 'Décembre',
                                                ];
                                                $frenchMonth = $frenchMonths[$numericMonth] ?? null;                                            ?>
                                            <td>{{$frenchMonth}}</td>
                                            <td><button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#systemTime"> Modifier</button></td>
                                        </tr>
                                        <tr>
                                            <td class="customer_name">Date de début des soumissions</td>
                                            <td>{{$system2->year}}</td>
                                            <?php
                                            $numericMonth = $system2->mois;
                                            $frenchMonths = [
                                                    1 => 'Janvier',
                                                    2 => 'Février',
                                                    3 => 'Mars',
                                                    4 => 'Avril',
                                                    5 => 'Mai',
                                                    6 => 'Juin',
                                                    7 => 'Juillet',
                                                    8 => 'Août',
                                                    9 => 'Septembre',
                                                    10 => 'Octobre',
                                                    11 => 'Novembre',
                                                    12 => 'Décembre',
                                                ];
                                                $frenchMonth = $frenchMonths[$numericMonth] ?? null;                                            ?>
                                            <td>{{$frenchMonth}}</td>
                                            <td><button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#systemTime2"> Modifier</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card mx-auto" style="width: 10rem;">
                            <div class="card-header text-center"><h6>Logo</h6></div>
                            <img class="card-img-top" src="{{$image_path}}" alt="Card image cap">
                            <div class="card-body text-center">
                                <button type="button" onclick="uploadHundle()" class="btn btn-sm btn-primary add-btn"> Modifier logo</button>
                            </div>
                          </div>
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end col -->
        </div>
        <div class="modal fade" id="systemTime2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel">Date de début des soumissions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                    </div>
                    <form class="tablelist-form" action="/changeYear" method="POST">
                        @csrf
                        <div class="modal-body">

                            <input type="text" value="2" name="id" hidden>
                            <div class="mb-3">
                                <label for="email-field" class="form-label">Année</label>
                                <select class="form-control" name="year" required>
                                @for($i=date('Y')+1;$i>=$year;$i--)
                                    <option value="{{$i}}" @if($i===$system2->year) selected @endif>{{$i}}</option>
                                @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="email-field" class="form-label">Mois</label>
                                <select class="form-control" id="mois2" name="mois" required>
                                <option value="1">Janvier</option>
                                <option value="2">Février</option>
                                <option value="3">Mars</option>
                                <option value="4">Avril</option>
                                <option value="5">Mai</option>
                                <option value="6">Juin</option>
                                <option value="7">Juillet</option>
                                <option value="8">Août</option>
                                <option value="9">Septembre</option>
                                <option value="10">Octobre</option>
                                <option value="11">Novembre</option>
                                <option value="12">Décembre</option>


                                </select>
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
        <div class="modal fade" id="systemTime" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel">Date de début de l'historique</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                    </div>
                    <form class="tablelist-form" action="/changeYear" method="POST">
                        @csrf
                        <div class="modal-body">

                            <input type="text" value="1" name="id" hidden>
                            <div class="mb-3">
                                <label for="email-field" class="form-label">Année</label>
                                <select class="form-control" name="year" required>
                                @for($i=date('Y')+1;$i>=$year;$i--)
                                    <option value="{{$i}}" @if($i===$system->year) selected @endif>{{$i}}</option>
                                @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="email-field" class="form-label">Mois</label>
                                <select class="form-control" id="mois" name="mois" required>
                                <option value="1">Janvier</option>
                                <option value="2">Février</option>
                                <option value="3">Mars</option>
                                <option value="4">Avril</option>
                                <option value="5">Mai</option>
                                <option value="6">Juin</option>
                                <option value="7">Juillet</option>
                                <option value="8">Août</option>
                                <option value="9">Septembre</option>
                                <option value="10">Octobre</option>
                                <option value="11">Novembre</option>
                                <option value="12">Décembre</option>


                                </select>
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
    uploadHundle=function ()
        {
            Swal.fire({
            title: 'Modifier le logo',
            html: `
                <form id="uploadForm" action="{{ route('upload.imageLogo') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="file" name="image" id="excelFile" class="swal2-file" accept=".jpg, .jpeg, .gif, .gif" required>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Modifier',
            cancelButtonText: 'Annuler',
            preConfirm: () => {

                const formElement = document.getElementById('uploadForm');
                const excelFileElement = document.getElementById('excelFile');
                const excelFile = excelFileElement.files[0];
                const allowedExtensions = /(\.jpeg|\.jpg|\.png|\.gif)$/i;

                if (!excelFile) {
                Swal.showValidationMessage('Sélectionnez une image');
                }
                else if(!allowedExtensions.exec(excelFileElement.value))
                {
                Swal.showValidationMessage('Sélectionnez une image');
                }

                // Return the form field values
                return { excelFile: excelFile,
                };
            }
            }).then((result) => {
            if (result.isConfirmed) {
                formElement=document.getElementById("uploadForm")
                formElement.submit();
                        }
                        });
        }
        $(document).ready(function() {
            $("#mois").val(@json($system->mois))
            $("#mois2").val(@json($system2->mois))
            });
</script>
@endsection
