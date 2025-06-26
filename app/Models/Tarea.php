<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tarea extends Model
{
    use HasFactory;
    protected $fillable = [
        'materia_id',
        'documento',
        'observaciones',
        'fecha_inicio',
        'fecha_cierre',
    ];
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_cierre' => 'datetime',
    ];
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id', 'id');
    }
}
