<x-filament::modal id="modal-cnpc" width="5xl">
    <x-slot name="trigger" >
        <x-filament::button color="primary" size="2xl" outlined style="margin: 15px; width: 100%; height: 100%;">
            <div class="grid grid-flow-rows">
                <img src="{{asset('images/14.png')}}" alt="" class="mr-2 mx-auto" style="width: 240px;">
                <a class="text-base text-center text-wrap" style="text-wrap: wrap;">SUBMIT REPORT</a>
            </div>
        </x-filament::button>
    </x-slot>

    {{-- <div class="grid grid-flow-rows">
        <div class="h-14 font-bold text-2xl text-white p-4 text-center border border-gray-900 rounded-md mb-4" style="background-color: #0F0B3A; dark:background-color: #5A5D64; margin-bottom: 20px;">
            Apply As:
        </div>
        <div class="grid grid-flow-col">
            @livewire('cnpc-ind')
        </div>
    </div> --}}
    <div class="grid grid-flow-rows">
        <div class="h-14 font-bold text-2xl text-white p-4 text-center border border-gray-900 rounded-md mb-4" style="background-color: #004395; dark:background-color: #5A5D64;">
            {{-- <img src="{{asset('images/5.png')}}" alt="" class="mr-2 mx-auto mb-2" style="width: 80px;"> --}}
            Stay tuned on Future Updates
        </div>
        <div class="grid grid-flow-rows">
            <img src="{{asset('images/cons-2.png')}}" alt="" class="mx-auto" style="width: 60%;">
        </div>
    </div>

</x-filament::modal>