<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-book-medical"></i> Modulo CIE10
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="cie10" id="cie10" value="true" @if(kvfj($user->permissions, 'cie10')) checked @endif>
                <label for="cie10">Puede listar CIE 10.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="cie10_add" id="cie10_add" value="true" @if(kvfj($user->permissions, 'cie10_add')) checked @endif>
                <label for="cie10_add">Puede agregar CIE 10.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="cie10_edit" id="cie10_edit" value="true" @if(kvfj($user->permissions, 'cie10_edit')) checked @endif>
                <label for="cie10_edit">Puede editar CIE 10.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="cie10_delete" id="cie10_delete" value="true" @if(kvfj($user->permissions, 'cie10_delete')) checked @endif>
                <label for="cie10_delete">Puede eliminar CIE 10.</label>
            </div>
        </div>
    </div>
</div>