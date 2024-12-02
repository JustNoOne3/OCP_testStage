<?php

namespace App\Livewire;

use Livewire\Component;

class MtprfModal extends Component
{
    public function render()
    {
        return view('livewire.mtprf-modal');
    }
    
    public function mtprf_table(){
        return;
    }

    public function mtprf_submit(){
        return redirect('user/mtprf/mtprf-submit');
    }

}
