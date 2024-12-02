<style>
    /* From Uiverse.io by Sergestra */ 
    .buttonReg {
        outline: 0;
        border: 0;
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 300px;
        height: 50px;
        border-radius: 0.5em;
        box-shadow: 0 0.625em 1em 0 rgba(30, 143, 255, 0.35);
        overflow: hidden;
        margin-right: 30px;
        padding: auto;
        text-align: center;
    }

    .buttonReg div {
        transform: translateY(0px);
        width: 100%;
    }

    .buttonReg,
    .buttonReg div {
        transition: 0.6s cubic-bezier(.16,1,.3,1);
    }

    .buttonReg div span {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 50px;
        padding: 0.75em 1.125em;
        text-align: center;
    }

    .buttonReg div:nth-child(1) {
        background-color: #1e90ff;
    }

    .buttonReg div:nth-child(2) {
        background-color: #dc9121;
    }

    .buttonReg:hover {
        box-shadow: 0 0.625em 1em 0 #976b29;
    }

    .buttonReg:hover div {
        transform: translateY(-50px);
    }

    .buttonReg p {
        font-size: 17px;
        font-weight: bold;
        color: #ffffff;
    }

    .buttonReg:active {
        transform: scale(0.95);
    }

</style>
@if(! Illuminate\Support\Facades\Auth::user()->est_id)

    <button class="buttonReg" id="myBtn">
        <div>
            <span>
                <p>Rule 1020 Registration</p>
                <x-filament::icon
                    icon="heroicon-m-building-office-2"
                    class="h-5 w-5 text-white"
                />
            </span>
        </div>
        <div>
            <span>
                <p>Register Establishment Now!</p>
                <x-filament::icon
                    icon="heroicon-m-document-chart-bar"
                    class="h-5 w-5 text-white"
                />
            </span>
        </div>
    </button>
    
      
@endif

<script>
    var btn = document.getElementById('myBtn');
    btn.addEventListener('click', function() {
        document.location.href = '{{ route('register-est') }}';
    });
</script>