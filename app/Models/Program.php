<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name', 'description', 'start_date', 'end_date', 'academic_year_id',
        'registration_fees', 'is_active', 'created_by_id', 'level_id'
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function staff()
    {
        return $this->hasMany(ProgramStaff::class);
    }

    public function expenses()
    {
        return $this->hasMany(ProgramExpense::class);
    }

    public function invitations()
    {
        return $this->hasMany(ProgramInvitation::class);
    }

    public function generatedFiles()
    {
        return $this->hasMany(GeneratedFile::class);
    }
}