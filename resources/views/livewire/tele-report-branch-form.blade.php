<x-filament::modal
    class="bg-gray-600/75 mw-auto w-full"
    width="6xl" >
    <x-slot name="trigger">
        <x-filament::button class="btn btn-danger"  style="padding: 50px; width: 350px; height: 400px;">
                <x-filament::icon icon="heroicon-s-building-storefront" class="mr-2 max-h-72" />
                <div class="grid grid-rows-4 grid-cols-1 ">
                    <div class="text-wrap text-xl">Submit Report for Branch Office</div>
                    <div></div>
                    <div></div>
                </div>
        </x-filament::button>
    </x-slot>
 
    <div class="">
        <h2 class="mb-12">Privacy Policy and Data Privacy Notice & Consent</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed augue lacus viverra vitae. </p>
            <p>Consectetur lorem donec massa sapien faucibus et molestie ac feugiat. Tortor aliquam nulla facilisi cras. Duis tristique sollicitudin nibh sit amet commodo. Netus et malesuada fames ac. Posuere sollicitudin aliquam ultrices sagittis orci a. </p>
            <p>Sit amet venenatis urna cursus eget nunc. Massa enim nec dui nunc. Hac habitasse platea dictumst vestibulum rhoncus est pellentesque elit ullamcorper. Tortor vitae purus faucibus ornare suspendisse sed nisi lacus sed. Amet dictum sit amet justo donec enim diam vulputate. Pulvinar mattis nunc sed blandit. </p>
            <p>Diam maecenas ultricies mi eget mauris. Turpis massa tincidunt dui ut. Consequat nisl vel pretium lectus quam id leo in vitae. Purus semper eget duis at. Leo in vitae turpis massa sed elementum tempus egestas. Cum sociis natoque penatibus et magnis. Neque ornare aenean euismod elementum nisi quis eleifend quam adipiscing. </p>
            <p>Est placerat in egestas erat imperdiet sed euismod nisi. Dignissim sodales ut eu sem integer. Duis ut diam quam nulla porttitor massa id. Pellentesque id nibh tortor id aliquet lectus proin nibh. Nibh venenatis cras sed felis eget velit aliquet. Id diam vel quam elementum. Vestibulum mattis ullamcorper velit sed ullamcorper. </p>
            <p>Nisl nisi scelerisque eu ultrices vitae auctor eu. Augue eget arcu dictum varius duis at consectetur lorem donec. Sem viverra aliquet eget sit amet tellus cras adipiscing enim. Egestas congue quisque egestas diam in arcu cursus euismod. Dictum varius duis at consectetur lorem donec massa sapien. Facilisi nullam vehicula ipsum a arcu. </p>
            <p>Massa eget egestas purus viverra accumsan in nisl. Tortor vitae purus faucibus ornare suspendisse sed. Sed pulvinar proin gravida hendrerit. Porta nibh venenatis cras sed felis eget. Urna duis convallis convallis tellus id. Nunc vel risus commodo viverra maecenas. Neque gravida in fermentum et. Est ullamcorper eget nulla facilisi. Pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu. </p>
            <p>Molestie a iaculis at erat pellentesque. Commodo viverra maecenas accumsan lacus vel facilisis. Proin libero nunc consequat interdum varius sit amet mattis. Vel orci porta non pulvinar neque. </p>
            <p>Dignissim cras tincidunt lobortis feugiat vivamus at augue eget. Nibh sit amet commodo nulla facilisi nullam. Sed euismod nisi porta lorem mollis aliquam ut. Est pellentesque elit ullamcorper dignissim. </p>
        <button type="button" wire:click="closeModal" class="btn btn-success btn-lg mx-auto" >
            <x-filament::icon icon="heroicon-o-check-circle" class="mr-2 max-h-12" />I've Fully Understood
        </button>
    </div>
</x-filament::modal>