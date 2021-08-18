<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\SharedContact;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ContactsRepository
{
    /**
     * @throws Exception
     */
    public function create(Contact $contact): Contact
    {

        if (!Contact::where('number', $contact->number)->where('user_id', Auth::id())->get()->isEmpty()) {
            throw new Exception('failed to create because number is duplicate');
        }

        if (!$contact->save()) {
            throw new Exception('failed to create new record');
        }
        return $contact;
    }

    /**
     * @throws Exception
     */
    public function update(int $contactId, array $data): void
    {
        $this->findOneById($contactId)->update($data);
    }

    /**
     * @param array $params (userId, perPage)
     * @return LengthAwarePaginator|null
     */
    public function getAllContactsByUserIdWithPagination(array $params): ?LengthAwarePaginator
    {
        return Contact::where('user_id', $params['userId'])->orderBy('name')->paginate($params['perPage']);
    }

    /**
     * @throws Exception
     */
    public function destroy(int $contactId): void
    {
        if(Contact::where('id', $contactId)->where('user_id', Auth::id())->first() === null)
        {
            throw new Exception("there is no contact with id: $contactId");
        }
        SharedContact::where('contact_id', $contactId)->delete();
        if (!Contact::destroy($contactId)) {
            throw new Exception("failed to delete record with id $contactId");
        }
    }

    /**
     * @throws Exception
     */
    public function findOneById(int $contactId): Contact
    {
        $contact = Contact::where('id', $contactId)->where('user_id', Auth::id())->first();
        if (is_null($contact)) {
            throw new Exception("failed to find record with id $contactId");
        }
        return $contact;
    }

    public function searchContacts(string $searchKeyword, int $perPage): LengthAwarePaginator
    {
        return Contact::where('user_id', Auth::id())
            ->where(function ($query) use ($searchKeyword) {
                $query->where('name', 'LIKE', "%$searchKeyword%")
                    ->orWhere('number', 'LIKE', "%$searchKeyword%");
            })->orderBy('name')->paginate($perPage);
    }

}
