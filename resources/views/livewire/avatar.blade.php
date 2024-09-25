<div class="p-2">
    <img wire:click="$dispatch('openModal')" class="avatar" src="{{$user->foto_perfil ?? asset("user-default.png")}}" alt="{{$user->nome}}">
    <div x-data="{isOpen: @entangle('isOpen')}" x-show="isOpen">
        <h1>Teste</h1>
        <button @click="isOpen = false" wire:click="$dispatch('closeModal')">fechar</button>
    </div>
</div>