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
        /* .fi-section{
            opacity: 95%;
        }
        .fi-modal-trigger{
            opacity: 100%;
        } */
         
        .fi-sidebar{
            display: none;
        }
        .fi-breadcrumbs{
            display: none;
        }
 
        .mainDiv{
            filter: drop-shadow(0 10px 8px rgb(0 0 0 / 0.04)) drop-shadow(0 4px 3px rgb(0 0 0 / 0.1));
        }
        .illRep{
            margin-left: 5%;
        }
        .illRepImg{
            filter: drop-shadow(0 10px 8px rgb(0 0 0 / 0.04)) drop-shadow(0 4px 3px rgb(0 0 0 / 0.1));
        }
        :hover.illRepImg{
            transform: scale(1.1);
            transition: transform 0.2s ease-in-out;
        }
        .accRep{
            margin-top: -100px;
            margin-right: 5%;
        }
        .accRepImg{
            margin-top: -100px;
            filter: drop-shadow(0 10px 8px rgb(0 0 0 / 0.04)) drop-shadow(0 4px 3px rgb(0 0 0 / 0.1));
        }
        :hover.accRepImg{
            transform: scale(1.1);
            transition: transform 0.2s ease-in-out;
            
        }
        .accIll{
            margin-right: -100px;
        }
        .accIllImg{
            margin-left: 150px;
            width: 350px;
            filter: drop-shadow(0 10px 8px rgb(0 0 0 / 0.04)) drop-shadow(0 4px 3px rgb(0 0 0 / 0.1));
        }
        :hover.accIllImg{
            transform: scale(1.1);
            transition: transform 0.2s ease-in-out;
            
        }
        .noInc{
            margin-left: 100px;
        }
        .noIncImg{
            margin-left: 10px;
            width: 350px;
            filter: drop-shadow(0 10px 8px rgb(0 0 0 / 0.04)) drop-shadow(0 4px 3px rgb(0 0 0 / 0.1));
        }
        :hover.noIncImg{
            transform: scale(1.1);
            transition: transform 0.2s ease-in-out;
            
        }
        .secDiv{
            margin-top: -70px;
            margin-bottom: 70px;
        }
    </style>
    @livewireStyles()
    @livewireScripts()
    @if(Auth::user()->est_id == null)
        @php
            redirect('user/register-est');
        @endphp
    @endif
    <div class="center bg-white rounded-lg mainDiv">
        <div class="grid grid-flow-rows firstDiv">
            <button wire:click="illness" class="flex justify-start illRep">
                <img class="w-1/2 illRepImg pl-8"  src="{{asset('images/16.png')}}" alt="">
            </button>
            <button wire:click="accident" class="flex justify-end accRep">
                <img class="w-1/2 accRepImg pr-8" src="{{asset('images/17.png')}}" alt="">
            </button>
        </div>
        <div class="grid grid-cols-2 grid-flow-rows secDiv">
            <button wire:click="both" class="flex accIll">
                <img class="w-1/2 accIllImg" src="{{asset('images/18.png')}}" alt="">
            </button>
            <button wire:click="noIncident" class="flex noInc">
                <img class="w-1/2 noIncImg" src="{{asset('images/19.png')}}" alt="">
            </button>
        </div>
    </div>
</x-filament-panels::page>
