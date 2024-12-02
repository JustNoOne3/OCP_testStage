<x-filament-panels::page>
    <style>
        .fi-body{
            background-image: url({{asset('images/dash-bg4.png')}});
            background-size: cover;
            background-repeat: no-repeat;
        }
        .fi-topbar nav{
            background-color: #0A083B;
            opacity: 90%; 
        }
        .fi-topbar-item-label{
            font-weight: bold;
        }
        .fi-header-heading{
            color: #ffff;
        }
        .fi-logo::after {
            content: "ERS"
        }
        .dark .fi-body {
            background-image : url({{asset('images/dark-dash-bg.png')}});
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
        }
        .dark .fi-topbar nav{
            opacity: 90%;
        }
 
        .fi-btn-label{
            opacity: 100%;
        }

        .fi-btn-color-success{
            background-color: #59CCBC;
        }
        .fi-btn-color-info{
            background-color: #74A4F9;
        }
        
        .hover:fi-btn-color-success{
            background-color: #7CEBDB;
        }
    </style>
    <x-filament::button wire:click="teleReportHead" color="success" size="xl"  style="margin: 15px;">
        <div class="grid grid-flow-col left-0">
            <img src="{{asset('images/10.png')}}" alt="" class="mr-2 mt-auto " style="height: 100px;">
            <div class="text-left text-wrap" style="text-wrap: wrap; margin: auto; font-size: 60px;">
                <p style="margin-top: -15px;">HEAD</p>
                <p style="margin-top: 30px;">OFFICE</p>
            </div>
        </div>
    </x-filament::button>
    <x-filament::button wire:click="teleReportBranch" color="info" size="xl"  style="margin: 15px;">
        <div class="grid grid-flow-col left-0">
            <img src="{{asset('images/11.png')}}" alt="" class="mr-2 mx-auto" style="height: 100px;">
            <div class="text-left" style="text-wrap: wrap; margin: auto; font-size: 30px; height: auto;">
                <p style="margin-top: -5px;">BRANCH </p>
                <p style="margin-top:30px;">/ SATELLITE </p>
                <p style="margin-top:30px;">OFFICE</p>
            </div>
        </div>
    </x-filament::button>
</x-filament-panels::page>
