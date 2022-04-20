<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-folder-open"></i> Modulo categorías
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="categorias" id="categorias" value="true" @if(kvfj($user->permissions, 'categorias')) checked @endif>
                <label for="categorias">Puede listar categorías.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="categoria_add" id="categoria_add" value="true" @if(kvfj($user->permissions, 'categoria_add')) checked @endif>
                <label for="categoria_add">Puede agregar categorías.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="categoria_edit" id="categoria_edit" value="true" @if(kvfj($user->permissions, 'categoria_edit')) checked @endif>
                <label for="categoria_edit">Puede editar categorías.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="categoria_delete" id="categoria_delete" value="true" @if(kvfj($user->permissions, 'categoria_delete')) checked @endif>
                <label for="categoria_delete">Puede eliminar categorías.</label>
            </div>
        </div>
    </div>
</div>