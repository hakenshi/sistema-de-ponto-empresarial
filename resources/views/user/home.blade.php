@php use Illuminate\Support\Carbon; @endphp
<x-default_layout :css="asset('css/admin-style.css')" :script="'js/app.js'">
    <div class="clock-container">
        <h2>Hora Atual:</h2>
        <p id="clock">
            {{Carbon::now()->format('H:i')}}
        </p>
        <button class="button-primary" id="bater-ponto">Bater Ponto</button>
        <p id="ultimo-ponto">
            <span>Última marcação:</span>
            {{$ultimoPonto}}
        </p>
        <div class="turno-container">
            <p>
                Turno Atual:
                @if($proximoTurno)
                    {{$proximoTurno['hora_entrada']}} - {{ $proximoTurno['hora_saida']}}
                @else
                    Sem Turnos
                @endif
            </p>
        </div>
    </div>
</x-default_layout>