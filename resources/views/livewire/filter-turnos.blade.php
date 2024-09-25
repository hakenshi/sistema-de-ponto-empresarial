<div class="actions-container">
    <select wire:model="id_turno" wire:change="filter" name="turno" id="turno">
        <option value="0">
            Escolha um turno
        </option>
        @foreach($turnos as $turno)
            <option value="{{$turno->id}}">
                {{$turno->hora_entrada}} - {{$turno->hora_saida}}
            </option>
        @endforeach
    </select>
    <select wire:model="periodo" wire:change="filter" name="periodo" id="periodo">
        <option value="">
            Escolha um período
        </option>
        <option value="hoje">
            Hoje
        </option>
        <option value="semana">
            Última semana
        </option>
        <option value="mes">
            Último mês
        </option>
        <option value="semestre">
            Último semestre
        </option>
    </select>

</div>