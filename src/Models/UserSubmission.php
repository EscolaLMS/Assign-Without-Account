<?php

namespace EscolaLms\AssignWithoutAccount\Models;

use EscolaLms\AssignWithoutAccount\Database\Factories\UserSubmissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'status',
        'morphable_type',
        'morphable_id'
    ];

    protected $casts = [
        'email' => 'string',
        'status' => 'string',
        'morphable_type' => 'string',
        'morphable_id' => 'integer'
    ];

    public function morphable(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function newFactory(): UserSubmissionFactory
    {
        return UserSubmissionFactory::new();
    }
}
