<table id='detmasivo' class='table table-responsive-md table-hover table-bordered table-estrecha-ventas table-sb'>
    <thead>
        <tr class="colorprin negrita">
            <th width="10%">Número</th>
            <th width="10%">Bruto</th>
            <th width="20%">Tara</th>
            <th width="20%">Neto</th>
            <th width="20%">Acumulado</th>
            <th width="10%">
                <button class="btn btn-block btn-addventa" type="button" id="btnadd">+</button>
            </th>
        </tr>
    </thead>
    <tbody>
        @php
            $acumulado = 0;
        @endphp
        @foreach($materiaprima->detmateriaprimas as $det)
        @php
            $acumulado += $det->pesoneto;
        @endphp
        <tr>
            <td>{{ $det->pesada }}</td>
            <td>{{ $det->pesobruto}}</td>
            <td>{{ $det->tara}}</td>
            <td>{{ $det->pesoneto}}</td>
            <td>{{ $acumulado }}</td>
            <td class="text-center align-middle">
                <div class='opts'>
                    <button type="button" class="btn" title="Editar" onclick="edititem('{{ $det->id }}');">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn" id='destroyitem' title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    function destroyitem(id){
		Swal.fire({
            title: 'Está Seguro de Eliminar el Registro?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, eliminar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {
				$.get(url_global+"/admin/materiaprimas/"+id+"/destroyitem/",function(response){
                    $('#pplanta').val(response['pplanta']);
					$('#batch').val(response['batch']);
					veritems();
                    Swal.fire({
                        icon:'success',
                        title:'Eliminado',
                        text:'Registro Eliminado'
                    });
				});                
            }
            })
	}

    $('#addpeso').click(function(){
        $('#formpeso').show();
        $('#detalles').hide();
        $('#idd').val($('#id').val());
        $('#tipo').val(1);
        $('#pesobruto').val(null);
        // $('#tara').val(null);
        $('#pesoneto').val(null);
        $('#pesobruto').focus();
    });

</script>