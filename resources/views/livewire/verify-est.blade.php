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

            .cert-img{
                max-width: 250px; 
                /* margin: auto; */
                /* margin-top: 15%; */
                margin-left: 25%;
                box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            }
            .in-textt{
                margin-top: -230px;
                text-align: center;
                margin-left: 41%;
                margin-right: auto;
            }
            .in_name{
                font-size: 9px;
                font-weight: bold;
                text-transform: uppercase;
                margin-left: auto;
                margin-right: auto;
            }
            .in_address{
                font-size: 7px;
                margin-left: auto;
                margin-right: auto;
                
            }
            .in_certdate{
                font-size: 5px;
                font-weight: bold;
                margin-top: 50px; 
                margin-left: auto;
                margin-right: auto;
                
            }
            .qr{
                padding-right: auto;
                padding-left: 35%;
                margin-top: 10px;
            }

            .issued-on{
                text-align: center;
                color: gray;
                font-size: 12px;
                margin-top: 15%;
                margin-bottom: 2%;
                margin-left: 15%;
            }
            .sec-text{
                margin-left: 10%;
                margin-top: 20%;
                text-wrap: wrap;
                font-weight: bold;
                font-size: 20px;

            }
            .status-cont{
                margin-left: 10%;
                margin-top: 5%;
            }
            .printing-cont{
                display: none;
            }

            button{
                margin-left: 10%;
                background-color: rgb(0, 132, 255);
                width: 220px;
                height: 60px;
                border-radius: 10px;
                box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
                margin-top: 10%;
                color: white;
                font-weight: bold;

            }
            button:hover{
                background-color: rgb(54, 158, 255);
                width: 220px;
                height: 60px;
                border-radius: 10px;
                border-width: medium;
                border-color: rgb(198, 228, 255);
                box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
                margin-top: 10%;
                color: white;
                font-weight: bold;

            }
        }


        @media print{
            .preview-cont{
                display: none;
            }

            .cert-img {
                object-fit: cover;
            }

            .printing-cont{
                /* background-image: url("{{asset('images/3.jpg')}}");
                background-repeat: no-repeat; */
                background-size: cover;
                background-color: black;
            }
            
            .text-div{
                margin: -1000px;
                text-align: center;
                margin-left: auto;
                margin-right: auto;
            }

            .est_name{
                margin-top: 230px;
                font-size: 40px;
                font-weight: bold;
                text-transform: uppercase;
                margin-left: auto;
                margin-right: auto;
            }
            .est_address{
                font-size: 20px;
                margin-left: auto;
                margin-right: auto;
            }
            .est_certdate{
                margin: 170px;
                font-weight: bold; 
                margin-left: auto;
                margin-right: auto;
            }
            
        }
    </style>
</head>
<body >
    <div>
        <div class="preview-cont">
            <div class="grid grid-flow-col p-10">
                <div class="grid p-10">
                    <p class="issued-on">
                        Rule 1020 Registration of Establishment <br>
                        Issued on: &nbsp {{$this->month}} {{$this->year}}
                    </p>
                    <img class="cert-img drop-shadow-2xl" src="{{asset('certs/est_cert.png')}}" alt="">
                    <div class="in-textt">
                        <p class="in_name">{{$this->est_name}}</p>
                        <p class="in_address">{{$this->est_address}}</p>
                        <p class="in_certdate">Given this {{$this->day}}th day of {{$this->month}} {{$this->year}},<br> {{$this->province}}, {{$this->region}}.</p>
                        <div id="qrcode1" class="qr"></div>
                        <script src="{{asset('js/qr/qrcode.js')}}"></script>
                        <script type="text/javascript">
                            var qrcode = new QRCode(document.getElementById("qrcode1"), {
                                text: "{{$this->est_reg}}",
                                width: 40,
                                height: 40,
                                colorDark : "#000000",
                                colorLight : "#ffffff",
                                correctLevel : QRCode.CorrectLevel.H
                            });
                        </script>
                    </div>
                    
                </div>
                <div class="p-10">
                    <div class="sec-text">
                        <p class="">Establishment: &nbsp{{$this->est_name}}</p>
                        <p>Address: &nbsp{{$this->est_address}}</p>
                    </div>
                    <div class="status-cont">
                        <p >
                            Status: &nbsp&nbsp&nbsp&nbsp Registered
                        </p>
                        <p>
                            Registration Date: &nbsp {{$this->regDate}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @livewireScripts
    
</body>
</html>