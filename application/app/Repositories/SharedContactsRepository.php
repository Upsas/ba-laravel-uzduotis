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

    public function getSharedContactsWithPagination(int $perPage = 6): LengthAwarePaginator
    {
        return SharedContact::where('shared_contacts.user_id', Auth::id())
            ->orWhere('shared_contacts.contact_shared_user_id', Auth::id())
            ->join('contacts', 'contacts.id', '=', 'shared_contacts.contact_id')->orderBy('name')
            ->paginate($perPage);
    }

    public function getSharedContactsForApi(int $perPage)
    {

        return SharedContact::where('shared_contacts.user_id', Auth::id())
            ->orWhere('shared_contacts.contact_shared_user_id', Auth::id())
            ->leftJoin('contacts', 'contacts.id', '=', 'shared_contacts.contact_id')
            ->join('users', 'users.id', '=', 'shared_contacts.contact_shared_user_id')
            ->select('shared_contacts.user_id as UserId', 'shared_contacts.id', 'contacts.name as ContactName', 'contacts.number', 'users.name as Contact Shared With')
            ->orderBy('contacts.name')
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
        if (SharedContact::where('id', $contactId)->where('user_id', Auth::id())->orWhere('contact_shared_user_id', Auth::id())->first() === null) {
            throw new Exception("there is no contact with id: $contactId");
        }
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

    /**
     * @throws Exception
     */
    public function getContactSharedWithSelf(int $sharedContactId): SharedContact
    {
        $contact = SharedContact::where('id', $sharedContactId)
            ->where('contact_shared_user_id', Auth::id())
            ->first();
        if ($contact === null) {
            throw new Exception("there is no contact with id: $sharedContactId");
        }
        return $contact;
    }

    public function search(string $searchType, string $searchKeyword, int $perPage = 6): LengthAwarePaginator
    {
        switch ($searchType) {
            case SharedContact::SEARCH_SHARED_CONTACTS:
                $searchQuerySample = SharedContact::where('shared_contacts.user_id', Auth::id())
                    ->orWhere('shared_contacts.contact_shared_user_id', Auth::id());
                break;
            case SharedContact::SEARCH_SHARED_CONTACTS_WITH_ME:
                $searchQuerySample = SharedContact::where('shared_contacts.contact_shared_user_id', Auth::id());
                break;
            case SharedContact::SEARCH_SHARED_CONTACTS_WITH_OTHERS:
                $searchQuerySample = SharedContact::where('shared_contacts.user_id', Auth::id());
                break;
        }
        return $this->searchSharedContacts($searchQuerySample, $searchKeyword, $perPage);
    }

    private function searchSharedContacts($searchQuerySample, string $searchKeyword, int $perPage): LengthAwarePaginator
    {

        return $searchQuerySample
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
