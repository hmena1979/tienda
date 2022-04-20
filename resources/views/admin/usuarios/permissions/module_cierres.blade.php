<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-calendar-check"></i> Modulo cierre de mes
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="cierre" id="cierre" value="true" @if(kvfj($user->permissions, 'cierre')) checked @endif>
                <label for="cierre">Cierre de mes.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="cadmision" id="cadmision" value="true" @if(kvfj($user->permissions, 'cadmision')) checked @endif>
                <label for="cadmision">Cierre periodo admisión.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="cfarmacia" id="cfarmacia" value="true" @if(kvfj($user->permissions, 'cfarmacia')) checked @endif>
                <label for="cfarmacia">Cierre periodo farmacia.</label>
            </div>
        </div>
    </div>
</div>