<?php

namespace EscolaLms\AssignWithoutAccount\Providers;

use EscolaLms\AssignWithoutAccount\Http\Resources\AccessUrlResource;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use Illuminate\Support\ServiceProvider;

class ExtendedResourcesServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        $extendResource = function ($thisObj) {
            $class = get_class($thisObj->resource);
            $id = $thisObj->id;

            $resource = AccessUrl::query()
                ->where('modelable_type', $class)
                ->where('modelable_id', $id)
                ->first();

            return [
                'access' => empty($resource) ? [] : AccessUrlResource::make($resource)
            ];
        };

        if (class_exists(\EscolaLms\Courses\EscolaLmsCourseServiceProvider::class)) {
            \EscolaLms\Courses\Http\Resources\Admin\CourseWithProgramAdminResource::extend($extendResource);
            \EscolaLms\Courses\Http\Resources\CourseSimpleResource::extend($extendResource);
        }
    }


}
