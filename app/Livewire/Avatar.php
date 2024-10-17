<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Avatar extends Component
{
    public $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.avatar');
    }
    public function logout(Request $request){
        if (Auth::check()) {
            Auth::logout();
            $request->session()->flush();
            return redirect()->route('login');
        }
    }

}
