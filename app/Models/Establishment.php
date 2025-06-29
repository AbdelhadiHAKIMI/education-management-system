<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    protected $fillable = [
        'name',
        'location',      
        'wilaya',
        'phone',
        'email',
        'logo',
        'registration_code',
        'is_active',
        'created_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $timestamps = false;

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function manager()
    {
        return $this->hasOne(User::class, 'establishment_id', 'id');
    }
}
