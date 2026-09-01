<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'billing_officer_id', 'amount', 'status', 'due_date'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}