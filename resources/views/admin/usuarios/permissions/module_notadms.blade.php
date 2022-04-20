<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-money-check-alt"></i> Modulo ND/NC admisión
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="notadms" id="notadms" value="true" @if(kvfj($user->permissions, 'notadms')) checked @endif>
                <label for="notadms">Puede listar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="notadm_add" id="notadm_add" value="true" @if(kvfj($user->permissions, 'notadm_add')) checked @endif>
                <label for="notadm_add">Puede agregar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="notadm_edit" id="notadm_edit" value="true" @if(kvfj($user->permissions, 'notadm_edit')) checked @endif>
                <label for="notadm_edit">Puede editar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="notadm_delete" id="notadm_delete" value="true" @if(kvfj($user->permissions, 'notadm_delete')) checked @endif>
                <label for="notadm_delete">Puede eliminar documentos.</label>
            </div>
        </div>
    </div>
</div>