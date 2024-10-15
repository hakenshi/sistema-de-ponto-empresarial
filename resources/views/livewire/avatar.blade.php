<div class="p-2" x-data="{
    open: false,
    previewImage: null,
    toggleDropdown() {
        this.open = !this.open; // Alterna o estado do dropdown
    },
    openDialog() {
        this.closeDropdown(); // Garante que o dropdown está fechado antes de abrir o diálogo
        this.$refs.dialogRef.showModal(); // Abre o diálogo
    },
    closeDropdown() {
        this.open = false; // Fecha o dropdown
    },
    closeModal() {
        this.$refs.dialogRef.close(); // Fecha o diálogo
        this.closeDropdown(); // Garante que o dropdown também está fechado
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
}">

    <img @click="toggleDropdown()" class="avatar" src="{{$user->foto_perfil ? asset("storage/$user->foto_perfil") : asset('user-default.png')}}"
         alt="{{$user->nome}}">

    <div class="dropdown" x-show="open" @click.outside="closeDropdown()">
        <div class="dropdown-content">
            <button @click="openDialog()"><i class="fa-solid fa-user"></i> Editar Perfil</button>
            <button wire:click="logout"><i class="fa-solid fa-right-from-bracket"></i> Sair</button>
        </div>
    </div>
    <dialog x-ref="dialogRef" @close="closeModal()">
        <div class="dialog-container">
            <div class="dialog-header">
                <button class="button-icon" @click="closeModal()"><i class="fa-solid fa-x"></i></button>
            </div>
            <div class="dialog-body">
                <form action="{{"/api/users/" . $user->id}}" class="dialog-form" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="image-container">
                        <input x-ref="fotoPerfilRef" @change="setPreviewImage" accept=".png, .jpg, .jpeg"  type="file" name="foto_perfil" id="foto_perfil" hidden>
                        <template x-if="previewImage">
                            <img @click="openFileInput()" class="avatar-lg" :src="previewImage"
                                 alt="{{$user->nome}}">
                        </template>
                        <template x-if="!previewImage">
                            <img @click="openFileInput()" class="avatar-lg" src="{{ $user->foto_perfil ? asset("storage/$user->foto_perfil") : asset('user-default.png')}}"
                                 alt="{{$user->nome}}">
                        </template>
                    </div>
                    <div class="dialog-input-container">
                        <label>Nome:</label>
                        <span class="input">{{$user->nome}}</span>
                    </div>
                    <div class="dialog-input-container">
                        <label>Email:</label>
                        <span class="input">{{$user->email}}</span>
                    </div>
                    <div class="dialog-input-container">
                        <label>Curso:</label>
                        <span class="input">{{$user->curso->nome}}</span>
                    </div>
                    <div class="dialog-input-container">
                        <label>Matrícula/RA:</label>
                        <span class="input">{{$user->matricula}}</span>
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
                        <button class="button-primary">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </dialog>
</div>
