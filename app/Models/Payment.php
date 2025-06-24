<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'debt_id',
        'amount_paid',
        'transaction_id',
        'payment_gateway',
        'installment_no',
        'status',
        'paid_at'
    ];

    protected $dates = [
        'paid_at'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
