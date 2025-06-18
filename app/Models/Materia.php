<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Filament\Panel;
use Filament\Models\Contracts\HasName;

class Materia extends Model implements HasName
{
    use HasFactory;

    protected $table = 'materias';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nombre',
        'descripcion',
        'departamento_id',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($store) {
            if (empty($store->{$store->getKeyName()})) {
                $store->{$store->getKeyName()} = (string) Str::ulid();
            }
        });
    }

    /**
     * Relación con el modelo Departamento
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'materia_user');
    }
    public function profesores()
    {
        return $this->belongsToMany(User::class)
                    ->using(MateriaUser::class)
                    ->wherePivot('role', 'profesor');
    }
    public function getFilamentName(): string
    {
        return "{$this->nombre}";
    }

    public function getTenantKey(): string
    {
        return $this->slug ?? $this->getKey();
    }
}