<x-filament::modal id="modal-tele" width="5xl">
    <x-slot name="trigger" style="height: 100%;">
        <x-filament::button color="danger" size="xl" outlined style="margin: 15px; width: 100%;">
            <div class="grid grid-flow-rows">
                <img src="{{asset('images/1.png')}}" alt="" class="mr-2 mx-auto" style="width: 240px;">
            </div>
        </x-filament::button>
    </x-slot>

    <div class="grid grid-flow-rows">
        <div class="h-14 font-bold text-2xl text-white p-4 text-center border border-gray-900 rounded-md mb-4" style="background-color: #0F0B3A; dark:background-color: #5A5D64;">
            {{-- <img src="{{asset('images/5.png')}}" alt="" class="mr-2 mx-auto mb-2" style="width: 80px;"> --}}
            Select
        </div>
        <div class="grid grid-flow-col">
            @livewire('tele-select')
            <x-filament::button wire:click="teleTable" color="primary" size="xl" outlined style="margin: 15px;">
                <div class="grid grid-flow-rows">
                    <img src="{{asset('images/15.png')}}" alt="" class="mr-2 mx-auto" style="width: 240px;">
                    <a class="text-base text-center text-wrap" style="text-wrap: wrap;">VIEW SUBMISSION HISTORY</a>
                </div>
            </x-filament::button>

        </div>
    </div>
</x-filament::modal>