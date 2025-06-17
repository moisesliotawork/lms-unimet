<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'departamento_id'
    ];

    /**
     * Relación con el modelo Departamento
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}