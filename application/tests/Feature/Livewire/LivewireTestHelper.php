<?php


namespace Tests\Feature\Livewire;


use App\Models\Contact;
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

    public function deleteContactAndUser($contact, $newUser): void
    {
        Contact::destroy($contact->latest()->first()->id);
        User::destroy($newUser->getAttribute('id'));
    }
}
