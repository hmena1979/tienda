{!! Form::open(['route'=>['admin.masivos.procesa'],'id'=>'formprocesa']) !!}
<div class="text-right mb-2">
    {!! Form::submit('Agregar', ['class'=>'btn btn-block btn-convertir mt-2', 'id'=>'agregar']) !!}
</div>
<table id= "grid" class="table table-hover table-sm">
    <thead>
        <tr>
            <th width="25%">Proveedor</th>
            <th width="10%">Fecha</th>
            <th width="5%">TD</th>
            <th width="10%">Número</th>
            <th width="8%">Moneda</th>
            <th width="10%">Saldo</th>
            <th width="10%">Pagar</th>
            <th width="10%">Monto</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rcompras as $det)
        <tr>
            <td class="align-middle">{{ $det->cliente->razsoc }}</td>
            <td class="align-middle">{{ $det->vencimiento }}</td>
            <td class="align-middle">{{ $det->tipocomprobante_codigo }}</td>
            <td class="align-middle">{{ numDoc($det->serie, $det->numero)}}</td>
            <td class="align-middle">{{ $det->moneda }}</td>
            <td class="align-middle">
                {{ number_format($det->saldo - $det->total_masivo, 2) }}
            </td>
            <td class="align-middle">
                {!! Form::hidden("rcompra[$det->id][masivo_id]", $masivo->id) !!}
                {!! Form::hidden("rcompra[$det->id][id]", $det->id) !!}
                {!! Form::hidden("rcompra[$det->id][moneda]", $det->moneda) !!}
                {!! Form::hidden("rcompra[$det->id][saldo]", $det->saldo - $det->total_masivo) !!}
                {!! Form::radio("rcompra[$det->id][paga]",1,['class'=>'form-check-input']) !!}
                {!! Form::label("rcompra[$det->id][paga]", 'SI',['class' =>'form-check-label mr-2']) !!}
                {!! Form::radio("rcompra[$det->id][paga]",2,['class'=>'form-check-input']) !!}
                {!! Form::label("rcompra[$det->id][paga]", 'NO',['class' =>'form-check-label']) !!}
                {{-- {!! Form::checkbox("rcompra[$det->id][paga]", true, false) !!} --}}
            </td>
            <td class="align-middle">
                {!! Form::text("rcompra[$det->id][monto]", $det->saldo - $det->total_masivo, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                {{-- {!! Form::hidden("rcompra[".$det->id."][id]", $det->id) !!}
                {!! Form::text("rcompra[".$det->id."][monto]", $det->saldo, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!} --}}
                {{-- {{ number_format($det->saldo, 2) }} --}}
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>
{!! Form::close() !!}
<script>
    var url_global='{{url("/")}}';
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

    $('#agregar').click(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.masivos.procesa') }}",
            type: "POST",
            async: true,
            data: $('#formprocesa').serialize(),
            
            success: function(respuesta){
                console.log(respuesta);
                $('#buscarLote').modal('hide')
                veritems();
                // var data = {
                //     id: respuesta.id,
                //     text: respuesta.numdoc+'-'+respuesta.razsoc
                // };
                // var newOption = new Option(data.text, data.id, false, false);
                // $('#cliente_id').append(newOption).trigger('change');
                // $('#cliente_id').val(respuesta.id);
                // $('#direccion').val(respuesta.direccion);
                // if (respuesta.tipdoc_id == '6') {
                //     $('#tipocomprobante_codigo').val('01')
                // } else {
                //     $('#tipocomprobante_codigo').val('03')
                // }
                // $('#agregarcliente').hide();
            },
            error: function(error){
                $('#buscarLote').modal('hide')
                veritems();
                // console.log(error);
                // let html = 'Se encontraron los siguientes errores:';
                // html += "<ul>";
                // for (var i in error.responseJSON.errors) {
                //     html += "<li>"+ error.responseJSON.errors[i] +"</li>";
                //     console.log(error.responseJSON.errors[i])
                // }
                // html += "</ul>";
                // $('#contenido_error').html(html);
                // $('#mensaje_error').slideDown();
                // setTimeout(function(){ $('#mensaje_error').slideUp(); }, 3000);
            }
        });
    });
</script>