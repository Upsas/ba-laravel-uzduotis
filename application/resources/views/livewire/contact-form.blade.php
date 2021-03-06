<div class="">
        <x-buttons.add-button class="mt-2 flex justify-end" wire:click="add">
            <h1 class="ml-2"> Add contact</h1>
        </x-buttons.add-button>
    <div
        class="{{$show}} my-auto overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="modal-id">
        <div class="relative w-5/12	 my-6 mx-auto max-w-3xl">
            <!--content-->
            <div
                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                <!--header-->
                <div
                    class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                    <h3 class="text-3xl font-semibold">
                        {{$title}}
                    </h3>
                    <button class="" onclick="toggleModal('modal-id')">
          <span class="ml-5 p-1 text-lg">
            ×
          </span>
                    </button>
                </div>
                <!--body-->
                <div class="w-full relative p-6 flex-auto">
                    <form wire:submit.prevent="{{$method}}" class="flex flex-col ">
                        <div class="flex flex-row">
                            <div class="w-full">
                                <x-label for="name" :value="__('Name')"></x-label>
                                <x-input id="name" class="block mt-1 w-full" type="text" wire:model.defer="name"
                                         :value="old('name')"
                                         required></x-input>
                                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mx-5 w-full">
                                <x-label for="number" :value="__('Phone number')"></x-label>

                                <x-input id="number" class="block mt-1 w-full" type="text" wire:model.defer="number"
                                         :value="old('number')"
                                         required></x-input>
                                @error('number') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="self-start">
                            <button
                                class="self-end hover:text-opacity-75 text-blue-500 background-transparent font-bold uppercase px-3 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            >{{$button}}</button>
                            <button
                                class="self-end hover:text-opacity-75 text-red-500 background-transparent font-bold uppercase px-3 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="button" onclick="toggleModal('modal-id')">
                                Close
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class=" {{$show}} opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop"></div>
</div>
