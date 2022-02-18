<?php

namespace EscolaLms\AssignWithoutAccount\Tests\Api;

use EscolaLms\AssignWithoutAccount\Enums\UserSubmissionEnum;
use EscolaLms\AssignWithoutAccount\Events\UserSubmissionAccepted;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use EscolaLms\AssignWithoutAccount\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;

class UserSubmissionAdminTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

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
                'frontend_url',
                'status',
                'url',
                'modelable_id',
                'modelable_type',
                'created_at',
            ]]
        ]);
        $this->response->assertJsonCount(5, 'data');
    }

    public function testAcceptUserSubmission()
    {
        Event::fake([UserSubmissionAccepted::class]);

        $this->authenticateAsAdmin();
        $userSubmission = UserSubmission::factory()->create([
            'status' => UserSubmissionEnum::EXPECTED
        ]);

        $this->response = $this->actingAs($this->user, 'api')
            ->json('GET', '/api/admin/user-submissions/accept/' . $userSubmission->getKey())
            ->assertOk();

        Event::assertDispatched(UserSubmissionAccepted::class);
        $this->assertDatabaseHas('user_submissions', [
            'id' => $userSubmission->getKey(),
            'status' => UserSubmissionEnum::ACCEPTED,
        ]);
    }

    public function testRejectUserSubmission()
    {
        Event::fake([UserSubmissionAccepted::class]);

        $this->authenticateAsAdmin();

        $userSubmission = UserSubmission::factory()->create([
            'status' => UserSubmissionEnum::EXPECTED
        ]);

        $this->response = $this->actingAs($this->user, 'api')
            ->json('GET', '/api/admin/user-submissions/reject/' . $userSubmission->getKey())
            ->assertOk();

        Event::assertNotDispatched(UserSubmissionAccepted::class);
        $this->assertDatabaseHas('user_submissions', [
            'id' => $userSubmission->getKey(),
            'status' => UserSubmissionEnum::REJECTED,
        ]);
    }
}
