<?php

namespace EscolaLms\AssignWithoutAccount\Database\Factories;

use EscolaLms\AssignWithoutAccount\Enums\UserSubmissionEnum;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserSubmissionFactory extends Factory
{
    protected $model = UserSubmission::class;

    public function definition()
    {
        return [
            'access_url_id' => AccessUrl::factory(),
            'email' => $this->faker->email,
            'frontend_url' => $this->faker->url,
            'status' => $this->faker->randomElement(UserSubmissionEnum::getValues())
        ];
    }
}
