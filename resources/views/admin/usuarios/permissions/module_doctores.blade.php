<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-chalkboard-teacher"></i> Modulo doctores
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="doctores" id="doctores" value="true" @if(kvfj($user->permissions, 'doctores')) checked @endif>
                <label for="doctores">Puede listar doctores.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="doctor_add" id="doctor_add" value="true" @if(kvfj($user->permissions, 'doctor_add')) checked @endif>
                <label for="doctor_add">Puede agregar doctores.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="doctor_edit" id="doctor_edit" value="true" @if(kvfj($user->permissions, 'doctor_edit')) checked @endif>
                <label for="doctor_edit">Puede editar doctores.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="doctor_delete" id="doctor_delete" value="true" @if(kvfj($user->permissions, 'doctor_delete')) checked @endif>
                <label for="doctor_delete">Puede eliminar doctores.</label>
            </div>
        </div>
    </div>
</div>