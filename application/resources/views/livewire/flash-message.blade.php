<div>
    @if (session()->has('message'))
        <div id="successMessageDelete" wire:poll.visible class="flex justify-center items-center">
            <div
                class=" w-1/2  py-3 px-5  bg-{{$flashMessageColor}}-100 text-{{$flashMessageColor}}-900 text-sm rounded-md border border-{{$flashMessageColor}}-200 flex items-center justify-between"
                role="alert">
                <span>{{ session('message') }}</span>
                <button class="w-4" type="button" data-dismiss="alert" aria-label="Close"
                        onclick="this.parentElement.remove();">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif
</div>
