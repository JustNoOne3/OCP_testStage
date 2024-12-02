<x-filament::modal id="modal-cshp" width="7xl" height="5xl">
    <x-slot name="trigger" style="height: 100%;">
        <x-filament::button color="primary" size="xl" outlined style="margin: 15px; width: 100%;">
            <div class="grid grid-flow-rows">
                <img src="{{asset('images/cshp-2.png')}}" alt="" class="mr-2 mx-auto" style="width: 100%;">
            </div>
        </x-filament::button>
    </x-slot>

    <div class="grid grid-flow-rows">
        <div class="h-14 font-bold text-2xl text-white p-4 text-center border border-gray-900 rounded-md mb-4" style="background-color: #114bb0; dark:background-color: #114bb0;">
            {{-- <img src="{{asset('images/5.png')}}" alt="" class="mr-2 mx-auto mb-2" style="width: 80px;"> --}}
            Construction Safety and Health Program Online Application
        </div>
        <div class="grid grid-flow-col">
            <x-filament::button wire:click="residential" color="success" size="xl" outlined style="margin: 15px;">
                <div class="grid grid-flow-rows">
                    <img src="{{asset('images/cshp2.png')}}" alt="" class=" mx-auto mb-2" style="width: 90%;">
                    <a class="text-base text-center text-wrap" style="text-wrap: wrap;  margin-top: -50px; margin-bottom: 20px;">Residential or Small Commercial Project <br> Directly administered by the Owner</a>
                </div>
            </x-filament::button>
            <x-filament::button wire:click="private" color="secondary" size="xl" outlined style="margin: 15px;">
                <div class="grid grid-flow-rows">
                    <img src="{{asset('images/cshp3.png')}}" alt="" class=" mx-auto mb-2" style="width: 90%;">
                    <a class="text-base text-center text-wrap" style="text-wrap: wrap; margin-top: -50px; margin-bottom: 20px;">Government / Private / Residential Project <br> engaging services of Construction Firm</a>
                </div>
            </x-filament::button>
            <x-filament::button wire:click="dpwh" color="primary" size="xl" outlined style="margin: 15px;">
                <div class="grid grid-flow-rows">
                    <img src="{{asset('images/cshp4.png')}}" alt="" class=" mx-auto mb-2" style="width: 90%;">
                    <a class="text-base text-center text-wrap" style="text-wrap: wrap;  margin-top: -50px; margin-bottom: 20px;">DPWH Projects for Concurrence</a>
                </div>
            </x-filament::button>
        </div>
        <div class="mx-auto">
            <x-filament::button wire:click="track" color="primary" size="xl" style="margin: auto; width: 500px;">
                <div class="grid grid-flow-col">
                    <x-filament::icon
                        icon="heroicon-m-magnifying-glass"
                        class="h-5 w-5 text-white-500 dark:text-white-1000"
                    />
                    <a class="text-base text-center text-wrap" style="color: white; padding-left: 15px;">Track Application</a>
                </div>
            </x-filament::button>
        </div>
    </div>
    

</x-filament::modal>