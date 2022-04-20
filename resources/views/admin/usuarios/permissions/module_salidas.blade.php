<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-cart-arrow-down"></i> Modulo ventas/consumo
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="salidas" id="salidas" value="true" @if(kvfj($user->permissions, 'salidas')) checked @endif>
                <label for="salidas">Puede listar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="salida_add" id="salida_add" value="true" @if(kvfj($user->permissions, 'salida_add')) checked @endif>
                <label for="salida_add">Puede agregar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="salida_edit" id="salida_edit" value="true" @if(kvfj($user->permissions, 'salida_edit')) checked @endif>
                <label for="salida_edit">Puede editar documentos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="salida_delete" id="salida_delete" value="true" @if(kvfj($user->permissions, 'salida_delete')) checked @endif>
                <label for="salida_delete">Puede eliminar documentos.</label>
            </div>
        </div>
    </div>
</div>