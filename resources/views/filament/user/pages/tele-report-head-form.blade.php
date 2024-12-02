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
        .fi-section-header {
            background-color: #F4F4F4;
            border-top-left-radius: 0.5rem; /* 8px */
            border-top-right-radius: 0.5rem; /* 8px */
        }

        .dark .fi-section-header {
            background-color: #404249;
            border-top-left-radius: 0.5rem; /* 8px */
            border-top-right-radius: 0.5rem; /* 8px */
        }
        .fi-sidebar{
            display: none;
        }
        .fi-breadcrumbs{
            display: none;
        }
    </style>
    <form wire:submit="create">
        {{ $this->form }}
    </form>
</x-filament-panels::page>
