<div>
    <dialog x-ref="pontoRef" @close="closeStoreModal()">
       <div class="dialog-container">
           <div class="dialog-header">
               <button class="button-icon" @click="closeStoreModal()"><i class="fa-solid fa-x"></i></button>
           </div>
           <div class="dialog-body">
               <form x-ref="storePonto" @submit.prevent="handleStore" action="{{route("api.pontos.store")}}" class="dialog-form" method="post">
                   @csrf
                   <div class="dialog-input-container">
                       <label for="usuario">Usuário:</label>
                       <select class="input w-100" name="usuario" id="usuario">
                           <option value="">Selecione um usuário</option>
                           @foreach($users as $user)
                               <option value="{{$user->id}}">{{$user->nome}}</option>
                           @endforeach
                       </select>
                   </div>
                   <div class="dialog-input-container">
                       <label for="turno">Turno do usuário:</label>
                       <select name="turno" id="turno" class="w-100 input">
                           <option value="">Selecione um turno</option>
                           @foreach($turnos as $turno)
                               <option value="{{$turno->id}}">{{$turno->hora_entrada}} - {{$turno->hora_saida}}</option>
                           @endforeach
                       </select>
                   </div>
                   <div class="dialog-input-container">
                       <label for="data">Data do ponto:</label>
                       <input class="input" type="text" name="data" id="data" x-mask="99/99/9999" placeholder="12/06/2013">
                   </div>
                   <div class="d-flex justify-content-center p-2 w-100">
                       <button class="button-primary" type="submit">
                           Salvar
                       </button>
                   </div>
               </form>
           </div>
       </div>
    </dialog>
    <button @click="openStoreModal()" class="button-primary">Registrar Ponto</button>
</div>
