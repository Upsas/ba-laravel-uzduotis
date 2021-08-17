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
        return SharedContact::where('shared_contacts.user_id', Auth::id())->orWhere('shared_contacts.contact_shared_user_id', Auth::id())->join('contacts', 'contacts.id', '=', 'shared_contacts.contact_id')->orderBy('name')
            ->paginate($perPage);
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

    public function searchSharedContacts(string $searchKeyword, int $perPage): LengthAwarePaginator
    {
        return SharedContact::where('shared_contacts.user_id', Auth::id())
            ->orWhere('shared_contacts.contact_shared_user_id', Auth::id())
            ->join
            ('contacts', function ($join) use ($searchKeyword) {
                $join->on('shared_contacts.contact_id', '=', 'contacts.id')
                    ->where(function ($query) use ($searchKeyword) {
                        $query->where('name', 'LIKE', "%$searchKeyword%")
                            ->orWhere('number', 'LIKE', "%$searchKeyword%");
                    });
            })->orderBy('name')->paginate($perPage);
    }

    public function searchSharedContactsWithMe(string $searchKeyword, int $perPage): LengthAwarePaginator
    {
        return SharedContact::where('shared_contacts.contact_shared_user_id', Auth::id())
            ->join
            ('contacts', function ($join) use ($searchKeyword) {
                $join->on('shared_contacts.contact_id', '=', 'contacts.id')
                    ->where(function ($query) use ($searchKeyword) {
                        $query->where('name', 'LIKE', "%$searchKeyword%")
                            ->orWhere('number', 'LIKE', "%$searchKeyword%");
                    });
            })->orderBy('name')->paginate($perPage);
    }

    public function searchSharedContactsWithOthers(string $searchKeyword, int $perPage): LengthAwarePaginator
    {
        return SharedContact::where('shared_contacts.user_id', Auth::id())
            ->join
            ('contacts', function ($join) use ($searchKeyword) {
                $join->on('shared_contacts.contact_id', '=', 'contacts.id')
                    ->where(function ($query) use ($searchKeyword) {
                        $query->where('name', 'LIKE', "%$searchKeyword%")
                            ->orWhere('number', 'LIKE', "%$searchKeyword%");
                    });
            })->orderBy('name')->paginate($perPage);
    }
}
