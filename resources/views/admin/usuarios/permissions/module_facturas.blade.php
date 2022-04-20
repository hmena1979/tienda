<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-money-check-alt"></i> Modulo facturación admisión
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="facturas" id="facturas" value="true" @if(kvfj($user->permissions, 'facturas')) checked @endif>
                <label for="facturas">Puede listar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="factura_add" id="factura_add" value="true" @if(kvfj($user->permissions, 'factura_add')) checked @endif>
                <label for="factura_add">Puede agregar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="factura_edit" id="factura_edit" value="true" @if(kvfj($user->permissions, 'factura_edit')) checked @endif>
                <label for="factura_edit">Puede editar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="factura_delete" id="factura_delete" value="true" @if(kvfj($user->permissions, 'factura_delete')) checked @endif>
                <label for="factura_delete">Puede eliminar documentos.</label>
            </div>
        </div>
    </div>
</div>