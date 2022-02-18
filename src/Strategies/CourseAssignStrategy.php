<?php

namespace EscolaLms\AssignWithoutAccount\Strategies;

use EscolaLms\AssignWithoutAccount\Strategies\Contracts\AssignStrategy;
use EscolaLms\Courses\Models\Course;
use EscolaLms\Courses\Services\Contracts\CourseServiceContract;
use Illuminate\Contracts\Auth\Authenticatable;

class CourseAssignStrategy implements AssignStrategy
{
    public function assign(Authenticatable $user, int $modelId): bool
    {
        $service = app(CourseServiceContract::class);
        $course = Course::find($modelId);

        if (!$course) {
            return false;
        }

        $service->addAccessForUsers($course, [$user->getKey()]);

        return true;
    }
}
