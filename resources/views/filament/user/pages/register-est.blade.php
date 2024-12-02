{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Estalishment</title>
    <style>
        .fi-body{
           background-image: url({{asset('images/dash-bg4.png')}});
           background-size: cover;
           background-repeat: no-repeat;
       }
       .dark .fi-body {
           background-image : url({{asset('images/dark-login-bg2.png')}});
           background-size: cover;
           background-position: center bottom;
           background-repeat: no-repeat;
       }
       .dark .fi-topbar nav{
           background-color: #454A54;
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
    </style>
</head>
<body>
    <x-filament-panels::page>
        <form wire:submit="create">
            {{ $this->form }}
        </form>
    </x-filament-panels::page>
</body>
</html> --}}
<x-filament-panels::page>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .fi-body{
           background-image: url({{asset('images/dash-bg4.png')}});
           background-size: cover;
           background-repeat: no-repeat;
       }
       .dark .fi-body {
           background-image : url({{asset('images/dark-login-bg2.png')}});
           background-size: cover;
           background-position: center bottom;
           background-repeat: no-repeat;
       }
       .dark .fi-topbar nav{
           background-color: #454A54;
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
       .body{
            background-color: #454A54;   
        }
        .fi-sidebar{
            display: none;
        }
        .fi-breadcrumbs{
            display: none;
        }
    </style>
    @if (Auth::user()->est_id != null)
        @php
            redirect('/user');
        @endphp    
    @endif
    <form wire:submit="create">
        {{ $this->form }}
    </form>
    
</x-filament-panels::page>


