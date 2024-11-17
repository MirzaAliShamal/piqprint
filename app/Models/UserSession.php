<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSession extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function photos(): HasMany
    {
        return $this->hasMany(UserSessionPhoto::class, 'user_session_id', 'id');
    }
}
