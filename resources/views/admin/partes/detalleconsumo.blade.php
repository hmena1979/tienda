<div class="row">
    <div class="col-md-12">
        <table id= "grid" class="table table-hover table-sm">
            <thead>
                <tr>
                    <th width="30%">Producto</th>
                    <th width="10%">U.Medida</th>
                    <th class="text-center" width="10%">Solicitado</th>
                    <th class="text-center" width="10%">Devuelto</th>
                    <th class="text-center" width="10%">Entregado</th>
                    @can('admin.partes.valorado')
                    <th class="text-center" width="10%">Precio</th>
                    <th class="text-center" width="10%">Total</th>
                    @endcan
                    {{-- <th width="10%">
                        <button type="button" id='additem' class="btn btn-block btn-addventa" datatoggle="tooltip" data-placement="top" title="Agregar Item">
                            +
                        </button>
                    </th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($parte->detparteproductos as $det)
                <tr>
                    <td>{{ $det->producto->nombre }}</td>
                    <td>{{ $det->producto->umedida->nombre }}</td>
                    <td class="text-center">{{ $det->solicitado }}</td>
                    <td class="text-center">{{ $det->devuelto }}</td>
                    <td class="text-center">{{ $det->entregado }}</td>
                    @can('admin.partes.valorado')
                    <td class="text-center">{{ $det->precio }}</td>
                    <td class="text-center">{{ $det->total }}</td>
                    @endcan
                </tr>
                @endforeach
                {{-- <tr>
                    <td colspan="2"></td>
                    <th class="text-center">{{ number_format($parte->detpartecamaras->sum('sobrepeso'),2) }}</th>
                    <th class="text-center">{{ number_format($parte->detpartecamaras->sum('sacos')) }}</th>
                    <th class="text-center">{{ number_format($parte->detpartecamaras->sum('blocks')) }}</th>
                    <th class="text-center">{{ number_format($parte->detpartecamaras->sum('total')) }}</th>
                    <th class="text-center">{{ number_format($parte->detpartecamaras->sum('parcial'),2) }}</th>
                </tr> --}}
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