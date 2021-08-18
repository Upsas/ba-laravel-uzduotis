<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ShareForm;
use App\Models\SharedContact;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireShareFormTest extends TestCase
{
    use LivewireTestHelper;

    public function testShowShareFormWithContact(): void
    {
        $user = $this->actAsUser();
        $contact = $this->createContact();

        Livewire::test(ShareForm::class)
            ->call('showShareForm', $contact->getAttribute('id'))
            ->assertSet('showShareForm', 'flex')
            ->assertNotSet('contact', null);

        $this->deleteContactAndUser($contact, $user);
    }

    public function testCanShareContact(): void
    {
        $user = $this->actAsUser();
        $contact = $this->createContact();
        $newUser = User::factory()->create();

        Livewire::test(ShareForm::class)
            ->call('showShareForm', $contact->getAttribute('id'))
            ->set('userId', $newUser->getAttribute('id'))
            ->call('share')
            ->assertEmitted('flashMessage')
            ->assertSet('showShareForm', 'hidden');

        SharedContact::where('contact_id', $contact->getAttribute('id'))->delete();
        User::destroy($newUser->getAttribute('id'));
        $this->deleteContactAndUser($contact, $user);

    }
}
