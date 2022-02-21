<?php

namespace EscolaLms\AssignWithoutAccount\Tests\Api;

use EscolaLms\AssignWithoutAccount\Enums\UserSubmissionEnum;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use EscolaLms\AssignWithoutAccount\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;

class UserSubmissionTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function testCreateUserSubmission(): void
    {
        $email = $this->faker->email;
        $frontend_url = $this->faker->url;

        $accessUrl = AccessUrl::factory()->create();

        $this->response = $this->json('POST', '/api/user-submissions/' . $accessUrl->url, [
            'email' => $email,
            'frontend_url' => $frontend_url
        ])->assertOk();

        $this->assertDatabaseHas('user_submissions', [
            'email' => $email,
            'access_url_id' => $accessUrl->getKey(),
            'status' => UserSubmissionEnum::EXPECTED,
            'frontend_url' => $frontend_url
        ]);
    }

    public function testCreateUserSubmissionInvalidUrl(): void
    {
        $this->response = $this->json('POST', '/api/user-submissions/' . $this->faker->slug, [
            'email' => $this->faker->email,
            'frontend_url' => $this->faker->url
        ])->assertNotFound();
    }
}
