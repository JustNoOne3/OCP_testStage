<x-filament::modal id="modal-13thmonth" width="5xl">
    <x-slot name="trigger" style="height: 100%;">
        <x-filament::button  color="primary" size="xl" outlined style="margin: 15px; width: 100%;">
            <div class="grid grid-flow-rows">
                <img src="{{asset('images/14.png')}}" alt="" class="mr-2 mx-auto" style="width: 240px;">
                <a class="text-base text-center text-wrap" style="text-wrap: wrap;">SUBMIT REPORT</a>
            </div>
        </x-filament::button>
    </x-slot>

    <div class="grid grid-flow-rows">
        <div class="h-14 font-bold text-2xl text-white p-4 text-center border border-gray-900 rounded-md mb-4" style="background-color: #0F0B3A; dark:background-color: #5A5D64;">
            Select
        </div>
        <div class="grid grid-flow-col">
            @if(App\Models\Establishment::where('est_id', Illuminate\Support\Facades\Auth::user()->est_id)->value('est_class') == '1')
                <x-filament::button wire:click="teleHead" color="success" size="xl"  style="margin: 15px;">
                    <div class="grid grid-flow-col left-0">
                        <img src="{{asset('images/10.png')}}" alt="" class="mr-2 mt-auto " style="height: 200px;">
                        <div class="text-left text-wrap" style="text-wrap: wrap; margin: auto; font-size: 40px;">
                            <p style="margin-top: -10px; margin-left: 5px;">HEAD</p>
                            <p style="margin-top: 30px;">OFFICE</p>
                        </div>
                    </div>
                </x-filament::button>
            @endif
            <x-filament::button wire:click="teleBranch" color="info" size="xl"  style="margin: 15px;">
                <div class="grid grid-flow-col left-0">
                    <img src="{{asset('images/11.png')}}" alt="" class="mr-2 mx-auto" style="height: 200px;">
                    <div class="text-left" style="text-wrap: wrap; margin: auto; font-size: 40px; height: auto;">
                        <p style="margin-top: -5px;">BRANCH </p>
                        <p style="margin-top:30px;">/ SATELLITE </p>
                        <p style="margin-top:30px;">OFFICE</p>
                    </div>
                </div>
            </x-filament::button>
        </div>
    </div>
</x-filament::modal>
