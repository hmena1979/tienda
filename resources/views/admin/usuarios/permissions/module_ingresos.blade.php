<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-cart-plus"></i> Modulo compras
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="ingresos" id="ingresos" value="true" @if(kvfj($user->permissions, 'ingresos')) checked @endif>
                <label for="ingresos">Puede listar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="ingreso_add" id="ingreso_add" value="true" @if(kvfj($user->permissions, 'ingreso_add')) checked @endif>
                <label for="ingreso_add">Puede agregar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="ingreso_edit" id="ingreso_edit" value="true" @if(kvfj($user->permissions, 'ingreso_edit')) checked @endif>
                <label for="ingreso_edit">Puede editar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="ingreso_delete" id="ingreso_delete" value="true" @if(kvfj($user->permissions, 'ingreso_delete')) checked @endif>
                <label for="ingreso_delete">Puede eliminar documentos.</label>
            </div>
        </div>
    </div>
</div>