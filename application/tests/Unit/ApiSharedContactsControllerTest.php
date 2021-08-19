<?php

namespace Tests\Unit;

use App\Http\Controllers\ApiContactsController;
use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Repositories\ContactsRepository;
use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use JsonException;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class ApiSharedContactsControllerTest extends TestCase
{
    private ApiContactsController $apiContactsController;
    private MockObject|ContactsRepository $sharedContactsRepo;


    protected function setUp(): void
    {
        parent::setUp();
        $this->sharedContactsRepo = $this->createMock(ContactsRepository::class);
        $this->apiContactsController = new ApiContactsController($this->sharedContactsRepo);
    }
}
