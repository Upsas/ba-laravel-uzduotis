<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $number
 * @property int $user_id
 */

class Contact extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getSharedContact(): ?Model
    {
        return $this->hasMany(SharedContact::class, 'contact_id', 'id')->first();
    }

    public function getUserWhomSharedContact(): Model
    {
        return $this->hasMany(User::class, 'id', 'contact_shared_user_id')->first();
    }

    public function getUserWhichSharedContact(): Model
    {
        return $this->hasMany(User::class, 'id', 'user_id')->first();
    }
}
