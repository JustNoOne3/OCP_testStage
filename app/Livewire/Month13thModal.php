<?php

namespace App\Livewire;

use Livewire\Component;

class Month13thModal extends Component
{
    public function month13thReport(){
        return redirect('user/month13ths/submit');
    }
    public function month13thReport_table(){
        return redirect('user/month13ths');
    }

    public function render()
    {
        return view('livewire.month13th-modal');
    }
}
