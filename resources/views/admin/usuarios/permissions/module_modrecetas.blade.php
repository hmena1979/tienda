<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-prescription"></i> Modulo Modelo receta
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="modrecetas" id="modrecetas" value="true" @if(kvfj($user->permissions, 'modrecetas')) checked @endif>
                <label for="modrecetas">Puede listar recetas.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="modreceta_add" id="modreceta_add" value="true" @if(kvfj($user->permissions, 'modreceta_add')) checked @endif>
                <label for="modreceta_add">Puede agregar recetas.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="modreceta_edit" id="modreceta_edit" value="true" @if(kvfj($user->permissions, 'modreceta_edit')) checked @endif>
                <label for="modreceta_edit">Puede editar recetas.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="modreceta_delete" id="modreceta_delete" value="true" @if(kvfj($user->permissions, 'modreceta_delete')) checked @endif>
                <label for="modreceta_delete">Puede eliminar recetas.</label>
            </div>
        </div>
    </div>
</div>