<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-ruler-combined"></i> Modulo Laboratorios
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="laboratorios" id="laboratorios" value="true" @if(kvfj($user->permissions, 'laboratorios')) checked @endif>
                <label for="laboratorios">Puede listar unidad medida.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="laboratorio_add" id="laboratorio_add" value="true" @if(kvfj($user->permissions, 'laboratorio_add')) checked @endif>
                <label for="laboratorio_add">Puede agregar unidad medida.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="laboratorio_edit" id="laboratorio_edit" value="true" @if(kvfj($user->permissions, 'laboratorio_edit')) checked @endif>
                <label for="laboratorio_edit">Puede editar unidad medida.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="laboratorio_delete" id="laboratorio_delete" value="true" @if(kvfj($user->permissions, 'laboratorio_delete')) checked @endif>
                <label for="laboratorio_delete">Puede eliminar unidad medida.</label>
            </div>
        </div>
    </div>
</div>