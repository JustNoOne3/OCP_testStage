<div>
    <div wire:init="showDashboardVideoModalEvent"></div>
    <x-filament::modal 
    :close-by-clicking-away="false" 
    id="news-accept-notice" 
    class="bg-gray-600/75 mw-auto w-full"
    width="7xl"
    :close-button="false"
    >   
        <x-slot name="trigger">
            <x-filament::button>
                <button class="btn bg-slate-800 text-slate-300 mx-auto">
                    {{-- <x-filament::icon icon="heroicon-o-shield-check" class="mr-2 max-h-36" /> --}}
                    News and Updates
                </button>
            </x-filament::button>
        </x-slot>

        <x-slot name="heading" class="ml-20 text-center ">
                <div class="mb-12 rounded-md border border-lime-950 bg-gradient-to-r from-sky-900 to-sky-600 grid grid-rows-2" style="text-align: center; padding: 10px; color: black;">
                    <p class="text-2xl"  style="margin-top: auto; margin-right: 20px;">Welcome! to the Department of Labor and Employment, Online Compliance Portal/p>
                </div>
        </x-slot>  

        <x-slot name="description">
            <p class="text-justify" style="text-wrap: wrap; font-size: 25px; padding: 0px 50px 0px 50px;">
                Test Text BOX
            </p>
        </x-slot>

        <x-slot name="footerActions">
            <button type="button" class="btn bg-gradient-to-r from-sky-900 to-sky-600 hover:bg-sky-950  mx-auto" style="width: 300px;">
                <div class="grid grid-cols-2">
                    <x-filament::icon icon="heroicon-o-check-circle" class="mr-2 max-h-12" width="xl" color="black"/>
                    <p style="margin-top: auto; margin-right: 20px; color: black">I Agree</p>
                </div>
            </button>
        </x-slot>

    </x-filament::modal>
</div>
