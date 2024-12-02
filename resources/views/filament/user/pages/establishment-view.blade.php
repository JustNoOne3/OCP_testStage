<x-filament-panels::page>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div>
        @livewire('req-edit')
        @livewire('view-est')
    </div>
    
</x-filament-panels::page>
