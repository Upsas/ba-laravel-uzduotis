<?php

namespace App\Repositories;

use App\Models\Contact;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactsRepository
{
    /**
     * @throws Exception
     */
    public function create(Contact $contact): Contact
    {
        if (!$contact->save()) {
            throw new Exception('failed to create new record');
        }
        return $contact;
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
        if (!Contact::destroy($contactId)) {
            throw new Exception("failed to delete record with id $contactId");
        }
    }

    /**
     * @throws Exception
     */
    public function findOneById(int $contactId): Contact
    {
        $contact = Contact::find($contactId);
        if (is_null($contact)) {
            throw new Exception("failed to find record with id $contactId");
        }
        return $contact;
    }

}
