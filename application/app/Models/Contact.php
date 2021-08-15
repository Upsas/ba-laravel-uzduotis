<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $number
 * @property int $user_id
 */

class Contact extends Model
{
    use HasFactory;

    protected $guarded = [];
}
