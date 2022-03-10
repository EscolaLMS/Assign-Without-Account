<?php

namespace EscolaLms\AssignWithoutAccount\Tests\Api;

use EscolaLms\AssignWithoutAccount\Database\Seeders\AssignWithoutAccountPermissionSeeder;
use EscolaLms\AssignWithoutAccount\Enums\UserSubmissionStatusEnum;
use EscolaLms\AssignWithoutAccount\Events\AssignToProduct;
use EscolaLms\AssignWithoutAccount\Events\AssignToProductable;
use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use EscolaLms\AssignWithoutAccount\Tests\TestCase;
use EscolaLms\Cart\Facades\Shop;
use EscolaLms\Cart\Models\Product;
use EscolaLms\Cart\Tests\Mocks\ExampleProductable;
use EscolaLms\Core\Tests\CreatesUsers;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\TestResponse;

class UserSubmissionAdminTest extends TestCase
{
    use DatabaseTransactions, WithFaker, CreatesUsers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AssignWithoutAccountPermissionSeeder::class);
    }

    public function testIndexUserSubmission(): void
    {
        $admin = $this->makeAdmin();
        UserSubmission::factory()->count(10)->create();

        $response = $this->actingAs($admin, 'api')
            ->json('GET', '/api/admin/user-submissions')
            ->assertOk();

        $this->assertApiIndexResponse($response, 10);
        $this->assertDatabaseCount('user_submissions', 10);
    }

    public function testIndexFilterByMorphType(): void
    {
        $admin = $this->makeAdmin();
        $morphableType = 'EscolaLms\\Test\\Models\\Test';
        UserSubmission::factory()->count(10)->create();
        UserSubmission::factory()->count(5)->create([
            'morphable_type' => $morphableType
        ]);

        $response = $this->actingAs($admin, 'api')
            ->json('GET', '/api/admin/user-submissions?morphable_type=' . $morphableType)
            ->assertOk();

        $this->assertApiIndexResponse($response, 5);
        $this->assertDatabaseCount('user_submissions', 15);
    }

    public function testIndexFilterByMorph(): void
    {
        $admin = $this->makeAdmin();

        $morphableId = 1;
        $morphableType = 'EscolaLms\\Test\\Models\\Test';
        UserSubmission::factory()->count(10)->create();
        UserSubmission::factory()->count(5)->create([
            'morphable_id' => $morphableId,
            'morphable_type' => $morphableType
        ]);
        UserSubmission::factory()->count(5)->create([
            'morphable_type' => $morphableType
        ]);

        $response = $this->actingAs($admin, 'api')
            ->json('GET', '/api/admin/user-submissions?morphable_id=' . $morphableId . '&morphable_type=' . $morphableType)
            ->assertOk();

        $this->assertApiIndexResponse($response, 5);
        $this->assertDatabaseCount('user_submissions', 20);
    }

    public function testIndexFilterByMorphId(): void
    {
        $admin = $this->makeAdmin();

        $morphableId = 1;
        UserSubmission::factory()->count(5)->create();
        UserSubmission::factory()->count(5)->create([
            'morphable_id' => $morphableId,
        ]);

        $response = $this->actingAs($admin, 'api')
            ->json('GET', '/api/admin/user-submissions?morphable_id=' . $morphableId)
            ->assertOk();

        $this->assertApiIndexResponse($response, 10);
        $this->assertDatabaseCount('user_submissions', 10);
    }

    public function testIndexFilterByEmail(): void
    {
        $admin = $this->makeAdmin();

        $email = 'test@test.pl';
        UserSubmission::factory()->count(10)->create();
        UserSubmission::factory()->count(5)->create([
            'email' => $email,
        ]);

        $response = $this->actingAs($admin, 'api')
            ->json('GET', '/api/admin/user-submissions?email=' . $email)
            ->assertOk();

        $this->assertApiIndexResponse($response, 5);
        $this->assertDatabaseCount('user_submissions', 15);
    }

    public function testIndexFilterByStatus(): void
    {
        $admin = $this->makeAdmin();
        UserSubmission::factory()->count(10)->create([
            'status' => UserSubmissionStatusEnum::ACCEPTED
        ]);
        UserSubmission::factory()->count(5)->create([
            'status' => UserSubmissionStatusEnum::SENT
        ]);

        $response = $this->actingAs($admin, 'api')
            ->json('GET', '/api/admin/user-submissions?status=' . UserSubmissionStatusEnum::SENT)
            ->assertOk();

        $this->assertApiIndexResponse($response, 5);
        $this->assertDatabaseCount('user_submissions', 15);
    }

    public function testCreateUserSubmissionToProduct()
    {
        Event::fake();

        $admin = $this->makeAdmin();
        $product = Product::factory()->create();
        $email = 'test@test.pl';

        $response = $this->actingAs($admin, 'api')
            ->json('POST', '/api/admin/user-submissions', [
                'email' => $email,
                'morphable_id' => $product->getKey(),
                'morphable_type' => Product::class,
            ])
            ->assertCreated();

        $response->assertJsonFragment([
            'email' => $email,
            'morphable_id' => $product->getKey(),
            'morphable_type' => Product::class,
            'status' => UserSubmissionStatusEnum::SENT,
        ]);
        $this->assertDatabaseHas('user_submissions', [
            'email' => $email,
            'morphable_id' => $product->getKey(),
            'morphable_type' => Product::class,
            'status' => UserSubmissionStatusEnum::SENT
        ]);

        Event::assertDispatched(AssignToProduct::class);
        Event::assertNotDispatched(AssignToProductable::class);
    }

    public function testCreateUserSubmissionToProductable()
    {
        Event::fake();
        Shop::registerProductableClass(ExampleProductable::class);

        $exampleProductable = ExampleProductable::factory()->create();
        $admin = $this->makeAdmin();
        $email = 'test@test.pl';

        $response = $this->actingAs($admin, 'api')
            ->json('POST', '/api/admin/user-submissions', [
                'email' => $email,
                'morphable_id' => $exampleProductable->getKey(),
                'morphable_type' => ExampleProductable::class,
            ])
            ->assertCreated();

        $response->assertJsonFragment([
            'email' => $email,
            'morphable_id' => $exampleProductable->getKey(),
            'morphable_type' => ExampleProductable::class,
            'status' => UserSubmissionStatusEnum::SENT,
        ]);
        $this->assertDatabaseHas('user_submissions', [
            'email' => $email,
            'morphable_id' => $exampleProductable->getKey(),
            'morphable_type' => ExampleProductable::class,
            'status' => UserSubmissionStatusEnum::SENT
        ]);

        Event::assertDispatched(AssignToProductable::class);
        Event::assertNotDispatched(AssignToProduct::class);
    }

    public function testCreateUserSubmissionToNotRegisteredProductable()
    {
        Event::fake();

        $exampleProductable = ExampleProductable::factory()->create();
        $admin = $this->makeAdmin();
        $email = 'test@test.pl';

        $this->actingAs($admin, 'api')
            ->json('POST', '/api/admin/user-submissions', [
                'email' => $email,
                'morphable_id' => $exampleProductable->getKey(),
                'morphable_type' => ExampleProductable::class,
            ]);

        Event::assertNotDispatched(AssignToProductable::class);
    }

    public function testCreateUserSubmissionInvalidData()
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin, 'api')
            ->json('POST', '/api/admin/user-submissions', [])
            ->assertUnprocessable();
    }

    public function testCreateUserSubmissionUnauthorizedUser()
    {
        $this->json('POST', '/api/admin/user-submissions', [])
            ->assertUnauthorized();
    }

    private function assertApiIndexResponse(TestResponse $response, int $count): void
    {
        $response->assertJsonCount($count, 'data');
        $response->assertJsonStructure([
            'data' => [[
                'email',
                'morphable_id',
                'morphable_type',
                'status',
                'created_at'
            ]]
        ]);
    }
}
