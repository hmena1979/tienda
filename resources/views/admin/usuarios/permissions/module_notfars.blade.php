<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-money-check-alt"></i> Modulo ND/NC farmacia
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="notfars" id="notfars" value="true" @if(kvfj($user->permissions, 'notfars')) checked @endif>
                <label for="notfars">Puede listar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="notfar_add" id="notfar_add" value="true" @if(kvfj($user->permissions, 'notfar_add')) checked @endif>
                <label for="notfar_add">Puede agregar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="notfar_edit" id="notfar_edit" value="true" @if(kvfj($user->permissions, 'notfar_edit')) checked @endif>
                <label for="notfar_edit">Puede editar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="notfar_delete" id="notfar_delete" value="true" @if(kvfj($user->permissions, 'notfar_delete')) checked @endif>
                <label for="notfar_delete">Puede eliminar documentos.</label>
            </div>
        </div>
    </div>
</div>