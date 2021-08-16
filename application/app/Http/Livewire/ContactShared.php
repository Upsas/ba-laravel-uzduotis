<?php

namespace App\Http\Livewire;

use App\Models\SharedContact;
use App\Repositories\ContactsRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContactShared extends Component
{
    public function render(ContactsRepository $contactsRepo)
    {
        return view('livewire.contact-shared', [
            'contacts' => SharedContact::where('contact_shared_user_id', Auth::id())->orWhere('user_id', Auth::id())->get()
        ]);
    }
}
