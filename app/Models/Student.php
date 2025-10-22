<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_number',
        'department',
        'class',
        'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
