<?php

namespace App\Http\Livewire;

use App\Repositories\SharedContactsRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ContactShared extends Component
{
    use WithPagination;

    public $showModal = false;
    public $contactId;
    public $contactSearchKeyword;
    public $message = 'Are you sure want to stop sharing?';
    public $buttonName = 'Stop';
    protected $listeners = ['delete'];

    public function cancel(int $contactId): void
    {
        $this->reset('buttonName', 'message');
        $this->contactId = $contactId;
        $this->showModal = true;
    }

    public function deleteShared(int $contactId): void
    {
        $this->message = 'Are you sure want to delete shared contact with you?';
        $this->buttonName = 'Yes';
        $this->contactId = $contactId;
        $this->showModal = true;
    }

    /**
     * @throws Exception
     */
    public function delete(SharedContactsRepository $sharedContactsRepo): void
    {
        $sharedContactsRepo->destroy($this->contactId);
        $this->emit('flashMessage', 'Contact successfully stopped shared.', 'red');
        $this->reset();
    }

    /**
     * @throws Exception
     */
    public function addContact(int $contactId, int $sharedContactId, SharedContactsRepository $sharedContactsRepo): void
    {
        $sharedContactsRepo->addSharedContact($contactId);
        $sharedContactsRepo->destroy($sharedContactId);
        $this->emit('flashMessage', 'Contact successfully added to your contact list.', 'green');

    }

    public function render(SharedContactsRepository $sharedContactsRepo): Factory|View|Application
    {
        $this->setContactsAndSearch($sharedContactsRepo);
        return view('livewire.contact-shared', [
            'contacts' => $this->contacts
        ]);
    }

    public function setContactsAndSearch(SharedContactsRepository $sharedContactsRepo)
    {
        if ($this->contactSearchKeyword === null) {
            $this->contacts = $sharedContactsRepo->getSharedContactsWithPagination(6);
        } else {
            $this->contacts = $sharedContactsRepo->searchSharedContacts($this->contactSearchKeyword, 6);
        }
    }
}
