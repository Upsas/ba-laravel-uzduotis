<?php

namespace Tests\Unit;

use App\Http\Controllers\ApiSharedContactsController;
use App\Models\Contact;
use App\Models\User;
use App\Repositories\SharedContactsRepository;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class ApiSharedContactsControllerTest extends TestCase
{
    private ApiSharedContactsController $apisharedContactsController;
    private SharedContactsRepository|MockObject $sharedContactsRepo;

    /**
     * @throws Exception
     */
    public function testGetSharedContacts(): void
    {
        $newUser = User::factory(['name' => 'test'])->create();
        $this->actingAs($newUser);
        $data = (new Contact([
            'name' => 'New contact',
            'number' => 86,
            'Contact Shared With' => 'test',
            'UserId' => $newUser->getAttribute('id')
        ]));

        $paginate = new LengthAwarePaginator(
            [$data],
            count([$data]),
            10,
            1
        );
        $this->sharedContactsRepo->method('getSharedContactsForApi')->willReturn($paginate);
        $result = $this->apisharedContactsController->getSharedContacts();
        $jsonDecodeResult = (json_decode($result->getContent(), true)['data']);
        $this->assertArrayNotHasKey('UserId', $jsonDecodeResult);
        $this->assertSame("ME From: $newUser->name", $jsonDecodeResult[0]['Contact Shared With']);
        User::destroy($newUser->getAttribute('id'));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->sharedContactsRepo = $this->createMock(SharedContactsRepository::class);
        $this->apisharedContactsController = new ApiSharedContactsController($this->sharedContactsRepo);
    }
}
