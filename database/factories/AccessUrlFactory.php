<?php

namespace EscolaLms\AssignWithoutAccount\Database\Factories;

use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AccessUrlFactory extends Factory
{
    protected $model = AccessUrl::class;

    public function definition()
    {
        $type = Str::ucfirst($this->faker->word) . $this->faker->numberBetween();

        return [
            'url' => $this->faker->slug,
            'modelable_id' => $this->faker->numberBetween(1, 100),
            'modelable_type' => 'EscolaLms\\' . $type . '\\Models\\' . $type,
        ];
    }
}
