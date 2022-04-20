<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-ruler-combined"></i> Modulo unidad medida
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="umedidas" id="umedidas" value="true" @if(kvfj($user->permissions, 'umedidas')) checked @endif>
                <label for="umedidas">Puede listar unidad medida.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="umedida_add" id="umedida_add" value="true" @if(kvfj($user->permissions, 'umedida_add')) checked @endif>
                <label for="umedida_add">Puede agregar unidad medida.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="umedida_edit" id="umedida_edit" value="true" @if(kvfj($user->permissions, 'umedida_edit')) checked @endif>
                <label for="umedida_edit">Puede editar unidad medida.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="umedida_delete" id="umedida_delete" value="true" @if(kvfj($user->permissions, 'umedida_delete')) checked @endif>
                <label for="umedida_delete">Puede eliminar unidad medida.</label>
            </div>
        </div>
    </div>
</div>