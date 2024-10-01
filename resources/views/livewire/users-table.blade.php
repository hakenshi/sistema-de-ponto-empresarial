@php use Carbon\Carbon; @endphp
<div class="table-container"
     x-data="{
    previewImage: null,
    userId: null,
    matricula: null,
    curso: null,
    openUserModal(){
       this.$refs.addUserRef.showModal()
    },
    editUserModal(id){
        this.userId = id;
        this.$wire.call('loadUser', id).then(() => {
        this.$refs.editUserRef.showModal()
        })
    },
    updateStatus(id, status){
        if (confirm(`Tem certeza de que deseja ${status == 1 ? 'inativar': 'ativar'} esse usuário?`)){
           this.$wire.call('updateStatus', id)
        }
    },
    closeEditModal(){
        this.userId = null;
        this.$wire.call('loadUser', null)
        this.$refs.editUserRef.close();
    },
    closeUserModal(){
       this.$refs.addUserRef.close()
    },
    openFileInput(){
        this.$refs.fotoPerfilRef.click()
    },
    setPreviewImage(e){
        const file = e.target.files[0]

        if(file){
        console.log(file)
          const reader = new FileReader()
          reader.onload = e => {
            this.previewImage = e.target.result
          }
          reader.readAsDataURL(file)
        }
    }
}"
>
    <div class="actions-container">

        @if($user)
            <dialog x-ref="editUserRef" @close="closeEditModal()">
                <div class="dialog-container">
                    <div class="dialog-header">
                        <button class="button-icon" @click="closeEditModal()"><i class="fa-solid fa-x"></i></button>
                    </div>
                    <div class="dialog-body">
                        <form  action="{{"api/users/".$user->id}}" class="dialog-form" method="post">
                            @method("PATCH")
                            @csrf
                            <div class="dialog-input-container">
                                <label for="nome">Nome:</label>
                                <input value="{{$user?->nome}}" class="input" type="text" name="nome" id="nome">
                            </div>

                            <div class="dialog-input-container">
                                <label for="email">Email:</label>
                                <input value="{{$user?->email}}" class="input" type="email" name="email" id="email"
                                >
                            </div>

                            <div class="dialog-input-container">
                                <label for="curso">Curso:</label>
                                <select class="input" name="curso" id="curso">
                                    <option value="">Selecione um curso</option>
                                    @foreach($cursos as $curso)
                                        @if($curso->id == $user->id_curso)
                                            <option value="{{$curso->id}}" selected>{{$curso['nome']}}</option>

                                        @else
                                            <option value="{{$curso->id}}">{{$curso['nome']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="dialog-input-container">
                                <label for="matricula">Matrícula/RA:</label>
                                <input value="'{{$user->matricula}}'" x-mask="99999-9" class="input" type="text"
                                       name="matricula" id="matricula">
                            </div>

                            <div class="dialog-input-container">
                                <label for="password">Senha</label>
                                <input name="password" id="password" class="input" type="password">
                            </div>

                            <div class="dialog-input-container">
                                <label for="confirm-password">Confirmar Senha</label>
                                <input class="input" name="confirm-password" id="confirm-password" type="password">
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
        @endif

        <dialog x-ref="addUserRef" @close="closeUserModal()">
            <div class="dialog-container">
                <div class="dialog-header">
                    <button class="button-icon" @click="closeUserModal()"><i class="fa-solid fa-x"></i></button>
                </div>
                <div class="dialog-body">
                    <form action="/api/users" class="dialog-form" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="dialog-input-container">
                            <label for="nome">Nome:</label>
                            <input class="input" type="text" name="nome" id="nome">
                        </div>

                        <div class="dialog-input-container">
                            <label for="email">Email:</label>
                            <input class="input" type="email" name="email" id="email">
                        </div>

                        <div class="dialog-input-container">
                            <label for="curso">Curso:</label>
                            <select class="input" name="curso" id="curso">
                                <option value="">Selecione um curso</option>
                                @foreach($cursos as $curso)
                                    <option value="{{$curso->id}}">{{$curso['nome']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="dialog-input-container">
                            <label for="matricula">Matrícula/RA:</label>
                            <input x-mask="99999-9" class="input" type="text" name="matricula" id="matricula">
                        </div>

                        <div class="dialog-input-container">
                            <label for="password">Senha</label>
                            <input name="password" id="password" class="input" type="password">
                        </div>

                        <div class="dialog-input-container">
                            <label for="confirm-password">Confirmar Senha</label>
                            <input class="input" name="confirm-password" id="confirm-password" type="password">
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

        <button @click="openUserModal()" class="button-primary">Cadastrar Usuário</button>
    </div>
    <table>
        <thead class="table-dark">
        <tr>
            <th class="text-center">Foto de perfil</th>
            <th class="text-center">Nome</th>
            <th class="text-center">Email</th>
            <th class="text-center">RA</th>
            <th class="text-center">Status</th>
            <th class="text-center">Data de adição</th>
            <th class="text-center"></th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td class="text-center p-2">
                    <img class="avatar"
                         src="{{$user->foto_perfil ? asset('storage/'.$user->foto_perfil) : asset('user-default.png') }}"
                         alt="">
                </td>
                <td class="text-center p-2">{{$user->nome}}</td>
                <td class="text-center p-2">{{$user->email}}</td>
                <td class="text-center p-2">{{$user->matricula}}</td>
                <td class="text-center p-2">{{$user->status == 1 ? "Ativo" : "Inativo"}}</td>
                <td class="text-center p-2">{{Carbon::parse($user->created_at)->format('d/m/Y, H:i')}}</td>
                <td class="text-center p-2">
                    <div class="d-flex justify-content-center gap-3">
                        <button>Turnos</button>
                        <button @click="editUserModal({{$user->id}})" class="button-edit">Editar</button>
                        <button @click="updateStatus({{$user->id}}, {{$user->status}})"
                                class="{{$user->status == 1 ? "button-delete" : "button-confirm"}}">{{$user->status == 1 ? "Inativar" : "Ativar"}}</button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Não há usuários</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{$users->links('pagination-links')}}
</div>