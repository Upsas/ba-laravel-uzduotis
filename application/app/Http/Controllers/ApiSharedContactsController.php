<?php

namespace App\Http\Controllers;

use App\Models\SharedContact;
use App\Models\User;
use App\Repositories\SharedContactsRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ApiSharedContactsController extends Controller
{
    public function __construct(
        private SharedContactsRepository $sharedContactsRepository,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function deleteSharedContact($id): Response|Application|ResponseFactory
    {
        try {
            $this->sharedContactsRepository->destroy((int)$id);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()]);
        }
        return \response(['message' => 'Contact deleted successfully']);
    }

    public function getAccountsToShare(): Response|Application|ResponseFactory
    {
        return \response([User::where('id', '!=', Auth::id())->get(['id', 'name'])]);
    }

    /**
     * @throws Exception
     */
    public function share($contactId, $userId): Response|Application|ResponseFactory
    {
        $allItems =
            [
                'user_id' => Auth::id(),
                'contact_id' => $contactId,
                'contact_shared_user_id' => $userId
            ];
        try {
            $this->sharedContactsRepository->saveSharedContact(new SharedContact($allItems));
        } catch (Exception $e) {
            return \response(['message' => $e->getMessage()]);
        }
        return \response(['message' => 'contact successfully shared'],201);
    }

    public function getSharedContacts(): Response
    {
        $data = $this->sharedContactsRepository->getSharedContactsForApi(8);
        if ($data->isEmpty()) {
            return response(['message' => 'There is no contacts']);
        }
        foreach ($data as $item) {
            if ($item['Contact Shared With'] === Auth::user()->name) {

                $name = User::where('id', $item['UserId'])->first('name');
                $item['Contact Shared With'] = "ME From: $name->name";
            }
            unset($item['UserId']);
        }
        return response($data);
    }

    /**
     * @throws Exception
     */
    public function addSharedContact($sharedContactId): Response|Application|ResponseFactory
    {
        try {
            $data = $this->sharedContactsRepository->getContactSharedWithSelf((int)$sharedContactId);
            $this->sharedContactsRepository->addSharedContact($data->contact_id);
            $this->sharedContactsRepository->destroy($sharedContactId);
        } catch (Exception $e) {
            return \response(['message' => $e->getMessage()]);
        }
        return \response(['message' => 'Shared contact successfully added'], 201);
    }

}
