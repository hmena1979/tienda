<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="headercontent">
            <h2 class="title">
                <i class="fas fa-user-friends"></i> Modulo usuarios
            </h2>
        </div>
        <div class="inside">
            <div class="form-check">
                <input type="checkbox" name="usuarios" id="usuarios" value="true" @if(kvfj($user->permissions, 'usuarios')) checked @endif>
                <label for="usuarios">Puede listar usuarios.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="usuario_add" id="usuario_add" value="true" @if(kvfj($user->permissions, 'usuario_add')) checked @endif>
                <label for="usuario_add">Puede agregar usuarios.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="usuario_edit" id="usuario_edit" value="true" @if(kvfj($user->permissions, 'usuario_edit')) checked @endif>
                <label for="usuario_edit">Puede editar usuarios.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="usuario_password" id="usuario_password" value="true" @if(kvfj($user->permissions, 'usuario_password')) checked @endif>
                <label for="usuario_password">Puede cambiar password.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="usuario_permissions" id="usuario_permissions" value="true" @if(kvfj($user->permissions, 'usuario_permissions')) checked @endif>
                <label for="usuario_permissions">Asignar permisos de usuario.</label>
            </div>
            
        </div>
    </div>
</div>