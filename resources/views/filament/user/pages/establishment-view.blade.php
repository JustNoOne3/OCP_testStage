<x-filament-panels::page>
    <style>
        .req-btn{
            right: 10px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div>
        @livewire('req-edit')
        @livewire('view-est')
    </div>
    
</x-filament-panels::page>
