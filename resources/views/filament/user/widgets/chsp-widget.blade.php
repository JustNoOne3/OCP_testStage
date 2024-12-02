<x-filament-widgets::widget>
    <style>
        .fi-section-content{
            padding: 0;
        }
    </style>
    <div class="grid grid-flow-col">
        <x-filament::section>
            @livewire('cshp-modal')
        </x-filament::section>
        <x-filament::section> 
            @livewire('tsi-modal')
        </x-filament::section>
    </div>
</x-filament-widgets::widget>
