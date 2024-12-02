<!DOCTYPE html>
<html lang="en">
<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link href="{{ asset('css/custom/cert.css') }}" rel="stylesheet"> --}}
    <title>Establishment Certificate</title>
    <style>
        @media screen{
            body{
                background-image: url("{{asset('images/dash-bg4.png')}}");
                background-repeat: no-repeat;
                background-size: cover;
            }

            .preview-cont{
                margin: auto;
                margin-top: 10%;
                background-color: white;
                width: 1000px;
                height: 520px;
                border-radius: 10px;
                box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            }

            .top-div{
                padding: 40px; 
                padding-top: 60px;
            }

            .img-attch{
                width: 600px; 
                /* padding-top: 10px; */
            }

            .e-found{
                text-align: center; 
                font-weight: bold; 
                font-size: 35px; 
                padding-top: 20px;
            }

            .sub-text{
                text-align: center; 
                padding-top: 5px;
            }

            
        }

    </style>
</head>
<body >
    <div>
        <div class="preview-cont">
            <div class="top-div" style="">
                <img class="mx-auto img-attch" src="{{asset('certs/not-found1.png')}}" alt="">
                <div class="e-found">Establishment not Found</div>
                <div class="sub-text">There is no registered Establishment linked on the QR code you've just scanned</div>
            </div>
        </div>
    </div>


    @livewireScripts
    
</body>
</html>