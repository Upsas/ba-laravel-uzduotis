<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ContactShared;
use App\Models\Contact;
use App\Models\SharedContact;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireContactSharedTest extends TestCase
{
    use LivewireTestHelper;

    private Collection|Model $user;
    private Collection|Model $contact;
    private int $contactId;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->actAsUser();
        $this->contact = $this->createContact();
        $this->contactId = $this->contact->getAttribute('id');
    }


    public function testCancelModalIsShown(): void
    {
        Livewire::test(ContactShared::class)
            ->call('cancel', $this->contactId)
            ->assertSet('showModal', true)
            ->assertSet('contactId', $this->contactId)
            ->assertSeeHtml('Stop');

    }

    public function testDeleteModalIsShown(): void
    {

        $message = 'Are you sure want to delete shared contact with you?';
        Livewire::test(ContactShared::class)
            ->call('deleteShared', $this->contactId)
            ->assertSet('message', $message)
            ->assertSet('buttonName', 'Yes')
            ->assertSet('contactId', $this->contactId)
            ->assertSet('showModal', true)
            ->assertSeeHtml($message);
    }

    public function testCanDeleteSharedContact(): void
    {

        $newUser = User::factory()->create();
        $contact = $this->createContact();
        $sharedContact = SharedContact::create([
            'user_id' => Auth::id(),
            'contact_id' => $contact->getAttribute('id'),
            'contact_shared_user_id' => $newUser->getAttribute('id')
        ]);

        Livewire::test(ContactShared::class)
            ->set('contactId', $sharedContact->getAttribute('id'))
            ->call('delete')
            ->assertEmitted('flashMessage');

        $this->assertDeleted($sharedContact);

        User::destroy($newUser->getAttribute('id'));
        $this->deleteContactAndUser($contact, $newUser);
    }

    public function testCanAddSharedContact(): void
    {
        $newUser = User::factory()->create();
        $contact = (Contact::factory(
            [
                'name' => 'testas',
                'number' => 8954,
                'user_id' => $newUser->getAttribute('id')
            ])->create());
        $sharedContact = $this->createSharedContact($newUser, $contact);

        Livewire::test(ContactShared::class)
            ->call('addContact', $contact->id,
                $sharedContact->getAttribute('id'))
            ->assertEmitted('flashMessage');

        $this->assertTrue(Contact::where('user_id', Auth::id())->first()->exists());
        $this->assertDeleted($sharedContact);
        Contact::destroy($contact->id);
        User::destroy($newUser->id);
        Contact::where('user_id', Auth::id())->first()->delete();
    }

    public function tearDown(): void
    {
        $this->deleteContactAndUser($this->contact, $this->user);
    }

}
