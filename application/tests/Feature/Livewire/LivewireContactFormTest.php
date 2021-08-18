<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ContactForm;
use App\Models\Contact;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireContactFormTest extends TestCase
{
    use LivewireTestHelper;

    public function testCanAddNewContact(): void
    {
        $newUser = $this->actAsUser();

        Livewire::test(ContactForm::class)
            ->set('name', 'foo')
            ->set('number', '670')
            ->call('create')
            ->assertEmitted('flashMessage')
            ->assertEmitted('refresh');

        $data = Contact::whereName('foo');
        $this->assertTrue($data->exists());

        $this->deleteContactAndUser($data, $newUser);

    }

    public function testCanUpdate(): void
    {
        $newUser = $this->actAsUser();
        $contact = $this->createContact();

        Livewire::test(ContactForm::class)
            ->set('name', 'foo')
            ->set('number', 670)
            ->set('contactId', $contact->getAttribute('id'))
            ->call('update');

        $this->assertSame('foo', Contact::where('id', $contact->id)->first()->name);
        $this->deleteContactAndUser($contact, $newUser);
    }

    public function testCanGetDataByContactIdInEdit(): void
    {

        $newUser = $this->actAsUser();
        $contact = $this->createContact();

        Livewire::test(ContactForm::class)
            ->call('edit', $contact->getAttribute('id'));
        $data = Contact::find($contact->getAttribute('id'));

        $this->assertTrue($data->exists());
        $this->deleteContactAndUser($data, $newUser);

    }

    public function testValidationNumberAndName(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name')
            ->set('number', '670a')
            ->call('update')
            ->assertHasErrors(['number', 'name']);

    }
}
