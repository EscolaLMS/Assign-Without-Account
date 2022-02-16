<?php

namespace EscolaLms\AssignWithoutAccount\Tests\Api;

use EscolaLms\AssignWithoutAccount\Enums\UserSubmissionEnum;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use EscolaLms\AssignWithoutAccount\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;

class UserSubmissionTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function testCreateUserSubmission(): void
    {
        $email = $this->faker->email;
        $accessUrl = AccessUrl::factory()->create();

        $this->response = $this->json('POST', '/api/user-submissions/' . $accessUrl->url, [
            'email' => $email
        ])->assertOk();

        $this->assertDatabaseHas('user_submissions', [
            'email' => $email,
            'access_url_id' => $accessUrl->getKey(),
            'status' => UserSubmissionEnum::EXPECTED
        ]);
    }

    public function testCreateUserSubmissionInvalidUrl(): void
    {
        $this->response = $this->json('POST', '/api/user-submissions/' . $this->faker->slug, [
            'email' => $this->faker->email
        ])->assertNotFound();
    }

    public function testIndexUserSubmission(): void
    {
        $this->authenticateAsAdmin();
        UserSubmission::factory()->count(5)->create();

        $this->response = $this->actingAs($this->user, 'api')
            ->json('GET', '/api/admin/user-submissions')
            ->assertOk();

        $this->response->assertJsonStructure([
            'data' => [[
                'id',
                'email',
                'status',
                'url',
                'modelable_id',
                'modelable_type',
                'created_at',
            ]]
        ]);
        $this->response->assertJsonCount(5, 'data');
    }
}
