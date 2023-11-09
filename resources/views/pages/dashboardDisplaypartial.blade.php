<div class="row my-3 mx-3 " >
    @foreach($dashboard as $dash)
    <div class="col-md-6 border">
        <div class="input-group my-2">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon3">Name :</span>
            </div>
            <input type="text" class="form-control" id="basic-url" value="{{$dash->name}}" aria-describedby="basic-addon3" disabled>
            <button class="btn btn-icon btn-secondary opacity-75" onclick="toggleFullScreen('{{$dash->id}}')"><i class="bx bx-fullscreen fs-22"></i></button>

        </div>

        <div class="embed-responsive embed-responsive-1by1 my-1" >
            <iframe style="width: 100%; height:100%" class="embed-responsive-item" id="{{$dash->id}}" src="{{ $dash->lien }}" frameborder="1" allowFullScreen="true"></iframe>
        </div>
    </div>
    @endforeach
<div class="d-flex justify-content-end">
    <div class="pagination-wrap hstack gap-2">
        {{$dashboard->appends(['name' => request('name')])->links()}}
    </div>
</div>
