@php use Illuminate\Support\Carbon; @endphp
<x-default_layout :css="asset('css/admin-style.css')" :script="'js/app.js'">

        <div class="clock-container">
            <h2>Hora Atual:</h2>
            <p id="clock">
                {{Carbon::now()->format('H:i')}}
            </p>
            @if(auth()->user()->status == 0)
                <p>Você atualmente está inativado do programa de embaixadores. <br>
                Boa sorte nas próximas eleições.</p>
            @else
            <button class="button-primary" id="bater-ponto">Bater Ponto</button>
            <p id="ultimo-ponto">
                <span>Última marcação:</span>
                {{$ultimoPonto}}
            </p>
            <div class="turno-container">
                @if($proximoTurno)
                    {{$proximoTurno['message']}}
                @else
                    {{$proximoTurno['hora_entrada']}} - {{ $proximoTurno['hora_saida']}}
                @endif
            </div>
            @endif
        </div>
</x-default_layout>