<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAvatar extends Model
{
    use HasFactory;

    public function getAvatarPathAttribute($value): string
    {
        return config('app.url') . $value;
    }
}
