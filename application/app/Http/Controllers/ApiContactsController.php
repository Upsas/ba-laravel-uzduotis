<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Repositories\ContactsRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ApiContactsController extends Controller
{
    public function __construct(
        private ContactsRepository $contactsRepository
    )
    {
    }

    public function index(): Application|ResponseFactory|Response|LengthAwarePaginator
    {
        $data = $this->contactsRepository->getAllContactsByUserIdWithPagination(['userId' => Auth::id(), 'perPage' => 12]);
        if ($data->isEmpty()) {
            return response(['message' => 'There is no contacts']);
        }
        return $data;
    }

    /**
     * @throws Exception
     */
    public function store(StoreContactRequest $request): Response|Application|ResponseFactory
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();
        try {
            $createdContact = $this->contactsRepository->create(new Contact($validatedData));
        } catch (Exception $e) {
            return \response(['message' => $e->getMessage()]);
        }
        return \response([$createdContact],201);
    }

    /**
     * @throws Exception
     */
    public function show($id): Response
    {
        try {
        $contact = $this->contactsRepository->findOneById((int)$id);
        } catch (Exception $e) {
            return \response(['message' => $e->getMessage()]);
        }
        return \response([$contact]);
    }

    /**
     * @throws Exception
     */
    public function update(StoreContactRequest $request, $id): Response
    {
        $validatedData = ($request->validated());
        $validatedData['user_id'] = Auth::id();
        try {
            $this->contactsRepository->update((int)$id, $validatedData);
        } catch (Exception $e) {
            return \response(['message' => $e->getMessage()]);
        }
        return response(['message' => 'Record successfully updated']);
    }

    /**
     * @throws Exception
     */
    public function destroy($id): Response
    {
        try{
        $this->contactsRepository->destroy((int)$id);
        } catch (Exception $e) {
            return \response(['message' => $e->getMessage()]);
        }
        return \response(['message' => 'Contact deleted successfully']);
    }

    public function search(string $queryParam): Response|Application|ResponseFactory
    {
        $data = $this->contactsRepository->searchContacts($queryParam, 12);
        if ($data->isEmpty()) {
            return \response(['message' => 'no contacts were found']);
        }
        return \response($data);
    }


}
