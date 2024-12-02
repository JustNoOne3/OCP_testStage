<x-filament-panels::page >
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style nonce="{{ csp_nonce() }}">
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
    </style>
    <img src="{{asset('images/cons-1.png')}}" alt="">
</x-filament-panels::page>
