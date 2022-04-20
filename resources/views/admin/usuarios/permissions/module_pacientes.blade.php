<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-chalkboard-teacher"></i> Modulo pacientes
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="pacientes" id="pacientes" value="true" @if(kvfj($user->permissions, 'pacientes')) checked @endif>
                <label for="pacientes">Puede listar pacientes.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="paciente_add" id="paciente_add" value="true" @if(kvfj($user->permissions, 'paciente_add')) checked @endif>
                <label for="paciente_add">Puede agregar pacientes.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="paciente_edit" id="paciente_edit" value="true" @if(kvfj($user->permissions, 'paciente_edit')) checked @endif>
                <label for="paciente_edit">Puede editar pacientes.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="paciente_history" id="paciente_history" value="true" @if(kvfj($user->permissions, 'paciente_history')) checked @endif>
                <label for="paciente_history">Puede ingresar historia.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="paciente_triage" id="paciente_triage" value="true" @if(kvfj($user->permissions, 'paciente_triage')) checked @endif>
                <label for="paciente_triage">Puede ingresar triaje.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="paciente_delete" id="paciente_delete" value="true" @if(kvfj($user->permissions, 'paciente_delete')) checked @endif>
                <label for="paciente_delete">Puede eliminar pacientes.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="paciente_appointment" id="paciente_appointment" value="true" @if(kvfj($user->permissions, 'paciente_appointment')) checked @endif>
                <label for="paciente_appointment">Puede programar citas.</label>
            </div>
        </div>
    </div>
</div>