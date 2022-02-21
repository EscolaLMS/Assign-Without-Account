<?php

namespace EscolaLms\AssignWithoutAccount\Models;

use EscolaLms\AssignWithoutAccount\Database\Factories\AccessUrlFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @OA\Schema(
 *      schema="AccessUrl",
 *      @OA\Property(
 *          property="id",
 *          description="access url id",
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="url",
 *          description="access url",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="modelable_id",
 *          description="model id",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="modelable_type",
 *          description="model type",
 *          type="string"
 *      ),
 * )
 */
class AccessUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'modelable_id',
        'modelable_type',
    ];

    protected $casts = [
        'url' => 'string',
        'modelable_id' => 'integer',
        'modelable_type' => 'string',
    ];

    public function getRouteKeyName(): string
    {
        return 'url';
    }

    public function modelable(): MorphTo
    {
        return $this->morphTo();
    }

    public function userSubmissions(): HasMany
    {
        return $this->hasMany(UserSubmission::class);
    }

    protected static function newFactory(): AccessUrlFactory
    {
        return AccessUrlFactory::new();
    }
}
