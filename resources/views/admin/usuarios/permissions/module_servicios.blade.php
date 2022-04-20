<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-hand-holding-medical"></i> Modulo servicios
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="servicios" id="servicios" value="true" @if(kvfj($user->permissions, 'servicios')) checked @endif>
                <label for="servicios">Puede listar servicios.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="servicio_add" id="servicio_add" value="true" @if(kvfj($user->permissions, 'servicio_add')) checked @endif>
                <label for="servicio_add">Puede agregar servicios.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="servicio_edit" id="servicio_edit" value="true" @if(kvfj($user->permissions, 'servicio_edit')) checked @endif>
                <label for="servicio_edit">Puede editar servicios.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="servicio_delete" id="servicio_delete" value="true" @if(kvfj($user->permissions, 'servicio_delete')) checked @endif>
                <label for="servicio_delete">Puede eliminar servicios.</label>
            </div>
        </div>
    </div>
</div>