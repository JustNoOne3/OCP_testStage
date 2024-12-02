<?php

namespace App\Livewire;

use Livewire\Component;

class DataPrivacyNotice extends Component
{
    public function showDashboardVideoModalEvent()
    {
        $this->dispatch('open-modal', id: 'data-privacy-notice');
    }
    
    public function render()
    {
        return view('livewire.data-privacy-notice');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', id: 'data-privacy-notice');
    }
}
