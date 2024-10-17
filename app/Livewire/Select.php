<?php

namespace App\Livewire;

use Livewire\Component;

class Select extends Component
{

    public $id;

    public function mount($id = null)
    {
        $this->id = $id;
    }

    public function render()
    {
        return view('livewire.select');
    }
}
