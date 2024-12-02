<?php

namespace App\Livewire;

use Livewire\Component;

class DataPrivacyNotice extends Component
{
    public function showDashboardVideoModalEvent()
    {
        $this->dispatch('open-modal', id: 'news-accept-notice');
    }
    
    public function render()
    {
        return view('livewire.news-accept-notice');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', id: 'news-accept-notice');
    }
}
