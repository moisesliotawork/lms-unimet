<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriaUser extends Model
{
    protected $table = 'materia_user';
    
    protected $fillable = [
        'user_id',
        'materia_id',
        'role'
    ];
    public function profesor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}