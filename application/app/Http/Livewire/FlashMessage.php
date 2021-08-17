<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FlashMessage extends Component
{
    public $flashMessageColor;
    protected $listeners = ['flashMessage'];

    public function flashMessage(string $message, string $bgColor): void
    {
        $this->flashMessageColor = $bgColor;
        session()->flash('message', $message);
    }

    public function render()
    {
        return view('livewire.flash-message');
    }
}
