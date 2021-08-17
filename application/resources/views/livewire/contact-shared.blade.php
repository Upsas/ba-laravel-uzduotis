<div class="pt-6">
    <div class="mb-2">
        <div class="flex mx-auto  items-center w-5/6">
            <select wire:model="filterOption" class="rounded-2xl">
                <option value="">All</option>
                <option value="sharedWithMe">Shared with me</option>
                <option value="sharedWithOther">Shared with other</option>
            </select>
            <div class="mx-auto">
            <x-search></x-search>
            </div>
        </div>
    </div>
    @livewire('flash-message')
    <div class="flex flex-col ">
        <table class="rounded-t-lg m-5 w-5/6 mx-auto bg-gray-200 text-gray-800">
            <tr class="text-left border-b-2 border-gray-300">
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Number</th>
                <th class="px-4 py-3">Shared With</th>
                <th class="px-4 py-3">Action</th>
            </tr>
            @forelse($contacts as $contact)
                <tr wire:loading.class.delay="opacity-50" class="bg-gray-100 border-b border-gray-200">
                    <td class="px-4 py-3">
                        {{$contact->getSharedContact()->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{$contact->getSharedContact()->number }}
                    </td>
                    <td class="px-4 py-3">
                        @if( $contact->getUserWhomSharedContact()->name === auth()->user()->name)
                            Me <br> <i>From: {{$contact->getUserWhichSharedContact()->name}}</i>
                        @else
                            {{$contact->getUserWhomSharedContact()->name}}
                        @endif

                    </td>
                    <td class="px-4 py-3">

                        @if( $contact->getUserWhomSharedContact()->name === auth()->user()->name)
                            <x-buttons.delete-button wire:click="deleteShared({{$contact->getSharedContact()->getSharedContact()->id }})">
                                Delete
                            </x-buttons.delete-button>
                            <x-buttons.add-button
                                iconSize="lg"
                                wire:click="addContact({{$contact->getSharedContact()->id }}, {{$contact->getSharedContact()->getSharedContact()->id}})"
                            ></x-buttons.add-button>
                        @else
                            <x-buttons.cancel-button wire:click="cancel({{$contact->getSharedContact()->getSharedContact()->id }})">
                            </x-buttons.cancel-button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr wire:loading.class.delay="opacity-50">
                    <td class="text-center p-5 bg-gray-100" colspan="4">
                        <h1 class="text-xl">Its empty</h1>
                    </td>
                </tr>
            @endforelse
        </table>
        <div class="fixed inset-x-0 bottom-0">
            <div class="w-3/4 mx-auto mb-8">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
    @if($showModal)
        <x-modal-delete-confirmation
            contactId="{{$contactId}}"
            message="{{$message}}"
            buttonName="{{$buttonName}}"
        ></x-modal-delete-confirmation>
    @endif
</div>
