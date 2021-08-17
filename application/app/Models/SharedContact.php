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
        return $this->belongsTo(Contact::class, 'contact_id', 'id')->first();
    }
//
    public function getUserWhomSharedContact(): Model
    {
        return $this->belongsTo(User::class, 'contact_shared_user_id', 'id')->first();
    }

    public function getUserWhichSharedContact(): Model
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->first();
    }
}
