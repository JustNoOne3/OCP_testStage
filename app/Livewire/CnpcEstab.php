<?php

namespace App\Livewire;

use Livewire\Component;

class CnpcEstab extends Component
{
    public function render()
    {
        return view('livewire.cnpc-estab');
    }

    public function downloadForm1()
    {
        return response()->download(public_path('forms/testForm.pdf'));
    }
}
