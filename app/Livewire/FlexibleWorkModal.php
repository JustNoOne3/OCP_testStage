<?php

namespace App\Livewire;

use Livewire\Component;

class FlexibleWorkModal extends Component
{
    public function render()
    {
        return view('livewire.flexible-work-modal');
    }

    public function fwa_table(){
        return redirect('user/flexible-works');
    }

    public function fwa(){
        return redirect('user/flexible-works/flexible-work-create');
    }
}
