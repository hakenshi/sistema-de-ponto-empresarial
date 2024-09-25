<div>

    <button wire:click="$dispatch('openModal')">Abrir</button>

    <div x-data="{isOpen: @entangle('isOpen')}" x-show="isOpen" >
        <h1>teste</h1>
        <button @click="isOpen = false" wire:click="$dispatch('closeModal')">Fechar</button>
    </div>

</div>
