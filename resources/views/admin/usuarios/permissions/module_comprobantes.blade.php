<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-list-alt"></i> Modulo tipo de comprobantes
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="comprobantes" id="comprobantes" value="true" @if(kvfj($user->permissions, 'comprobantes')) checked @endif>
                <label for="comprobantes">Puede listar comprobantes.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="comprobante_add" id="comprobante_add" value="true" @if(kvfj($user->permissions, 'comprobante_add')) checked @endif>
                <label for="comprobante_add">Puede agregar comprobantes.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="comprobante_edit" id="comprobante_edit" value="true" @if(kvfj($user->permissions, 'comprobante_edit')) checked @endif>
                <label for="comprobante_edit">Puede editar comprobantes.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="comprobante_delete" id="comprobante_delete" value="true" @if(kvfj($user->permissions, 'comprobante_delete')) checked @endif>
                <label for="comprobante_delete">Puede eliminar comprobantes.</label>
            </div>
        </div>
    </div>
</div>