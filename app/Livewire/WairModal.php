<?php

namespace App\Livewire;

use Livewire\Component;

class WairModal extends Component
{
    public function wair_table(){
        return redirect('user/wairs');
    }

    public function wair(){
        return redirect('user/wairs/select');
    }

    public function render()
    {
        return view('livewire.wair-modal');
    }
    
}
