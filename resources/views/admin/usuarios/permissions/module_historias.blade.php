<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-book-medical"></i> Modulo Historias
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="historias" id="historias" value="true" @if(kvfj($user->permissions, 'historias')) checked @endif>
                <label for="historias">Puede ver historias.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="historia_triage" id="historia_triage" value="true" @if(kvfj($user->permissions, 'historia_triage')) checked @endif>
                <label for="historia_triage">Puede realizar triajes.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="historia_add" id="historia_add" value="true" @if(kvfj($user->permissions, 'historia_add')) checked @endif>
                <label for="historia_add">Puede agregar historia.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="historia_edit" id="historia_edit" value="true" @if(kvfj($user->permissions, 'historia_edit')) checked @endif>
                <label for="historia_edit">Puede editar historia.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="historia_plan" id="historia_plan" value="true" @if(kvfj($user->permissions, 'historia_plan')) checked @endif>
                <label for="historia_plan">Puede editar antecedentes.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="historia_diagnosis" id="historia_diagnosis" value="true" @if(kvfj($user->permissions, 'historia_diagnosis')) checked @endif>
                <label for="historia_diagnosis">Puede ingresar diagnóstico.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="historia_cita" id="historia_cita" value="true" @if(kvfj($user->permissions, 'historia_cita')) checked @endif>
                <label for="historia_cita">Puede programar citas.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="historia_prescription" id="historia_prescription" value="true" @if(kvfj($user->permissions, 'historia_prescription')) checked @endif>
                <label for="historia_prescription">Puede ingresar recetas.</label>
            </div>
        </div>
    </div>
</div>