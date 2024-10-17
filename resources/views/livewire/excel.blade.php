@use(App\Models\Pontos)
@use(App\Models\Turnos)
@use(App\Models\User)
<div class="w-100 d-flex justify-content-center">

    <dialog x-ref="excelRef">
        <div class="dialog-container">
            <div class="dialog-header">
                <div class="dialog-header">
                    <button class="button-icon" @click="closeExcelModal()"><i class="fa-solid fa-x"></i></button>
                </div>
            </div>
            <div class="dialog-body">
                <form x-ref="exportRef" action="{{route('api.pontos.export.excel')}}" @submit.prevent="exportExcel" class="dialog-form">
                    <div class="dialog-input-container">
                        <label for="user">Usuario:</label>
                        <select class="input w-100" name="user" id="user">
                            <option value="">Todos</option>
                            @foreach(User::has('pontos')->get() as $user)
                                <option value="{{$user->id}}">{{$user->nome}}</option>
                            @endforeach
                        </select>                    </div>
                    <div class="dialog-input-container">
                        <label for="turno">Turno:</label>
                        <select class="input w-100" name="turno" id="turno">
                            <option value="">Sem preferência</option>
                            @foreach(Turnos::all() as $turno)
                                <option value="{{$turno->id}}"> {{$turno->hora_entrada}}
                                    - {{$turno->hora_saida}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="dialog-input-container">
                        <label for="periodo">Periodo:</label>
                        <select class="input w-100" name="periodo" id="periodo">
                            <option value="">Sem preferência</option>
                            @foreach(Pontos::getFilterOptions() as $options)
                                <option value="{{$options}}"> {{ucfirst($options)}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-center p-2">
                        <button type="submit" class="button-primary">Exportar</button>
                    </div>
                </form>
            </div>
        </div>
    </dialog>

    <button @click="openExcelModal()" class="button-excel">Exportar Excel</button>
</div>