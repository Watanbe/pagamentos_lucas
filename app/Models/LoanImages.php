<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_image',
        'user_loan_id'
    ];
}
