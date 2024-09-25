<?php

namespace App\Livewire;

use Livewire\Component;

class Avatar extends Component
{
    public $user;
    public $isOpen = false;

    protected $listeners = [
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
    ];

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal(){
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.avatar');
    }
}
