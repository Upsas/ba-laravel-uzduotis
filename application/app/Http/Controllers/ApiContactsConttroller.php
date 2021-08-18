<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Repositories\ContactsRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ApiContactsConttroller extends Controller
{
    public function __construct(private ContactsRepository $contactsRepository)
    {}


    public function index(): Application|ResponseFactory|Response|LengthAwarePaginator
    {
        $data = $this->contactsRepository->getAllContactsByUserIdWithPagination(['userId' => Auth::id(), 'perPage' => 12]);
        if($data->isEmpty()) {
            return response(['message' => 'There is no contacts']);
        }
        return $data;
    }


    public function store(StoreContactRequest $request): Response|Application|ResponseFactory
    {
       $validatedData = $request->validated();
       $validatedData['user_id'] = Auth::id();
      $createdContact = $this->contactsRepository->create(new Contact($validatedData));
      return \response([
          $createdContact
      ], 201);
    }

    /**
     * @throws Exception
     */
    public function show($id): Response
    {
       $contact = $this->contactsRepository->findOneById((int)$id);
       return \response([
           $contact
       ]);
    }


    /**
     * @throws Exception
     */
    public function update(StoreContactRequest $request, $id): Response
    {
        $validatedData = ($request->validated());
        $validatedData['user_id'] = Auth::id();
        $this->contactsRepository->update((int)$id, $validatedData);
        return response([
            'message' => 'Record successfully updated'
        ]);
    }


    /**
     * @throws Exception
     */
    public function destroy($id): Response
    {
        $this->contactsRepository->destroy((int)$id);
        return \response([
            'message' => 'Contact deleted successfully'
        ]);
    }
}
