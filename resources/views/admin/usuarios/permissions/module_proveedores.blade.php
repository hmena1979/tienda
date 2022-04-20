<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-address-card"></i> Modulo proveedores
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="proveedores" id="proveedores" value="true" @if(kvfj($user->permissions, 'proveedores')) checked @endif>
                <label for="proveedores">Puede listar proveedores.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="proveedor_add" id="proveedor_add" value="true" @if(kvfj($user->permissions, 'proveedor_add')) checked @endif>
                <label for="proveedor_add">Puede agregar proveedores.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="proveedor_edit" id="proveedor_edit" value="true" @if(kvfj($user->permissions, 'proveedor_edit')) checked @endif>
                <label for="proveedor_edit">Puede editar proveedores.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="proveedor_delete" id="proveedor_delete" value="true" @if(kvfj($user->permissions, 'proveedor_delete')) checked @endif>
                <label for="proveedor_delete">Puede eliminar proveedores.</label>
            </div>
        </div>
    </div>
</div>