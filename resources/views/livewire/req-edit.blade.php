<x-filament::modal id="modal-tav" width="5xl">


    <x-slot name="trigger" style="height: 100%;">
        <x-filament::button color="danger"  style="margin: 15px; width: 100%;">
            Request for Editing
        </x-filament::button>
    </x-slot>

    <form wire:submit.prevent="create">
        {{ $this->form }}
        
        <x-filament::button type="submit" color="primary" class="grid grid-cols-4 gap-4"  style="margin: 15px; width: 100%;">
            <x-filament::loading-indicator wire:loading />
            Submit
        </x-filament::button>
    </form>

</x-filament::modal>