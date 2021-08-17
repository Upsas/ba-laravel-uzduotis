<div>
    <div
        class="{{$showShareForm}} my-auto overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="modal-id-share">
        <div class="relative w-5/12	 my-6 mx-auto max-w-3xl">
            <!--content-->
            <div
                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                <!--header-->
                <div
                    class="flex f items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                   <div class="flex flex-col">
                    <h3 class="text-3xl font-bold">
                        Share your contact
                    </h3>
                    <p class="mt-1 font-semibold">Contact: {{$contact->name ?? '' }} {{$contact->number ?? '' }}</p>
                   </div>
                    <button class="" onclick="toggleModalShare('modal-id-share')">
          <span class="ml-5 p-1 text-lg">
            ×
          </span>
                    </button>
                </div>
                <!--body-->
                <div class="w-full relative p-6 flex-auto">
                    <form wire:submit.prevent="share" class="flex flex-col ">
                        <div class="flex flex-row">
                            <label for="cars">Choose a user to share a contact:</label>
                            <select class="w-1/2 ml-4" wire:model.defer="userId">
                                <option disabled selected value="">Please select</option>
                            @forelse($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @empty
                                    <h4>Its empty</h4>
                                @endforelse
                            </select>
                        </div>
                        <div class="self-end mt-2">
                            <button
                                class="self-end hover:text-opacity-75 text-blue-500 background-transparent font-bold uppercase px-3 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            >Share</button>
                            <button
                                class="self-end hover:text-opacity-75 text-red-500 background-transparent font-bold uppercase px-3 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="button" onclick="toggleModalShare('modal-id-share')">
                                Close
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="{{$showShareForm}} opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-share-backdrop"></div>

</div>
