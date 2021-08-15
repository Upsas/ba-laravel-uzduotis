<?php

namespace Tests\Unit;

use App\Http\Livewire\ContactForm;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireContactFormTest extends TestCase
{

    public function testCanAddNewContact(): void
    {
        $newUser = User::factory()->create();
        $this->actingAs($newUser);

        Livewire::test(ContactForm::class)
            ->set('name', 'foo')
            ->set('number', '670')
            ->call('create');


        $data = Contact::whereName('foo');
        $this->assertTrue($data->exists());

        Contact::destroy($data->latest()->first()->id);
        User::destroy($newUser->getAttribute('id'));

    }
}
