<?php

namespace App\Livewire;

use Livewire\Component;

class TeleModal extends Component
{
    public function render()
    {
        return view('livewire.tele-modal');
    }

    

    public function teleTable() {
        return redirect('user/tele-reports');
    }
}
