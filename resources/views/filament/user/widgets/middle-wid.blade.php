<x-filament-widgets::widget>
    <style>
        /* .aerw-cont{
            margin-right: -340px;
        }
        .cnpc-cont{
            margin-right: -340px;
        } */
    </style>
    <div class="grid grid-flow-col">
        <x-filament::section class="aerw-cont" style=" width: full; ">
            @livewire('aerw-modal')
        </x-filament::section>
        <x-filament::section class="cnpc-cont" style=" width: full;"> 
            @livewire('cnpc-modal')
        </x-filament::section>
        <x-filament::section class="mtprf-cont" style=" width: full;"> 
            @livewire('mtprf-modal')
        </x-filament::section>
    </div>
</x-filament-widgets::widget>
