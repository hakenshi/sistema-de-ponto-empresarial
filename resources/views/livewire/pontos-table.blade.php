@php use Carbon\Carbon; @endphp
<div class="table-container" x-data="pontos()">
    <livewire:filter-pontos/>
    <dialog x-ref="editPontoRef" @close="closeModal()">
        @if($editPonto)
            {{--        @dd($this->users)--}}
            <div class="dialog-container">
                <div class="dialog-header">
                    <button class="button-icon" @click="closeModal()"><i class="fa-solid fa-x"></i></button>
                </div>
                <div class="dialog-body">
                    <form x-ref="updatePonto" @submit.prevent="handleUpdate" action="{{route('api.pontos.update', $editPonto->id)}}" class="dialog-form" method="post">
                        <div class="dialog-input-container">
                            <label for="usuario">Usuário:</label>
                            <select class="input w-100" name="usuario" id="usuario">
                                <option value="">Selecione um usuário</option>
                                @for($i = 0; $i< $users->count(); $i++)
                                    @if($editPonto->id_usuario == $users[$i]->id)
                                        <option selected value="{{$users[$i]->id}}">{{$users[$i]->nome}}</option>
                                    @else
                                        <option value="{{$users[$i]->id}}">{{$users[$i]->nome}}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                        <div class="dialog-input-container">
                                <label for="turno">Turno</label>
                                <select name="turno" id="turno" class="input w-100">
                                    <option value="">Selecione o turno do usuário</option>
                                    @php
                                        $editUser = \App\Models\User::findOrFail($editPonto->id_usuario);
                                        $turnoIds = $editUser->turnos()->pluck('turnos.id')->toArray();
                                    @endphp
                                    @foreach($turnos as $turno)
                                        <option value="{{$turno->id}}"
                                                @if(in_array($turno->id, $turnoIds)) selected @endif>{{$turno->hora_entrada}}
                                            - {{$turno->hora_saida}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="dialog-input-container">
                            <label for="hora-entrada">Horário de entrada:</label>
                            <input class="input" name="hora-entrada" id="hora-entrada" type="text" x-mask="99:99:99" value="'{{Carbon::createFromFormat('Y-m-d H:i:s', $editPonto->data_hora_entrada)->format('H:i:s')}}'">
                        </div>
                        <div class="dialog-input-container">
                            <label for="hora-saida">Horário de Saída:</label>
                            <input class="input" name="hora-saida" id="hora-saida" type="text" x-mask="99:99:99" value="'{{$editPonto->data_hora_saida ? Carbon::createFromFormat('Y-m-d H:i:s', $editPonto->data_hora_saida)->format('H:i:s') : ""}}'">
                        </div>
                        <div class="dialog-input-container">
                            <label for="data">Data:</label>
                            <input class="input" id="data" name="data" type="text" x-mask="99/99/9999" value="'{{Carbon::createFromFormat('Y-m-d H:i:s', $editPonto->data_hora_entrada)->format('d/m/Y')}}'">
                        </div>
                        <div class="d-flex justify-content-center p-2 w-100">
                            <button class="button-primary" type="submit">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </dialog>

    <table>
        <thead class="table-dark">
        <tr>
            @if($user->id_cargo === 1)
                <th class="text-center">Usuário</th>
            @endif
            <th class="text-center">Turno</th>
            <th class="text-center">Data</th>
            <th class="text-center">Hora Entrada</th>
            <th class="text-center">Hora Saída</th>
            @if($user->id_cargo === 1)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @forelse($pontos as $ponto)
            <tr>
                <td class="text-center">{{$ponto->usuario->nome}}</td>
                <td class="text-center p-2">{{ $ponto->turnos->hora_entrada }} - {{$ponto->turnos->hora_saida}}</td>
                <td class="text-center p-2">{{ Carbon::parse($ponto->data_hora_entrada)->format('d/m/Y') }}</td>
                <td class="text-center p-2">{{ Carbon::parse($ponto->data_hora_entrada)->format('H:i') }}</td>
                <td class="text-center p-2">{{ $ponto->data_hora_saida ? Carbon::parse($ponto->data_hora_saida)->format('H:i') : "Sem hora saída" }}</td>
                @if($user->id_cargo === 1)
                    <td class="text-center p-2">
                        <div class="d-flex gap-2 justify-content-center">
                            <button @click="openModal({{$ponto->id}})" class="button-edit">Editar</button>
                            <button @click="deletePonto({{$ponto->id}})" class="button-delete">Excluir</button>
                        </div>
                    </td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="{{$user->id_cargo === 1 ? "5" : "4"}}" class="text-center">Nenhum ponto registrado.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{$pontos->links('pagination-links')}}
</div>

