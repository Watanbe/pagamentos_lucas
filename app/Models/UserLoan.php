<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_image',
        'value',
        'loan_maturity',
        'loan_description',
        'user_id',
        'loan_modality_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loanModality()
    {
        return $this->belongsTo(LoanModality::class);
    }

    public function getLoanImageAttribute($value)
    {
        return asset('storage/' . $value);
    }
}
