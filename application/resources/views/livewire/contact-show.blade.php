<div>
    <div class="pt-6 mb-2">
        <div class="flex mx-auto justify-between items-center w-5/6">
            <x-search></x-search>
        @livewire('contact-form')
        </div>
    </div>

    @livewire('flash-message')
    <div class="flex flex-col ">
        <table class="rounded-t-lg m-5 w-5/6 mx-auto bg-gray-200 text-gray-800">
            <tr class="text-left border-b-2 border-gray-300">
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Number</th>
                <th class="px-4 py-3">Action</th>
            </tr>
            @forelse($contacts as $contact)
                <tr wire:loading.class.delay="opacity-50" class="bg-gray-100 border-b border-gray-200">
                    <td class="px-4 py-3">
                        {{$contact->name}}
                    </td>
                    <td class="px-4 py-3">
                        {{$contact->number}}
                    </td>
                    <td class="px-4 py-3">
                        <x-buttons.delete-button wire:click="setData({{$contact->id}}, true)">Delete
                        </x-buttons.delete-button>
                        <x-buttons.edit-button wire:click="edit({{$contact->id}})">Edit</x-buttons.edit-button>
                        <x-buttons.share-button wire:click="share({{$contact->id}})"></x-buttons.share-button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center p-5" colspan="3">
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
    @livewire('share-form')

    @if($showModal)
        <x-modal-delete-confirmation contactId="{{$contactId}}"></x-modal-delete-confirmation>
    @endif
</div>
