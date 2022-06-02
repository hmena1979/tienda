{{-- {{ dd($resultado) }} --}}
<table id='detmasivo' class='table table-responsive-md table-hover table-bordered table-estrecha-ocompra'>
    <thead>
        <tr class="colorprin negrita">
            <th>FECHA</th>
            <th>PROVEEDOR</th>
            <th>MONEDA</th>
            <th>NÚMERO</th>
            <th>CANTIDAD</th>
            <th>PRECIO</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($cotizaciones as $det)
        <tr>
            <td>{{ $det->cotizacion->fecha }}</td>
            <td>{{ $det->cotizacion->cliente->razsoc }}</td>
            <td>{{ $det->cotizacion->moneda }}</td>
            <td>{{ $det->cotizacion->numero }}</td>
            <td>{{ number_format($det->cantidad,2) }}</td>
            <td>{{ number_format($det->precio,2) }}</td>
            <td>
                @if ($det->cotizacion->file)
                <div class="opts">
                    <a href="{{ url('/cotizaciones/'.$det->cotizacion->file) }}" class="" target="_blank" datatoggle="tooltip" data-placement="top" title="Visualizar documento">
                        <i class="far fa-file-pdf"></i>
                    </a>
                    <a href="{{ route('admin.ordcompras.genoc',$det->id) }}" class="" target="_blank" datatoggle="tooltip" data-placement="top" title="Generar Orden de Compra">
                        <i class="fas fa-file-import"></i>
                    </a>
                </div>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>