<table id= "grid" class="table table-hover table-sm">
    <thead>
        <tr>
            <th width="30%">Proveedor</th>
            <th width="10%">Fecha</th>
            <th width="5%">TD</th>
            <th width="10%">Número</th>
            <th width="10%">Moneda</th>
            <th width="10%">Monto</th>
            <th width="10%"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($rcompras as $det)
        <tr>
            <td>{{ $det->cliente->razsoc }}</td>
            <td>{{ $det->vencimiento }}</td>
            <td>{{ $det->tipocomprobante_codigo }}</td>
            <td>{{ numDoc($det->serie, $det->numero)}}</td>
            <td>{{ $det->moneda }}</td>
            <td>{{ $det->saldo }}</td>
            <td>
                <div class="opts">
                    {{-- <button type="button" class="btn" title="Editar" onclick="edititem('{{ $det->id }}');">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn" title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                        <i class="fas fa-trash-alt"></i>
                    </button> --}}
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
</table>
<script>
    $('#grid').DataTable({
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