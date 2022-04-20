<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-ruler-combined"></i> Modulo productos
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="productos" id="productos" value="true" @if(kvfj($user->permissions, 'productos')) checked @endif>
                <label for="productos">Puede listar productos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="producto_add" id="producto_add" value="true" @if(kvfj($user->permissions, 'producto_add')) checked @endif>
                <label for="producto_add">Puede agregar productos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="producto_edit" id="producto_edit" value="true" @if(kvfj($user->permissions, 'producto_edit')) checked @endif>
                <label for="producto_edit">Puede editar productos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="producto_price" id="producto_price" value="true" @if(kvfj($user->permissions, 'producto_price')) checked @endif>
                <label for="producto_price">Puede editar precios.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="producto_delete" id="producto_delete" value="true" @if(kvfj($user->permissions, 'producto_delete')) checked @endif>
                <label for="producto_delete">Puede eliminar productos.</label>
            </div>
        </div>
    </div>
</div>