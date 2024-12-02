<x-filament::modal
    :close-button="false"
    class="bg-gray-600/75 mw-auto w-full"
    alignment="center"
    width="3xl">
    <style>
        .fi-modal-window{
            background-image : url({{asset('images/modal-bg9.png')}});
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
        }
        .dark .fi-modal-window {
            background-image : url({{asset('images/dark-dash-bg.png')}});
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
        }
    </style>
    <x-slot name="trigger">
        <x-filament::button class="btn btn-danger"  style="padding: 50px; width: 350px; height: 400px;" color="success">
                <x-filament::icon icon="heroicon-s-home-modern" class="mr-2 max-h-36" />
                <div class="grid grid-rows-4 grid-cols-1 ">
                    <div>TELECOMMUTING REPORT</div>
                    <div>Submit</div>
                </div>
        </x-filament::button>
    </x-slot>
 
    <x-slot name="heading" >
        <h1 class="text-3xl font-bold" style="padding-top:10px; color: #ffff">SELECT TYPE OF ESTABLISHMENT</h1>
    </x-slot>
    <x-slot name="description">
        <div class="grid grid-flow-col center" style="padding-top: 30px; margin-bottom: 30px;">
            @livewire('tele-report-head-form')
            <div style="padding: 10px;"></div>
            @livewire('tele-report-branch-form')
        </div>
    </x-slot>
    
</x-filament::modal>