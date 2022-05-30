<div class="row">
    <div class="col-md-12">
        <table id= "grid" class="table table-hover table-sm">
            <thead>
                <tr>
                    <th width="28%">Destino</th>
                    <th width="28%">Detalle</th>
                    {{-- <th width="29%">C.Costo</th> --}}
                    <th width="10%">Monto</th>
                    <th width="5%">
                        <button type="button" id='additem' class="btn btn-block btn-addventa" datatoggle="tooltip" data-placement="top" title="Agregar Item">
                            +
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($rcompra->detrcompras as $det)
                <tr>
                    <td>{{ $det->detdestino->destino->nombre }}</td>
                    <td>{{ $det->detdestino->nombre }}</td>
                    {{-- <td>{{ $det->ccosto->nombre }}</td> --}}
                    <td>{{ $det->monto }}</td>
                    <td>
                        <div class="opts">
                            <button type="button" class="btn" title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-8"></div>
    <div class="col-md-4">
        <table class="table table-hover table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center" width="50%">COMPROBANTE</th>
                    <th class="text-center" width="50%">DESTINO</th>
                </tr>
            </thead>
            <tbody>
                <td class="text-center">{{ number_format($rcompra->total,2) }}</td>
                <td class="text-center">{{ number_format($rcompra->detrcompras->sum('monto'), 2)}}</td>
            </tbody>
        </table>
    </div>
</div>
<script>
    $('#additem').click(function(){
        $('#adddetalle').show();
        $('#destino_id').select2({
            placeholder:"DESTINO"
        });
        $('#detdestino_id').val(null);
        $('#detdestino_id').select2({
            placeholder:"DETALLE"
        });        
        $('#ccosto_id').select2({
            placeholder:"CENTRO DE COSTO"
        });
    });
</script>