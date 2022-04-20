<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-tablets"></i> Modulo tipo medicamento
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="tipmeds" id="tipmeds" value="true" @if(kvfj($user->permissions, 'tipmeds')) checked @endif>
                <label for="tipmeds">Puede listar tipo medicamento.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="tipmed_add" id="tipmed_add" value="true" @if(kvfj($user->permissions, 'tipmed_add')) checked @endif>
                <label for="tipmed_add">Puede agregar tipo medicamento.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="tipmed_edit" id="tipmed_edit" value="true" @if(kvfj($user->permissions, 'tipmed_edit')) checked @endif>
                <label for="tipmed_edit">Puede editar tipo medicamento.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="tipmed_delete" id="tipmed_delete" value="true" @if(kvfj($user->permissions, 'tipmed_delete')) checked @endif>
                <label for="tipmed_delete">Puede eliminar tipo medicamento.</label>
            </div>
        </div>
    </div>
</div>