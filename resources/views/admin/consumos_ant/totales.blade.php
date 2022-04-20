<table class="table table-responsive-md table-hover table-bordered table-estrecha table-sb">
    <thead>
        <tr>
            <th class="text-center" width = '12%'>GRAVADO</th>
            <th class="text-center" width = '12%'>EXONERADO</th>
            <th class="text-center" width = '12%'>INAFECTO</th>
            <th class="text-center" width = '12%'>EXPORTACIÓN</th>
            <th class="text-center" width = '12%'>GRATUITO</th>
            <th class="text-center" width = '12%'>IGV</th>
            <th class="text-center" width = '12%'>ICBPER</th>
            <th class="text-center btn-convertir" width = '16%'>
                TOTAL {{ $rventa->moneda == 'PEN'?'S/':'US$' }}
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">{{ number_format(empty($rventa->gravado)?0.00:$rventa->gravado,2) }}</td>
            <td class="text-center">{{ number_format(empty($rventa->exonerado)?0.00:$rventa->exonerado,2) }}</td>
            <td class="text-center">{{ number_format(empty($rventa->inafecto)?0.00:$rventa->inafecto,2) }}</td>
            <td class="text-center">{{ number_format(empty($rventa->exportacion)?0.00:$rventa->exportacion,2) }}</td>
            <td class="text-center">{{ number_format(empty($rventa->gratuito)?0.00:$rventa->gratuito,2) }}</td>
            <td class="text-center">{{ number_format(empty($rventa->igv)?0.00:$rventa->igv,2) }}</td>
            <td class="text-center">{{ number_format(empty($rventa->icbper)?0.00:$rventa->icbper,2) }}</td>
            <th class="text-center btn-convertir">
                <span id="total">{{ number_format(empty($rventa->total)?0.00:$rventa->total,2) }}</span>
            </th>
        </tr>
    </tbody>
</table>