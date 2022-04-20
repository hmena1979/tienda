<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-procedures"></i> Modulo terapias
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="terapias" id="terapias" value="true" @if(kvfj($user->permissions, 'terapias')) checked @endif>
                <label for="terapias">Puede listar terapias.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="terapia_add" id="terapia_add" value="true" @if(kvfj($user->permissions, 'terapia_add')) checked @endif>
                <label for="terapia_add">Puede agregar terapias.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="terapia_edit" id="terapia_edit" value="true" @if(kvfj($user->permissions, 'terapia_edit')) checked @endif>
                <label for="terapia_edit">Puede editar terapias.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="terapia_delete" id="terapia_delete" value="true" @if(kvfj($user->permissions, 'terapia_delete')) checked @endif>
                <label for="terapia_delete">Puede eliminar terapias.</label>
            </div>
        </div>
    </div>
</div>