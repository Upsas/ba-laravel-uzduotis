<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedContact extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getSharedContact(): Model
    {
        return $this->hasMany(Contact::class, 'id', 'contact_id')->first();
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
