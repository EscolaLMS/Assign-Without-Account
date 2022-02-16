<?php

namespace EscolaLms\AssignWithoutAccount\Models;

use EscolaLms\AssignWithoutAccount\Database\Factories\UserSubmissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'access_url_id',
        'email',
        'status',
    ];

    protected $casts = [
        'access_url_id' => 'integer',
        'email' => 'string',
        'status' => 'integer',
    ];

    public function accessUrl(): BelongsTo
    {
        return $this->belongsTo(AccessUrl::class, 'access_url_id');
    }

    protected static function newFactory(): UserSubmissionFactory
    {
        return UserSubmissionFactory::new();
    }
}
