<div class="row">
    <div class="col-md-12">
        <table id= "grid" class="table table-hover table-sm">
            <thead>
                <tr>
                    <th width="30%">Lote</th>
                    <th class="text-center" width="10%">Cantidad</th>
                    <th class="text-center" width="10%">Peso</th>
                    <th class="text-center" width="10%">Total</th>
                    <th width="10%">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($detsalcamara->detdetsalcamaras as $det)
                <tr>
                    <td>{{ $det->lote }}</td>
                    <td class="text-center">{{ number_format($det->cantidad) }}</td>
                    <td class="text-center">{{ $det->peso }}</td>
                    <td class="text-center">{{ number_format($det->cantidad * $det->peso) }}</td>
                    <td>
                        {{-- @if ($ingcamara->estado == 1) --}}
                        <div class="opts">
                            {{-- <button type="button" class="btn" title="Editar" onclick="edititem('{{ $det->id }}');">
                                <i class="fas fa-edit"></i>
                            </button> --}}
                            <button type="button" class="btn" title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        {{-- @endif --}}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <th class="text-center">
                        @if ($detsalcamara->detdetsalcamaras->sum('cantidad'))
                        {{ number_format($detsalcamara->detdetsalcamaras->sum('cantidad')) }}
                        @endif
                    </th>
                    <td></td>
                    <th class="text-center">
                        @if ($detsalcamara->detdetsalcamaras->sum('cantidad'))
                        {{ number_format($detsalcamara->detdetsalcamaras->sum('cantidad')*20) }}
                        @endif
                    </th>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center colorprin">TOTAL SACOS</th>
                    <th class="text-center colorprin">TOTAL KILOGRAMOS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="text-center colorprin">
                        @if ($detsalcamara->salcamara->sacos)
                        {{ number_format($detsalcamara->salcamara->sacos) }}                            
                        @endif
                    </th>
                    <th class="text-center colorprin">
                        @if ($detsalcamara->salcamara->pesoneto)
                        {{ number_format($detsalcamara->salcamara->pesoneto) }}                            
                        @endif
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    // $('#additem').click(function(){
    //     $('#aeitem').show();
    //     $('#detalles').hide();
    //     $('#tipodet').val(1);
    //     $('#trazabilidad_id').focus();
    // });
</script>