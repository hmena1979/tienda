<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-home"></i> Modulo inicio
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="dashboard" id="dashboard" value="true" @if(kvfj($user->permissions, 'dashboard')) checked @endif>
                <label for="dashboard">Puede ver el inicio.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="parametros" id="parametros" value="true" @if(kvfj($user->permissions, 'parametros')) checked @endif>
                <label for="parametros">Puede cambiar parámetros.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="report" id="report" value="true" @if(kvfj($user->permissions, 'report')) checked @endif>
                <label for="report">Puede ver reportes.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="import" id="import" value="true" @if(kvfj($user->permissions, 'import')) checked @endif>
                <label for="import">Puede importar archivos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="sunat" id="sunat" value="true" @if(kvfj($user->permissions, 'sunat')) checked @endif>
                <label for="sunat">Operaciones SUNAT.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="saldos" id="saldos" value="true" @if(kvfj($user->permissions, 'saldos')) checked @endif>
                <label for="saldos">Regenerar saldos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="vencimientos" id="vencimientos" value="true" @if(kvfj($user->permissions, 'vencimientos')) checked @endif>
                <label for="vencimientos">Vencimento de Productos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="web" id="web" value="true" @if(kvfj($user->permissions, 'web')) checked @endif>
                <label for="web">Web.</label>
            </div>
            
        </div>
    </div>
</div>