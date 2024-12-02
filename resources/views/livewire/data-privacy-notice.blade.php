<div>
    <div wire:init="showDashboardVideoModalEvent"></div>
    <x-filament::modal 
    :close-by-clicking-away="false" 
    id="data-privacy-notice" 
    class="bg-gray-600/75 mw-auto w-full"
    width="7xl"
    :close-button="false"
    >   
        <x-slot name="trigger">
            <x-filament::button>
                <button class="btn bg-slate-800 text-slate-500 mx-auto">
                    {{-- <x-filament::icon icon="heroicon-o-shield-check" class="mr-2 max-h-36" /> --}}
                    View Data Privacy Notice
                </button>
            </x-filament::button>
        </x-slot>

        <x-slot name="heading" class="ml-20 text-center ">
                <div class="mb-12 rounded-md border border-lime-950 bg-gradient-to-r from-sky-900 to-sky-600 grid grid-rows-2" style="text-align: center; padding: 10px; color: white;">
                    <x-filament::icon icon="heroicon-o-information-circle" class="mr-2 max-h-12" style="margin-left: 47%;"/>
                    <p class="text-2xl"  style="margin-top: auto; margin-right: 20px;">Privacy Consent Notice</p>
                </div>
        </x-slot>  

        <x-slot name="description">
            <p class="text-justify" style="text-wrap: wrap; font-size: 25px; padding: 0px 50px 0px 50px;">By using this System, you agree that the data/information submitted shall be used solely for DOLE program implementation and report monitoring purposes. 
                We may likewise disclose establishment's or your personal information to the extent that we are required to do so by the Data Privacy Act of 2012. 
                As a general rule, we may only keep your information until such time that we have attained the purpose by which we collect them. Under the foregoing 
                circumstances and to the extent permissible by applicable law, you agree not to take any action against the DOLE for the disclosure and retention of your information.</p>
        </x-slot>

        <x-slot name="footerActions">
            <button type="button" wire:click="closeModal" class="btn bg-gradient-to-r from-sky-900 to-sky-600 hover:bg-sky-950  mx-auto" style="width: 300px;">
                <div class="grid grid-cols-2">
                    <x-filament::icon icon="heroicon-o-check-circle" class="mr-2 max-h-12" width="xl" color="#ffff"/>
                    <p style="margin-top: auto; margin-right: 20px; color: #ffff">I Agree</p>
                </div>
            </button>
        </x-slot>

    </x-filament::modal>
</div>
