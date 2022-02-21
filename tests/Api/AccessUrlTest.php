<?php

namespace EscolaLms\AssignWithoutAccount\Tests\Api;

use EscolaLms\AssignWithoutAccount\Database\Seeders\AssignWithoutAccountPermissionSeeder;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use EscolaLms\AssignWithoutAccount\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;

class AccessUrlTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AssignWithoutAccountPermissionSeeder::class);
    }

    public function testCreateAccessUrl(): void
    {
        $this->authenticateAsAdmin();

        $payload = $this->createAccessUrl();

        $this->assertDatabase($payload);
    }

    public function testGuestCannotCreateAccessUrl()
    {
        $this->authenticatedUser();
        $this->response = $this
            ->actingAs($this->user, 'api')
            ->json('POST', '/api/admin/access-url', [])
            ->assertForbidden();
    }

    public function testCreateAccessUrlInvalidData(): void
    {
        $this->authenticateAsAdmin();

        $payload = [[
            'url' => $this->faker->slug . $this->faker->numberBetween(),
            'modelable_id' => $this->faker->numberBetween(),
            'modelable_type' => $this->faker->word,
        ]];

        $this->response = $this->actingAs($this->user, 'api')->json('POST', '/api/admin/access-url', $payload);
        $this->response->assertUnprocessable();
    }

    public function testDuplicateAccessUrl(): void
    {
        $this->authenticateAsAdmin();

        $payload = $this->createAccessUrl();
        $this->response = $this->actingAs($this->user, 'api')->json('POST', '/api/admin/access-url', $payload);
        $this->response->assertUnprocessable();
    }

    public function testUpdateAccessUrl(): void
    {
        $this->authenticateAsAdmin();

        $payload = $this->createAccessUrl();

        $payload['url'] = $this->faker->slug . $this->faker->numberBetween();

        $id = $this->response->getData()->data->id;
        $this->response = $this->actingAs($this->user, 'api')->json('PATCH', '/api/admin/access-url/' . $id, $payload);
        $this->response->assertOk();

        $this->response->assertJsonFragment($payload);
        $this->assertDatabase($payload);
    }

    public function testGuestCannotUpdateAccessUrl()
    {
        $this->authenticateAsAdmin();
        $this->createAccessUrl();
        $id = $this->response->getData()->data->id;

        $this->authenticatedUser();
        $this->response = $this
            ->actingAs($this->user, 'api')->json('PATCH', '/api/admin/access-url/' . $id, [])
            ->assertForbidden();
    }

    public function testUpdateAccessUrlInvalidData(): void
    {
        $this->authenticateAsAdmin();

        $this->createAccessUrl();

        $id = $this->response->getData()->data->id;
        $this->response = $this->actingAs($this->user, 'api')->json('PATCH', '/api/admin/access-url/' . $id, []);
        $this->response->assertUnprocessable();
    }

    public function testDeleteAccessUrl(): void
    {
        $this->authenticateAsAdmin();

        $payload = $this->createAccessUrl();

        $id = $this->response->getData()->data->id;
        $this->response = $this->actingAs($this->user, 'api')->json('DELETE', '/api/admin/access-url/' . $id);
        $this->response->assertOk();

        $this->assertDatabaseMissing('access_urls', $payload);
    }

    public function testDeleteAccessUrlInvalidData(): void
    {
        $this->authenticateAsAdmin();
        $this->response = $this->actingAs($this->user, 'api')->json('DELETE', '/api/admin/access-url/' . $this->faker->numberBetween());
        $this->response->assertNotFound();
    }

    public function testIndexAccessUrl()
    {
        $this->authenticateAsAdmin();
        AccessUrl::factory()->count(5)->create();

        $this->response = $this->actingAs($this->user, 'api')->json('GET', '/api/admin/access-url');

        $this->response->assertOk();
        $this->response->assertJsonStructure([
            'data' => [[
                'id',
                'url',
                'modelable_id',
                'modelable_type',
            ]]
        ]);
        $this->response->assertJsonCount(5, 'data');
    }

    public function testCannonGuestIndexAccessUrl()
    {
        $this->authenticatedUser();
        $this->response = $this->actingAs($this->user, 'api')
            ->json('GET', '/api/admin/access-url')
            ->assertForbidden();
    }

    public function testFilterAccessUrl()
    {
        $this->authenticateAsAdmin();
        $accessUrls = AccessUrl::factory()->count(5)->create();
        $accessUrl = $accessUrls->first();

        $this->response = $this->actingAs($this->user, 'api')
            ->json(
                'GET',
            '/api/admin/access-url?modelable_type=' . $accessUrl->modelable_type . '&modelable_id=' . $accessUrl->modelable_id
            );

        $this->response->assertOk();
        $this->response->assertJsonStructure([
            'data' => [[
                'id',
                'url',
                'modelable_id',
                'modelable_type',
            ]]
        ]);
        $this->response->assertJsonCount(1, 'data');
    }

    private function createAccessUrl(): array
    {
        $payload = [
            'url' => $this->faker->slug . $this->faker->numberBetween(),
            'modelable_id' => $this->faker->numberBetween(),
            'modelable_type' => $this->faker->word,
        ];

        $this->response = $this->actingAs($this->user, 'api')->json('POST', '/api/admin/access-url', $payload);
        $this->response->assertCreated();
        $this->response->assertJsonFragment($payload);

        return $payload;
    }

    private function assertDatabase($data): void
    {
        $this->assertDatabaseHas('access_urls', [
            'url' => $data['url'],
            'modelable_id' => $data['modelable_id'],
            'modelable_type' => $data['modelable_type'],
        ]);
    }
}
