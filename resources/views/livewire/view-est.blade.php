<!DOCTYPE html>
<html lang="en">
<head>
    @livewireStyles()
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Establishment</title>
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
    @livewireScripts() 
    <div> 
        {{-- this works --}}
        @if($this->estInfolist == null || Auth::user()->est_id == null)
            <script>window.location.href = "register-est"</script>
        @else
            {{ $this->estInfolist }}
        @endif
    </div>
</body>
</html>

