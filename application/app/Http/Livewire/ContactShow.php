<?php

namespace App\Http\Livewire;

use App\Models\SharedContact;
use App\Repositories\ContactsRepository;
use App\Repositories\SharedContactsRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ContactShow extends Component
{

    public $contactId;
    public $showModal = false;
    public $contactSearchKeyword;

    protected $listeners = ['refresh' => '$refresh', 'delete'];

    use WithPagination;


    public function setData(int $contactId, bool $showModal): void
    {
        $this->contactId = $contactId;
        $this->showModal = $showModal;
    }

    /**
     * @throws Exception
     */
    public function delete(int $id, ContactsRepository $contactsRepo, SharedContactsRepository $sharedContactsRepo): void
    {
        $sharedContact = SharedContact::where('user_id', Auth::id())->where('contact_id', $id)->first();
        if ($sharedContact !== null) {
            $sharedContactsRepo->destroy($sharedContact->id);
        }
        $contactsRepo->destroy($id);
        $this->emit('flashMessage', 'Contact successfully deleted.', 'red');
        $this->reset();
    }


    public function share(int $contactId): void
    {
        $this->emit('showShareForm', $contactId);
    }

    public function edit(int $contactId): void
    {
        $this->emit('edit', $contactId);
    }

    public function render(ContactsRepository $contactsRepo): Factory|View|Application
    {
        $this->setContactsAndSearch($contactsRepo);
        return view('livewire.contact-show', [
            'contacts' => $this->contacts]);
    }

    public function setContactsAndSearch(ContactsRepository $contactsRepo): void
    {
        if ($this->contactSearchKeyword === null) {
            $this->contacts = $contactsRepo->getAllContactsByUserIdWithPagination([
                'userId' => Auth::id(),
                'perPage' => 6
            ]);
        } else {
            $this->contacts = $contactsRepo->searchContacts($this->contactSearchKeyword, 6);
        }
    }
}
