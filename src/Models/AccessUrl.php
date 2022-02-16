<?php

namespace EscolaLms\AssignWithoutAccount\Models;

use EscolaLms\AssignWithoutAccount\Database\Factories\AccessUrlFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
