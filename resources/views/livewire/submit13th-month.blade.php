
@livewireStyles()
@livewireScripts()
@yield('content')
<div>
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
        .fi-sidebar {
            opacity: 90%;
            background-image : url({{asset('images/sidebar-bg.png')}});
            background-size: cover;
            background-position: center bottom;
            background-repeat: no-repeat;
        }
        .dark .fi-sidebar {
            background-image : url({{asset('images/sidebar-bg2.png')}});
            background-size: cover;
            background-position: center bottom;
            background-repeat: no-repeat;
        }
        .dark .fi-topbar nav{
            background-color: #454A54;
        }
        .fi-sidebar-header{
            background-color: #140F50;
        }
    </style>
    <form wire:submit="create">
        {{ $this->form }}
    </form>
</div>
