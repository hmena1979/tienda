<div class="row">
    <div class="col-md-12">
        <table id= "grid" class="table table-hover table-sm">
            <thead>
                <tr>
                    <th width="22%">Producto</th>
                    <th width="18%">Código</th>
                    <th class="text-center" width="10%">Sobre Peso</th>
                    <th class="text-center" width="10%">Sacos</th>
                    <th class="text-center" width="10%">Blocks</th>
                    <th class="text-center" width="10%">Total Kg</th>
                    <th class="text-center" width="10%">Parcial %</th>
                    {{-- <th width="10%">
                        <button type="button" id='additem' class="btn btn-block btn-addventa" datatoggle="tooltip" data-placement="top" title="Agregar Item">
                            +
                        </button>
                    </th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($parte->detpartes as $det)
                <tr>
                    <td>{{ $det->dettrazabilidad->trazabilidad->nombre }}</td>
                    <td>{{ $det->dettrazabilidad->mpd_codigo }}</td>
                    <td class="text-center">{{ $det->sobrepeso }}</td>
                    <td class="text-center">{{ $det->sacos }}</td>
                    <td class="text-center">{{ $det->blocks }}</td>
                    <td class="text-center">{{ $det->total }}</td>
                    <td class="text-center">{{ $det->parcial }}</td>
                    {{-- <td>
                        @if ($envasado->estado == 1)
                        <div class="opts">
                            <button type="button" class="btn" title="Editar" onclick="edititem('{{ $det->id }}');">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn" title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        @endif
                    </td> --}}
                </tr>
                @endforeach
                <tr>
                    <td colspan="2"></td>
                    <th class="text-center">{{ number_format($parte->sobrepeso,2) }}</th>
                    <th class="text-center">{{ number_format($parte->sacos) }}</th>
                    <th class="text-center">{{ number_format($parte->blocks) }}</th>
                    <th class="text-center">{{ number_format($parte->envasado) }}</th>
                    <th class="text-center">{{ number_format($parte->detpartes->sum('parcial'),2) }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
{{-- <script>
    $('#additem').click(function(){
        $('#aeitem').show();
        $('#detalles').hide();
        $('#tipodet').val(1);
        $('#trazabilidad_id').focus();
    });
</script> --}}