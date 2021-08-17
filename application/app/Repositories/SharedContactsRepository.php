<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\SharedContact;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class SharedContactsRepository
{

    public function __construct(private ContactsRepository $contactsRepository)
    {
    }

    public function getSharedContactsWithPagination(int $perPage): LengthAwarePaginator
    {
        return SharedContact::where('contact_shared_user_id', Auth::id())->orWhere('user_id', Auth::id())->paginate($perPage);
    }

    /**
     * @throws Exception
     */
    public function saveSharedContact(SharedContact $sharedContact): void
    {
        if (SharedContact::where($sharedContact->toArray())->get()->isEmpty()) {
            $sharedContact->save();
        } else {
            throw new Exception('You already shared contact with this person');
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(int $contactId): void
    {
        if (!SharedContact::destroy($contactId)) {
            throw new Exception("failed to stop share contact whom id: $contactId");
        }
    }

    /**
     * @throws Exception
     */
    public function addSharedContact(int $contactId): void
    {
        $contact = (Contact::find($contactId));
        $contact['user_id'] = Auth::id();
        $contact['id'] = '';
        $this->contactsRepository->create(new Contact($contact->toArray()));
    }
}
