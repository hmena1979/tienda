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
                    <th class="text-center" width="20%">Observaciones</th>
                    {{-- <th width="10%">
                        <button type="button" id='additem' class="btn btn-block btn-addventa" datatoggle="tooltip" data-placement="top" title="Agregar Item">
                            +
                        </button>
                    </th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($parte->detpartecamaras as $det)
                <tr>
                    <td>{{ $det->dettrazabilidad->trazabilidad->nombre }}</td>
                    <td>{{ $det->dettrazabilidad->mpd_codigo }}</td>
                    <td class="text-center">{{ $det->sobrepeso }}</td>
                    <td class="text-center">{{ $det->sacos }}</td>
                    <td class="text-center">{{ $det->blocks }}</td>
                    <td class="text-center">{{ $det->total }}</td>
                    <td class="text-center">{{ $det->observaciones }}</td>
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
                    <th class="text-center">{{ number_format($parte->detpartecamaras->sum('sobrepeso'),2) }}</th>
                    <th class="text-center">{{ number_format($parte->detpartecamaras->sum('sacos')) }}</th>
                    <th class="text-center">{{ number_format($parte->detpartecamaras->sum('blocks')) }}</th>
                    <th class="text-center">{{ number_format($parte->detpartecamaras->sum('total')) }}</th>
                    <th class="text-center"></th>
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