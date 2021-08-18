<?php

namespace App\Http\Livewire;

use App\Repositories\ContactsRepository;
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

    public function delete(): void
    {
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
