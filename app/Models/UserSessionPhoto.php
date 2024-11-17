<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSessionPhoto extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function userSession(): BelongsTo
    {
        return $this->belongsTo(UserSession::class);
    }
}
