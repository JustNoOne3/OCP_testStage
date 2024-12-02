<x-filament::modal id="modal-cnpc" width="5xl">
    <x-slot name="trigger" >
        <x-filament::button color="warning" size="xl"  style="margin: 15px; width: 100%; height: 600px;">
            <div class="grid grid-flow-rows">
                <img src="{{asset('images/cnpc_bus.png')}}" alt="" class="mr-2 mx-auto" style="width: 240px;">
                <a class="text-base text-center text-wrap text-lg" style="text-wrap: wrap;">BUS COMPANY</a>
                <p class="text-slate-700 text-wrap" style="margin-top: 30px;">Apply for Certificate of No Pending <br> Case as a Bus Company</p>
            </div>
        </x-filament::button>
    </x-slot>

    <div class="grid grid-flow-rows">
        <div class="h-14 font-bold text-2xl text-white p-4 text-center border border-gray-900 rounded-md mb-4" style="background-color: #0F0B3A; dark:background-color: #5A5D64; margin-bottom: 20px;">
            Form here
        </div>
    </div>

</x-filament::modal>