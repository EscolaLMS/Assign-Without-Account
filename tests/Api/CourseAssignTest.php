<?php

namespace EscolaLms\AssignWithoutAccount\Tests\Api;

use EscolaLms\AssignWithoutAccount\Database\Seeders\AssignWithoutAccountPermissionSeeder;
use EscolaLms\AssignWithoutAccount\Enums\UserSubmissionEnum;
use EscolaLms\AssignWithoutAccount\Events\UserSubmissionAccepted;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use EscolaLms\AssignWithoutAccount\Tests\TestCase;
use EscolaLms\Auth\Models\User;
use EscolaLms\Courses\Models\Course;
use Illuminate\Auth\RequestGuard;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

class CourseAssignTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('passport.client_uuids', true);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AssignWithoutAccountPermissionSeeder::class);
    }

    public function testCreateSubmissionAndRegisterAccount()
    {
        Event::fake([UserSubmissionAccepted::class]);
        Notification::fake();

        $email = 'email@test.pl';

        $course = Course::factory()->create();
        $this->createSubmissionHttp($email, $course);

        $this->acceptSubmission();

        $this->assertCount(0, $course->users()->get());

        $this->registerAccount($email);

        $this->assertCount(1, $course->users()->get());
        $this->assertTrue($course->users()->get()->contains('email', $email));
    }

    public function testCreateMultipleSubmissionsToOneCourse()
    {
        Event::fake([UserSubmissionAccepted::class]);
        Notification::fake();

        $email1 = 'email@test.pl';
        $email2 = 'email@email.com';

        $course = Course::factory()->create();
        $accessUrl = AccessUrl::factory()->create([
            'modelable_id' => $course->getKey(),
            'modelable_type' => Course::class,
        ]);

        $this->createSubmission($email1, UserSubmissionEnum::ACCEPTED, $course, $accessUrl);
        $this->createSubmission($email2, UserSubmissionEnum::ACCEPTED, $course, $accessUrl);
        $this->createSubmission($email1, UserSubmissionEnum::REJECTED, $course, $accessUrl);
        $this->createSubmission($email1, UserSubmissionEnum::EXPECTED, $course, $accessUrl);

        $this->assertCount(0, $course->users()->get());
        $this->registerAccount($email1);
        $this->registerAccount($email2);

        $this->assertCount(2, $course->users()->get());
        $this->assertTrue($course->users()->get()->contains('email', $email1));
        $this->assertTrue($course->users()->get()->contains('email', $email2));
    }

    public function testsCreateSubmissionsToMultipleCourses()
    {
        Event::fake([UserSubmissionAccepted::class]);
        Notification::fake();
        $email = 'test@test.pl';
        $course1 = Course::factory()->create();
        $course2 = Course::factory()->create();
        $course3 = Course::factory()->create();

        $this->createSubmission($email, UserSubmissionEnum::ACCEPTED, $course1);
        $this->createSubmission($email, UserSubmissionEnum::ACCEPTED, $course2);
        $this->createSubmission($email, UserSubmissionEnum::REJECTED, $course3);

        $this->assertCount(0, $course1->users()->get());
        $this->assertCount(0, $course2->users()->get());
        $this->assertCount(0, $course3->users()->get());

        $this->registerAccount($email);

        $this->assertCount(1, $course1->users()->get());
        $this->assertCount(1, $course2->users()->get());
        $this->assertCount(0, $course3->users()->get());
        $this->assertTrue($course1->users()->get()->contains('email', $email));
        $this->assertTrue($course2->users()->get()->contains('email', $email));
    }


    public function testCourseAccessResource(): void
    {
        $this->authenticateAsAdmin();
        $course = Course::factory()->create();
        AccessUrl::factory()->create([
            'modelable_id' => $course->getKey(),
            'modelable_type' => Course::class,
        ]);

        $this->response = $this->actingAs($this->user, 'api')->json('GET', '/api/courses')->assertOk();
        $this->response->assertJsonStructure([
            'data' => [[
                'access' => [
                    'id',
                    'url',
                    'modelable_id',
                    'modelable_type'
                ]
            ]]
        ]);
    }

    public function testCourseAdminAccessResource(): void
    {
        $this->authenticateAsAdmin();
        $course = Course::factory()->create();
        AccessUrl::factory()->create([
            'modelable_id' => $course->getKey(),
            'modelable_type' => Course::class,
        ]);

        $this->response = $this->actingAs($this->user, 'api')->json('GET', '/api/admin/courses')->assertOk();
        $this->response->assertJsonStructure([
            'data' => [[
                'access' => [
                    'id',
                    'url',
                    'modelable_id',
                    'modelable_type'
                ]
            ]]
        ]);
    }

    private function createSubmission(string $email, int $status, Course $course, AccessUrl $accessUrl = null): void
    {
        if (!$accessUrl) {
            $accessUrl = AccessUrl::factory()->create([
                'modelable_id' => $course->getKey(),
                'modelable_type' => Course::class,
            ]);
        }

        UserSubmission::factory()->create([
            'access_url_id' => $accessUrl->getKey(),
            'email' => $email,
            'status' => $status
        ]);
    }

    private function createSubmissionHttp(string $email, ?Course $course = null): void
    {
        if (!$course) {
            $course = Course::factory()->create();
        }

        $accessUrl = AccessUrl::factory()->create([
            'modelable_id' => $course->getKey(),
            'modelable_type' => Course::class
        ]);

        $this->response = $this->json('POST', '/api/user-submissions/' . $accessUrl->url, [
            'email' => $email,
            'frontend_url' => $this->faker->url
        ])->assertOk();
    }

    private function acceptSubmission(): void
    {
        $this->authenticateAsAdmin();
        $userSubmission = UserSubmission::first();

        $this->response = $this->actingAs($this->user, 'api')
            ->json('GET', '/api/admin/user-submissions/accept/' . $userSubmission->getKey());

        Event::assertDispatched(UserSubmissionAccepted::class);
    }

    private function registerAccount(string $email): void
    {
        $this->logout();

        $this->response = $this->json('POST', '/api/auth/register', [
            'email' => $email,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => 'password',
            'password_confirmation' => 'password',
            'return_url' => 'https://escolalms.com/email/verify',
        ])->assertOk();
    }

    private function logout(): void
    {
        RequestGuard::macro('logout', function() {
            $this->user = null;
        });

        $this->app['auth']->guard('api')->logout();
    }
}
