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

class ApiContactsControllerTest extends TestCase
{
    private MockObject|ContactsRepository $contactsRepo;
    private ApiContactsController $apiContactsController;

    /**
     * @throws JsonException
     */
    public function testCanShowAllContacts(): void
    {
        $data = new Contact([
            'name' => 'test'
        ]);
        $paginate = new LengthAwarePaginator(
            $data,
            count([$data]),
            10,
            1
        );

        $this->contactsRepo->method('getAllContactsByUserIdWithPagination')
            ->willReturn($paginate);
        $result = $this->apiContactsController->index();
        $resultJsonDecode = json_decode($result->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertEquals($data->name, $resultJsonDecode['data']['name']);
        $this->assertSame(200, $result->status());
    }

    /**
     * @throws Exception
     */
    public function testCanStoreContact(): void
    {
        $data = [
            'name' => 'test',
            'number' => 8679632,
            'user_id' => 1
        ];

        $request = new StoreContactRequest(attributes: $data);
        $validator = $this->createMock(Validator::class);
        $request->setValidator($validator);
        $validator->method('validated')->willReturn($data);
        $this->contactsRepo->method('create')->willReturn(new Contact($data));
        $result = $this->apiContactsController->store($request);
        $resultJsonToArray = (json_decode($result->getContent(), true, 512, JSON_THROW_ON_ERROR));
        $this->assertSame($data, $resultJsonToArray);
        $this->assertSame(201, $result->status());
    }

    /**
     * @throws Exception
     */
    public function testCanShowOneContactById(): void
    {
        $data = new Contact([
            'id' => 1,
            'name' => 'test',
            'number' => 8679632,
            'user_id' => 1
        ]);
        $this->contactsRepo->method('findOneById')->willReturn($data);
        $result = $this->apiContactsController->show($data->id);
        $resultJsonToArray = (json_decode($result->getContent(), true, 512, JSON_THROW_ON_ERROR));
        $this->assertSame($data->toArray(), $resultJsonToArray);
        $this->assertSame(200, $result->status());
    }

    /**
     * @throws Exception
     */
    public function testShowOneContactByIdReturnNotFoundMessage(): void
    {
        $message = 'failed to find record with id 5';
        $this->contactsRepo->method('findOneById')->willThrowException(new Exception($message));
        $result = $this->apiContactsController->show(5);
        $resultJsonDecode = (json_decode($result->getContent(), true));
        $this->assertSame($message, $resultJsonDecode['message']);
    }


    protected function setUp(): void
    {
        parent::setUp();
        $this->contactsRepo = $this->createMock(ContactsRepository::class);
        $this->apiContactsController = new ApiContactsController($this->contactsRepo);
    }
}
