<div class="opts">
    @can('admin.clientes.edit')
    <a href="{{ route('admin.clientes.edit', $id) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
    @endcan
    @can('admin.clientes.destroy')
    <form action="{{ route('admin.clientes.destroy',$id) }}" method="POST" class="formulario_eliminars">
        @csrf
        @method('delete')
        <button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
    @endcan
</div>

<script>
    $('.formulario_eliminars').submit(function(e){
        e.preventDefault();
        
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
            this.submit();
        }
        })
    });
</script>