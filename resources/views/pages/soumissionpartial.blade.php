<div class="tasks-board d-flex justify-content-center" id="kanbanboard"  >
    <div class="tasks-list "  >
        <div class="d-flex mb-3" >
            <div class="flex-grow-1">
                <h6 class="fs-14 text-uppercase fw-semibold mb-0">A FAIRE<small class="badge bg-info align-bottom ms-1 totaltask-badge">{{$count->faire}}</small></h6>
            </div>
            <div class="flex-shrink-0">
                <div class="dropdown card-header-dropdown">

                </div>
            </div>
        </div>
        <div  class=" mh-100 px-2 mx-n3  ">
            <div id="unassigned-task" class="tasks @if($count->faire)bg-white border @endif rounded-4 px-3 py-4">
        @foreach ($fiches as $fiche )
        @if ($fiche->sub==0 && $fiche->draft==0 && ($fiche->forms>0 || $fiche->ficher>0) )

                <div class="card tasks-box mx-2 border-primary custom-border">
                    <div class="card-body ">
                        <div class="d-flex mb-2">
                            <h6 class="fs-15 mb-0 flex-grow-1 text-truncate task-title">
                                <a href="{{'/soumission/'.$fiche->id."/".$act}}" class="text-primary text-decoration-underline fw-bold mb-0 btn p-0 " >{{$fiche->name}}
                            </a></h6>

                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-bold mb-0">({{$fiche->forms}} Formulaires Publique)</h6>
                            <h6 class="text-muted fw-bold mb-0">({{$fiche->fichier}} Fichier)</h6>

                        </div>
                        <br>
                        <div class="mb-3">
                            <div class="d-flex mb-1">

                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-0">0% of 100%</h6>
                                </div>

                            </div>
                            <div class="progress rounded-3 progress-sm">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
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
                <h6 class="fs-14 text-uppercase fw-semibold mb-0">EN COURS<small class="badge bg-warning align-bottom ms-1 totaltask-badge">{{$count->cours }}</small></h6>
            </div>
            <div class="flex-shrink-0">
                <div class="dropdown card-header-dropdown">

                </div>
            </div>
        </div>
        <div class="tasks-wrapper mh-100 px-2 mx-n3">
            <div id="unassigned-task" class="tasks @if($count->cours>0) bg-white border @endif rounded-4 px-2 py-4">
                @foreach ($fiches as $file )
                    @if($file->type=="cours")
                    <div class="card tasks-box mx-2 border-warning custom-border">
                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <h6 class="fs-15 mb-0 flex-grow-1 text-truncate task-title text-primary text-decoration-underline fw-bold"><a href="{{'/soumission/'.$file->id."/".$act}}" class="">
                                {{$file->name}}
                                </a></h6>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-muted fw-bold mb-0">({{$file->forms}} Formulaires Publiques)</h6>
                                <h6 class="text-muted fw-bold mb-0">({{$file->fichier}} Fichier)</h6>

                            </div>
                            <br>
                            <div class="mb-3">
                                <div class="mb-1">
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-0">{{$file->sub}} : <span class="text-success"> ENVOYE(S)</span></h6>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-0">{{$file->draft}} : <span class="text-warning"> EN COURS</span></h6>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-0">{{($file->forms+$file->fichier)-($file->sub+$file->draft+$file->renv)}} : <span class="text-secondary"> A FAIRE</span>
                                    </div>
                                </div>
                                <div class="progress rounded-3 progress-sm">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{number_format(($file->sub/$file->forms)*100,2)}}%" aria-valuenow="{{number_format(($file->sub/$file->forms)*100,2)}}" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{number_format(($file->draft/$file->forms)*100,2)}}%" aria-valuenow="{{number_format(($file->sub/$file->forms)*100,2)}}" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-secondary"  role="progressbar" style="width: {{number_format((($file->forms+$file->fichier-$file->sub-$file->draft)/$file->forms)*100,2)}}%" aria-valuenow="{{number_format((($file->forms+$file->fichier-$file->sub-$file->draft)/$file->forms)*100,2)}}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                    @endif
                @endforeach
                <!--end card-->

            </div>
            <!--end tasks-->
        </div>

    </div>
    <div class="tasks-list">
        <div class="d-flex mb-3">
            <div class="flex-grow-1">
                <h6 class="fs-14 text-uppercase fw-semibold mb-0">ENVOYES<small class="badge bg-success align-bottom ms-1 totaltask-badge">{{$count->env}}</small></h6>
            </div>
            <div class="flex-shrink-0">
                <div class="dropdown card-header-dropdown">

                </div>
            </div>
        </div>
       @if($count->env>0) <div data-simplebar class="tasks-wrapper mh-100 mx-n3 px-2">
            <div id="unassigned-task" class="tasks bg-white border rounded-4 px-2 py-4">@endif
                @foreach ($fiches as $file )
                @if ($file->type=="env")
                <div class="card tasks-box mx-2 border-success custom-border">
                    <div class="card-body">
                        <div class="d-flex mb-2">
                            <h6 class="fs-15 mb-0 flex-grow-1 text-truncate task-title text-primary text-decoration-underline fw-bold"><a href="{{'/soumission/'.$file->id."/".$act}}" class="">
                                {{$file->name}}
                            </a></h6>

                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-bold mb-0">({{$file->forms}} Formulaires Publiques)</h6>
                            <h6 class="text-muted fw-bold mb-0">({{$file->fichier}} Fichier)</h6>

                        </div>
                        <br>
                        <div class="mb-3">
                            <div class="d-flex mb-1">
                                <div class="flex-grow-1">
                                    <h6 class=" fw-bold mb-0">100% of 100%</h6>
                                </div>

                            </div>
                            <div class="progress rounded-3 progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
                @endif
        @endforeach

          @if($count->env>0)  </div>
        </div>@endif
    </div>
