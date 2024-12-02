<x-filament::modal id="modal-aerw" width="5xl">
    <x-slot name="trigger">
        <x-filament::button color="primary" size="" outlined style="margin: 15px; width: full; height: auto; padding-left: 50px; padding-right: 50px;">
            <div class="grid grid-flow-rows">
                <img src="{{asset('images/aerw-1.png')}}" alt="" class="mr-2 mx-auto" style="width: 400px; height: auto;">
            </div>
        </x-filament::button>
    </x-slot>

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