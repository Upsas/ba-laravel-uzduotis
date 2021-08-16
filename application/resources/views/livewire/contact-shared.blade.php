<div class="pt-6">
    @if (session()->has('message'))
        <div id="successMessageDelete" wire:poll.visible class="flex justify-center items-center">
            <div
                class=" w-1/2  py-3 px-5  bg-red-100 text-red-900 text-sm rounded-md border border-red-200 flex items-center justify-between"
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
    <div class="flex flex-col ">
        <table class="rounded-t-lg m-5 w-5/6 mx-auto bg-gray-200 text-gray-800">
            <tr class="text-left border-b-2 border-gray-300">
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Number</th>
                <th class="px-4 py-3">Shared</th>
                <th class="px-4 py-3">Action</th>
            </tr>
            @forelse($contacts as $contact)
                <tr class="bg-gray-100 border-b border-gray-200">
                    <td class="px-4 py-3">
                        {{$contact->getSharedContact()->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{$contact->getSharedContact()->number }}
                    </td>
                    <td class="px-4 py-3">
                        @if( $contact->getUserWhomSharedContact()->name === auth()->user()->name)
                            {{$contact->getUserWhichSharedContact()->name}}
                        @endif
                        {{$contact->getUserWhomSharedContact()->name}}
                    </td>
                    <td class="px-4 py-3">
                        <x-buttons.delete-button wire:click="delete({{$contact->getSharedContact()->id }})">
                            Delete
                        </x-buttons.delete-button>
                        @if( $contact->getUserWhomSharedContact()->name !== auth()->user()->name)
                            <x-buttons.edit-button wire:click="edit({{$contact->getSharedContact()->id }})">
                                Edit
                            </x-buttons.edit-button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        <h1>Its empty</h1>
                    </td>
                </tr>
            @endforelse
        </table>
        <div class="fixed inset-x-0 bottom-0">
            <div class="w-3/4 mx-auto mb-8">
                {{--                {{ $contacts->links() }}--}}
            </div>
        </div>
    </div>
</div>
