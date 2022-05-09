<table id= "gridcamara" class="table table-hover table-sm">
    <thead>
        <tr>
            <th width="25%">Marca</th>
            <th width="20%">Placa</th>
            <th width="40%">Protocolo</th>
            <th width="15%"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($transportista->camaras as $det)
        <tr>
            <td>{{ $det->marca }}</td>
            <td>{{ $det->placa }}</td>
            <td>{{ $det->protocolo }}</td>
            <td>
                <div class="opts">
                    <button type="button" class="btn" title="Editar" onclick="edititemcamara('{{ $det->id }}');">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn" title="Eliminar" onclick="destroyitemcamara('{{ $det->id }}');">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    {{-- <a class="" href="{{ route('admin.destinos.edit',$destino) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a> --}}
                    {{-- <form action="{{ route('admin.destinos.destroy',$destino) }}" method="POST" class="formulario_eliminars">
                        @csrf
                        @method('delete')
                        <button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form> --}}
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
</table>
<script>
    $('#gridcamara').DataTable({
        "paging":   true,
        "ordering": true,
        "info":     true,
        "language":{
            "info": "_TOTAL_ Registros",
            "search": "Buscar",
            "paginate":{
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "lengthMenu": "Mostrar <select>"+
                            "<option value='10'>10</option>"+
                            "<option value='25'>25</option>"+
                            "<option value='50'>50</option>"+
                            "<option value='100'>100</option>"+
                            "<option value='-1'>Todos</option>"+
                            "</select> Registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "emptyTable": "No se encontraton coincidencias",
            "zeroRecords": "No se encontraton coincidencias",
            "infoEmpty": "",
            "infoFiltered": ""
        }
    });
</script>