<table id='detmasivo' class='table table-responsive-md table-hover table-bordered table-estrecha-ventas table-sb'>
    <thead>
        <tr class="colorprin negrita">
            <th width="30%">Banco</th>
            <th width="10%">Moneda</th>
            <th width="10%">Tipo</th>
            <th width="20%">Cuenta</th>
            <th width="20%">CCI</th>
            <th width="10%">
                <button type="button" class="btn btn-block btn-addventa" title="Agregar Cuenta" onclick="additem();">
                    +
                </button>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($cliente->detclientes as $det)
        <tr>
            <td>{{ $det->banco->nombre }}</td>
            <td>{{ $det->moneda}}</td>
            <td>{{ $tipos[$det->tipo]}}</td>
            <td>{{ $det->cuenta}}</td>
            <td>{{ $det->cci}}</td>
            <td class="text-center align-middle">
                <div class='opts'>
                    @can('admin.clientes.cuenta')
                    <button type="button" class="btn" title="Editar" onclick="edititem('{{ $det->id }}');">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn" title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    @endcan
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
function destroyitem(id){
    Swal.fire({
        title: 'Está Seguro de Eliminar el Registro?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, eliminar!',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
        if (result.value) {
            $.get(url_global+"/admin/clientes/"+id+"/destroyitem/",function(response){
                location.reload();
                Swal.fire({
                    icon:'success',
                    title:'Eliminado',
                    text:'Registro Eliminado'
                });
            });
            
        }
        })
}

</script>