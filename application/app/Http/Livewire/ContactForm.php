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
    public $flashMessageColor = 'green';

    protected $listeners = ['edit'];

    protected $rules = [
        'name' => 'required|string',
        'number' => 'required|regex:/^(?=.*[0-9])[- +()0-9.]+$/'
    ];

    /**
     * @throws Exception
     */
    public function create(ContactsRepository $contactsRepo): void
    {
        $validatedData = $this->validate();
        $validatedData['user_id'] = Auth::id();
        $contactsRepo->create(new Contact($validatedData));
        $this->flashMessageColor = 'green';
        session()->flash('message', 'Contact successfully created.');
        $this->emit('refresh');
        $this->reset();
    }

    /**
     * @throws Exception
     */
    public function edit(int $contactId, ContactsRepository $contactsRepo): void
    {
        $data = $contactsRepo->findOneById($contactId);

        $this->show = 'flex';
        $this->method = 'update';
        $this->title = 'Update contact';
        $this->button = 'update';
        $this->contactId = $contactId;
        $this->name = $data->name;
        $this->number = $data->number;
    }

    public function update(ContactsRepository $contactsRepo): void
    {

        $validatedData = ($this->validate());
        $validatedData['user_id'] = Auth::id();
        $contactsRepo->findOneById($this->contactId)->update($validatedData);
        session()->flash('message', 'Contact successfully updated.');
        $this->reset();
        $this->flashMessageColor = 'blue';
        $this->emit('refresh');
    }

    public function add(): void
    {
        $this->reset();
        $this->show = 'flex';
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.contact-form');
    }
}
