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

    use WithPagination;

    /**
     * @throws Exception
     */
    public function delete(int $contactId, ContactsRepository $contactsRepo): void
    {
        $contactsRepo->destroy($contactId);
        session()->flash('message', 'Contact successfully deleted.');
        $this->refresh();
    }

    public function edit(int $contactId): void
    {
        $this->emit('edit', $contactId);
    }

    public function render(ContactsRepository $contactsRepo): Factory|View|Application
    {
        return view('livewire.contact-show', ['contacts' => $contactsRepo->getAllContactsByUserIdWithPagination([
            'userId' => Auth::id(),
            'perPage' => 6
        ]) ]);
    }
}
