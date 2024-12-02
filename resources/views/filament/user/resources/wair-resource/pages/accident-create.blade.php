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
        .fi-sidebar{
            display: none;
        }
        .fi-breadcrumbs{
            display: none;
        }
    </style>
    @if(Auth::user()->est_id == null)
        @php
            redirect('user/register-est');
        @endphp
    @else
        {{ $this->form }}
    @endif
</x-filament-panels::page>
