{{-- {{ dd($resultado) }} --}}
<table id='detmasivo' class='table table-responsive-md table-hover table-bordered table-estrecha-ocompra'>
    <thead>
        <tr class="colorprin negrita">
            <th>FECHA</th>
            <th>PROVEEDOR</th>
            <th>MONEDA</th>
            <th>COMPROBANTE</th>
            <th>CANTIDAD</th>
            <th>PRECIO</th>
        </tr>
    </thead>
    <tbody>
        @foreach($compras as $det)
        <tr>
            <td>{{ $det->rcompra->fechaingreso }}</td>
            <td>{{ $det->rcompra->cliente->razsoc }}</td>
            <td>{{ $det->rcompra->moneda }}</td>
            <td>{{ $det->rcompra->serie_numero }}</td>
            <td>{{ number_format($det->cantidad,2) }}</td>
            <td>{{ number_format($det->precio,2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>