<?php


namespace Tests\Feature\Livewire;


use App\Models\Contact;
use App\Models\SharedContact;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LivewireTestHelper
{


    public function createContact(): Model|Collection
    {
        return (Contact::factory(
            [
                'name' => 'testas',
                'number' => 89546,
                'user_id' => Auth::id()
            ])->create());
    }

    public function actAsUser(): Model|Collection
    {
        $newUser = User::factory()->create();
        $this->actingAs($newUser);
        return $newUser;

    }

    public function createSharedContact(Model $newUser, Model $contact): Model
    {

        return SharedContact::create([
            'user_id' => $newUser->getAttribute('id'),
            'contact_id' => $contact->getAttribute('id'),
            'contact_shared_user_id' => Auth::id()
        ]);
    }

    public function deleteSharedContact(Model $sharedContact): void
    {

        SharedContact::destroy($sharedContact->getAttribute('id'));

    }

    public function deleteContactAndUser($contact, $newUser): void
    {
        Contact::destroy($contact->latest()->first()->id);
        User::destroy($newUser->getAttribute('id'));
    }
}
