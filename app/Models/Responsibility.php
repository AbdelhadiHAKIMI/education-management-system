<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsibility extends Model
{
    protected $fillable = [
        'name', 'grant_value'
    ];

    public function staffResponsibilities()
    {
        return $this->hasMany(StaffResponsibility::class);
    }
}