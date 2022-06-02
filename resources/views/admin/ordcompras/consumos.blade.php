{{-- {{ dd($resultado) }} --}}
<table id='detmasivo' class='table table-responsive-md table-hover table-bordered table-estrecha-ocompra'>
    <thead>
        <tr class="colorprin negrita">
            <th>MES</th>
            <th>CONSUMO</th>
        </tr>
    </thead>
    <tbody>
        @foreach($resultado as $det => $valor)
        <tr>
            <td>{{ $det }}</td>
            <td class="text-right">{{ number_format($valor,2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>