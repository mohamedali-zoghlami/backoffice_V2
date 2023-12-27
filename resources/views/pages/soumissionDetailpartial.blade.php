<div class="tasks-board d-flex justify-content-between" id="kanbanboard"  >
    <div class="tasks-list  "  >
        <div class="d-flex mb-3" >
            <div class="flex-grow-1">
                <h6 class="fs-14 text-uppercase fw-semibold mb-0">A faire<small class="badge bg-info align-bottom ms-1 totaltask-badge" id="not-sub-count">{{$count->faire}}</small></h6>
            </div>
            <div class="flex-shrink-0">

            </div>
        </div>

        <div  class=" mh-100 px-2 mx-n3  ">
            <div id="unassigned-task" class="tasks @if ($count->faire>0) bg-white border @endif rounded-4 px-3 py-4">

                @foreach ($forms as $sub)
                @if($sub->type==="faire")
                <div class="card tasks-box mx-2 border-primary custom-border">
                    <div class="card-body ">
                        <div class="d-flex mb-2">
                            <h6 class="fs-15 mb-0 flex-grow-1 text-break task-title">
                                @if($sub->source!=="publique")<button class="text-primary text-decoration-underline  text-start fw-bold mb-0 btn p-0" type="button" onclick="handleClickk1({{json_encode($sub)}})">{{$sub->name}}</button>@else <div class="text-primary text-start fw-bold mb-0 p-0">{{$sub->name}}</div> @endif
                           </h6>

                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-bold mb-0">{{ucwords($sub->periodicite)}}</h6>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0">{{$sub->date_to}} - {{$sub->year}}</h6>
                        </div>
                        @if($sub->source==="publique")
                        <div class="flex-grow-1 mt-3">
                            <button onclick="soumissionAutomatique({{json_encode($sub)}},{{json_encode($acteur)}})" class="btn btn-sm btn-primary">Soumission automatique</button>
                            <button onclick="reouvrir({{json_encode($sub)}},{{json_encode($acteur)}},'formulaire')" class="btn btn-sm btn-warning">Reouvrir</button>
                        </div>
                        @endif
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
                @endif
                @endforeach
                @foreach ($excel as $sub )
                @if($sub->type==="faire")
                <div class="card tasks-box mx-2 border-primary custom-border">
                    <div class="card-body ">
                        <div class="d-flex mb-2">
                            <h6 class="fs-15 mb-0 flex-grow-1 text-primary text-break fw-bold task-title text-start">
                                Fichier : {{$sub->name}}
                            </h6>

                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-bold mb-0">{{ucwords($sub->periodicite)}}</h6>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0">{{$sub->date_to}} - {{$sub->year}}</h6>
                        </div>
                        <div class="pt-3 flex-grow-1 justify-content-start d-flex">
                            <button onclick="download({{json_encode($sub->id)}},'form1')" class="btn btn-primary btn-sm">Télécharger</button>
                            <button onclick="reouvrir({{json_encode($sub)}},{{json_encode($acteur)}},'fichier')" class="mx-1 btn btn-sm btn-warning">Reouvrir</button>
                        </div>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
                @endif
                @endforeach
                @foreach ($pdf as $sub )
                @if($sub->type==="faire")
                <div class="card tasks-box mx-2 border-primary custom-border">
                    <div class="card-body ">
                        <div class="d-flex mb-2">
                            <h6 class="fs-15 mb-0 flex-grow-1 text-primary text-break fw-bold task-title text-start">
                                Fichier : {{$sub->name}}
                            </h6>

                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-bold mb-0">{{ucwords($sub->periodicite)}}</h6>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-bold fs-12 my-2">Description : {{$sub["description"]}}</h6>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0">{{$sub->date_to}} - {{$sub->year}}</h6>
                        </div>
                        <div class="pt-3 flex-grow-1 justify-content-start d-flex">
                            <button onclick="reouvrir({{json_encode($sub)}},{{json_encode($acteur)}},'pdf')" class="mx-1 btn btn-sm btn-warning">Reouvrir</button>
                        </div>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
                @endif
                @endforeach
            </div>
            <!--end tasks-->
        </div>

    </div>
    <!--end tasks-list-->
    <div class="tasks-list ">
        <div class="d-flex mb-3">
            <div class="flex-grow-1">
                <h6 class="fs-14 text-uppercase fw-semibold mb-0">En Cours<small class="badge bg-warning align-bottom ms-1 totaltask-badge" id="cours-sub-count">{{$count->cours}}</small></h6>
            </div>
            <div class="flex-shrink-0">

            </div>
        </div>

        <div class="mh-100 px-2 mx-n3">
            <div id="assigned-task" class="tasks @if ($count->cours>0) bg-white border @endif rounded-4 px-2 py-4">

                @foreach ($forms as $sub)
                @if($sub->type==="draft")
                <div class="card tasks-box mx-2 border-warning custom-border">
                    <div class="card-body ">
                        <div class="d-flex mb-2">
                            <h6 class="fs-15 mb-0 flex-grow-1  text-break task-title">
                                @if($sub->source!=="publique")<button class="text-primary text-decoration-underline text-start fw-bold mb-0 btn p-0" type="button" onclick="handleClickk1({{json_encode($sub)}})">{{$sub->name}}</button>@else <div class="text-primary text-start fw-bold mb-0 p-0">{{$sub->name}}</div> @endif
                           </h6>

                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-bold mb-0">{{ucwords($sub->periodicite)}}</h6>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0">{{$sub->date_to}} - {{$sub->year}}</h6>
                        </div>
                        @if($sub->source==="publique")
                        <div class="flex-grow-1 mt-3">

                            <button onclick="soumissionAutomatique({{json_encode($sub)}},{{json_encode($acteur)}})" class="btn btn-sm btn-primary">Soumission automatique</button>
                            <button onclick="reouvrir({{json_encode($sub)}},'formulaire')" class="btn btn-sm btn-warning ">Reouvrir</button>
                         </div>
                        @endif
                    </div>
                    <!--end card-body-->
                </div>
                @endif
                @endforeach

              </div>
            <!--end tasks-->
            </div>

    </div>
    <div class="tasks-list">
        <div class="d-flex mb-3">
            <div class="flex-grow-1">
                <h6 class="fs-14 text-uppercase fw-semibold mb-0">Envoyée<small class="badge bg-success align-bottom ms-1 totaltask-badge" id="env-sub-count">{{$count->env}}</small></h6>
            </div>
            <div class="flex-shrink-0">

            </div>
        </div>

        <div  class=" mh-100 px-2 mx-n3  ">
            <div id="done-task" class="tasks @if ($count->env>0) bg-white border  @endif rounded-4 px-3 py-4">

                @foreach ($forms as $sub)
                @if($sub->type==="final")
                <div class="card tasks-box mx-2 border-success custom-border">
                    <div class="card-body ">
                        <div class="d-flex mb-2">
                            <h6 class="fs-15 mb-0 flex-grow-1 text-break task-title">
                                <button type="button" onclick="@if($sub->source==="publique")handleClickk({{json_encode($sub)}})@else handleClickk1({{json_encode($sub)}})@endif" class="text-primary text-start text-decoration-underline fw-bold mb-0 btn p-0 " >{{$sub->name}}</button>
                           </h6>

                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-bold mb-0">{{ucwords($sub->periodicite)}}</h6>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0">{{$sub->date_to}} - {{$sub->year}}</h6>
                        </div>
                        @if($sub->source==="publique")
                        <div class="flex-grow-1 mt-3">
                            @if(isset($sub->commentaire))
                            <button onclick="commentaire({{json_encode($sub)}})" class="btn btn-sm btn-success">Commentaires</button>
                            @endif
                            <button onclick="modification({{json_encode($sub)}},'publique')" class="btn btn-sm btn-warning">Modifier</button>
                            <button onclick="renvoyer({{json_encode($sub)}},'formulaire')" data-bs-toggle="modal" data-bs-target="#showModalComm" class="btn btn-sm btn-danger">Renvoyer</button>
                        </div>
                        @else
                        <div class="flex-grow-1 mt-3">
                            <button onclick="modification({{json_encode($sub)}},'intern')" class="btn btn-sm btn-warning">Modifier</button>
                        </div>
                        @endif
                    </div>
                    <!--end card-body-->
                </div>
                @endif
                @endforeach
                @foreach ($excel as $sub )
                @if($sub->type==="final")
                <div class="card tasks-box mx-2 border-success custom-border">
                    <div class="card-body ">
                        <div class="d-flex mb-2">
                            <h6 class="fs-15 mb-0 flex-grow-1 text-primary text-break fw-bold task-title text-start">
                                Fichier : {{$sub->name}}
                            </h6>

                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-bold mb-0">{{ucwords($sub->periodicite)}}</h6>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0">{{$sub->date_to}} - {{$sub->year}}</h6>
                        </div>
                        <div class="pt-3 flex-grow-1 justify-content-start d-flex">
                            @if(isset($sub->commentaire))
                            <button onclick="commentaire({{json_encode($sub)}})" class="btn btn-sm btn-success">Commentaires</button>
                            @endif
                            <button onclick="download({{json_encode($sub->sub_id)}},'data')" class="btn btn-warning btn-sm ">Télécharger</button>
                            <button onclick="renvoyer({{json_encode($sub)}},'fichier')" data-bs-toggle="modal" data-bs-target="#showModalComm" class="btn btn-sm btn-danger mx-1">Renvoyer</button>
                        </div>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
                @endif
                @endforeach
                @foreach ($pdf as $sub )
                @if($sub->type==="final")
                <div class="card tasks-box mx-2 border-success custom-border">
                    <div class="card-body ">
                        <div class="d-flex mb-2">
                            <h6 class="fs-15 mb-0 flex-grow-1 text-primary text-break fw-bold task-title text-start">
                                PDF : {{$sub->name}}
                            </h6>

                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-bold mb-0">{{ucwords($sub->periodicite)}}</h6>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0">{{$sub->date_to}} - {{$sub->year}}</h6>
                            <h6 class="text-muted text-break fw-bold fs-12 my-2">Description : {{$sub["description"]}}</h6>
                        </div>
                        <div class="pt-3 flex-grow-1 justify-content-start d-flex">
                            <button onclick="download({{json_encode($sub->sub_id)}},'pdf')" class="btn btn-warning btn-sm ">Télécharger</button>
                            <button onclick="renvoyer({{json_encode($sub)}},'pdf')" data-bs-toggle="modal" data-bs-target="#showModalComm" class="btn btn-sm btn-danger mx-1">Renvoyer</button>
                        </div>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
                @endif
                @endforeach
                 </div>
            <!--end tasks-->
        </div>

    </div>
</div>
