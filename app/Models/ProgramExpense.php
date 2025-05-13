<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramExpense extends Model
{
    protected $fillable = [
        'program_id', 'expense_date', 'amount', 'description', 'received_by_id', 'recorded_by_id'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(Staff::class, 'received_by_id');
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by_id');
    }
}