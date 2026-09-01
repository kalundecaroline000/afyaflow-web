<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'dob', 'gender', 'national_id', 'phone', 'address', 'next_of_kin', 'next_of_kin_phone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}