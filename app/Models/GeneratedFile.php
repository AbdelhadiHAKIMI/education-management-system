<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedFile extends Model
{
    protected $fillable = [
        'name', 'description', 'program_id', 'generated_by_id'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by_id');
    }
}