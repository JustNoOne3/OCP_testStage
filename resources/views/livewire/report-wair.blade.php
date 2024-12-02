<x-filament::modal id="modal-aerw" width="5xl">
    <style>
        .repBtn {
            height: 7%;
            width: 100%; 
            margin-bottom: 8%; 
            margin-right: 30%;
            transition: transform .3s;
            
        }

        .repBtn:hover {
            transform: scale(1.2); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */

        }
    </style>
    <x-slot name="trigger">
        <button class=" repBtn" id="reportBtn">
            <img src="{{asset('images/accRep-2.png')}}" style="height: 200px; width: full; filter: drop-shadow;" alt="">
        </button>
    </x-slot>

    {{-- <div>
        <div class="text-center border border-gray-900 rounded-md" style="margin-bottom: 20px; padding: 40px;">
            <span class="h-14 font-bold text-2xl text-black dark:text-white">Report a Work Accident/Inciddent</span>
        </div>
        {{$this->form}}
    </div> --}}

    <div class="grid grid-flow-rows">
        <div class="h-14 font-bold text-2xl text-white p-4 text-center border border-gray-900 rounded-md mb-4" style="background-color: #004395; dark:background-color: #5A5D64;">
            {{-- <img src="{{asset('images/5.png')}}" alt="" class="mr-2 mx-auto mb-2" style="width: 80px;"> --}}
            Stay tuned on Future Updates
        </div>
        <div class="grid grid-flow-rows">
            <img src="{{asset('images/cons-2.png')}}" alt="" class="mx-auto" style="width: 60%;">
        </div>
    </div>
    
    

</x-filament::modal>
