@php use Carbon\Carbon; @endphp
<div class="table-container">
    <livewire:filter-pontos/>
    <table>
        <thead class="table-dark">
        <tr>
            <th class="text-center">Turno</th>
            <th class="text-center">Data</th>
            <th class="text-center">Hora Entrada</th>
            <th class="text-center">Hora Saída</th>
        </tr>
        </thead>
        <tbody>
        @forelse($pontos as $ponto)
            <tr>
                <td class="text-center p-2">{{ $ponto->turnos->hora_entrada }} - {{$ponto->turnos->hora_saida}}</td>
                <td class="text-center p-2">{{ Carbon::parse($ponto->data_hora_entrada)->format('d/m/Y') }}</td>
                <td class="text-center p-2">{{ Carbon::parse($ponto->data_hora_entrada)->format('H:i') }}</td>
                <td class="text-center p-2">{{ $ponto->data_hora_saida ? Carbon::parse($ponto->data_hora_saida)->format('H:i') : "Sem hora saída" }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">Nenhum ponto registrado.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{$pontos->links('pagination-links')}}
</div>

