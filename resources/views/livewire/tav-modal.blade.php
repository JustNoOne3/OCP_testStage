<x-filament::modal id="modal-tav" width="5xl">
    <style>
        .fi-ta-row {
            .fi-ta-cell:last-of-type {
                @apply relative right-0 top-0 bottom-0;
                > div {
                    @apply bg-white dark:bg-gray-900;
                }
            }
            .fi-ta-cell:last-of-type {
                position: sticky;
                > div {
                    @apply shadow-md rounded-full py-2;
                }
            }
        }
    </style>

    <x-slot name="trigger" style="height: 100%;">
        <x-filament::button color="success" size="xl" outlined style="margin: 15px; width: 100%;">
            <div class="grid grid-flow-rows">
                <img src="{{asset('images/tav-1.png')}}" alt="" class="mr-2 mx-auto" style="width: 100%;">
            </div>
        </x-filament::button>
    </x-slot>

    <div class="grid grid-flow-rows">
        <div class="h-14 font-bold text-2xl text-white p-4 text-center border border-gray-900 rounded-md mb-4" style="background-color: #114bb0; dark:background-color: #114bb0;">
            Technical and Advisory Visits
        </div>
        <div>
            {{ $this->table }}
        </div>
    </div>

</x-filament::modal>