{{-- {{ dd($trazabilidad) }} --}}
<table id= "grid" class="table table-hover table-sm">
    <thead>
        <tr>
            <th>Mat Prima<br>y/o Destino</th>
            <th>Calidad</th>
            <th>Sobre<br>Peso %</th>
            <th>Envase</th>
            <th>Peso</th>
            <th>Código</th>
            <th>Precio<br>Contrata</th>
            <th width="10%"></th>
        </tr>
    </thead>
    
    <tbody>
        @foreach($trazabilidad->dettrazabilidads as $det)
        <tr>
            <td>{{ $det->mpd->nombre }}</td>
            <td>
                @if ($det->calidad == 1)
                    Export
                @else
                    M.N
                @endif
            </td>
            <td>{{ $det->sobrepeso }}</td>
            <td>
                @if ($det->envase == 1)
                    Saco
                @else
                    Block
                @endif
            </td>
            <td>{{ $det->peso }}</td>
            <td>{{ $det->codigo }}</td>
            <td>{{ $det->precio }}</td>
            <td>
                <div class="opts">
                    <button type="button" class="btn" title="Editar" onclick="edititem('{{ $det->id }}');">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn" title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    {{-- <a class="" href="{{ route('admin.destinos.edit',$destino) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a> --}}
                    {{-- <form action="{{ route('admin.destinos.destroy',$destino) }}" method="POST" class="formulario_eliminars">
                        @csrf
                        @method('delete')
                        <button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form> --}}
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
</table>
<script>

</script>