<table class="table align-middle table-nowrap" id="customerTable">
    <thead class="table-light">
        <tr>

            <th class="sort" data-sort="customer_name">Utilisateur</th>
            <th class="sort" data-sort="email">Email</th>
            <th class="sort" data-sort="phone">Rôle</th>
           
            <th class="sort" data-sort="action">Action</th>
        </tr>
    </thead>
    <tbody class="list form-check-all">
    @foreach($admins as $user)
        <tr>
 
            <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ2101</a></td>
            <td class="customer_name">{{$user->name}}</td>
            <td class="email">{{$user->email}}</td>
            <td class="phone">
                {{$user->roleName}}
            </td>
           
            <td>
                <div class="d-flex gap-2">
                    <div class="edit">
                        <button class="btn btn-sm btn-primary edit-item-btn" onclick="userUpdate({{json_encode($user)}})" data-bs-toggle="modal" data-bs-target="#showModal">Modifier</button>
                    </div>
                    <div class="remove">
                        <button class="btn btn-sm btn-success remove-item-btn" onclick="userDelete({{$user->id}})" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Supprimer</button>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-end">
    <div class="pagination-wrap hstack gap-2">
        {{$admins->appends(['name' => request('name')])->links()}}
    </div>
</div>
