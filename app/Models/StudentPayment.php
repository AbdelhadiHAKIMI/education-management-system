<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    protected $fillable = [
        'program_invitation_id', 'amount', 'payment_date'
    ];

    public function programInvitation()
    {
        return $this->belongsTo(ProgramInvitation::class);
    }
}