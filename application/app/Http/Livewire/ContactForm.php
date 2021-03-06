<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use App\Repositories\ContactsRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class ContactForm extends Component
{
    public $name;
    public $number;
    public $contactId;
    public $show = 'hidden';
    public $method = 'create';
    public $title = 'Add new contact';
    public $button = 'add';

    protected $listeners = ['edit'];

    protected $rules = Contact::STORE_CONTACT_RULES;

    /**
     * @throws Exception
     */
    public function create(ContactsRepository $contactsRepo): void
    {
        $validatedData = $this->validate();
        $validatedData['user_id'] = Auth::id();
        $contactsRepo->create(new Contact($validatedData));
        $this->emit('flashMessage', 'Contact successfully created.', 'green');
        $this->emit('refresh');
        $this->reset();
    }

    /**
     * @throws Exception
     */
    public function edit(int $contactId, ContactsRepository $contactsRepo): void
    {
        $this->resetValidation();
        $data = $contactsRepo->findOneById($contactId);

        $this->show = 'flex';
        $this->method = 'update';
        $this->title = 'Update contact';
        $this->button = 'update';
        $this->contactId = $contactId;
        $this->name = $data->name;
        $this->number = $data->number;
    }

    /**
     * @throws Exception
     */
    public function update(ContactsRepository $contactsRepo): void
    {

        $validatedData = ($this->validate());
        $validatedData['user_id'] = Auth::id();
        $contactsRepo->update($this->contactId, $validatedData);
        $this->emit('flashMessage', 'Contact successfully updated.', 'blue');
        $this->reset();
        $this->emit('refresh');
    }

    public function add(): void
    {
        $this->reset();
        $this->resetValidation();
        $this->show = 'flex';
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.contact-form');
    }
}
