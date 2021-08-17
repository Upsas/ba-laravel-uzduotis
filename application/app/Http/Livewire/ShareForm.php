<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use App\Models\SharedContact;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShareForm extends Component
{

    public $showShareForm = 'hidden';
    public $userId;
    public Contact $contact;
    protected $listeners = ['showShareForm'];

    public function showShareForm(int $contactId)
    {
        $this->showShareForm = 'flex';
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
        $this->emit('flashMessage', 'Contact successfully shared.', 'purple');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.share-form', ['users' => User::where('id', '!=', Auth::id())->orderBy('name')->get()]);
    }
}
