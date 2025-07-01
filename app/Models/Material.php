<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'material';

    protected $fillable = [
        'materia_id',
        'titulo',
        'documento',
        'descripcion',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}