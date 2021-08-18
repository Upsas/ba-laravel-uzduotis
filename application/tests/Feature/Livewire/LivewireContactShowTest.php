<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ContactShow;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireContactShowTest extends TestCase
{

    use LivewireTestHelper;

    public function testCanSearchContact(): void
    {
        $newUser = $this->actAsUser();
        $contact = $this->createContact();

        Livewire::test(ContactShow::class)
            ->set('contactSearchKeyword', 'tes')
            ->call('setContactsAndSearch')
            ->assertCount('contacts', 1)
            ->set('contactSearchKeyword', 89)
            ->call('setContactsAndSearch')
            ->assertCount('contacts', 1);

        $this->deleteContactAndUser($contact, $newUser);
    }


    public function testEmittedEditShareAndDelete(): void
    {
        $newUser = $this->actAsUser();
        $contact = $this->createContact();


        Livewire::test(ContactShow::class)
            ->call('edit', $contact->getAttribute('id'))
            ->assertEmitted('edit', $contact->getAttribute('id'))
            ->call('share', $contact->getAttribute('id'))
            ->assertEmitted('showShareForm', $contact->getAttribute('id'))
            ->call('delete')
            ->assertEmitted('flashMessage');

        $this->deleteContactAndUser($contact, $newUser);

    }
}
