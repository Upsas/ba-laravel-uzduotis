<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use App\Models\SharedContact;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShareForm extends Component
{

    public $show = 'hidden';
    public $userId;
    public Contact $contact;
    protected $listeners = ['showShareForm'];

    public function showShareForm(int $contactId)
    {
        $this->show = 'flex';
        $this->contact = Contact::find($contactId);
    }

    public function share(): void
    {

        $allItems =
            [
                'user_id' => Auth::id(),
                'contact_id' => $this->contact->id,
                'contact_shared_user_id' => $this->userId
            ];
        (new SharedContact($allItems))->save();
    }

    public function render()
    {
        return view('livewire.share-form', ['users' => User::where('id', '!=', Auth::id())->orderBy('name')->get()]);
    }
}
