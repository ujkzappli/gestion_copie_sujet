<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'libelle_option',
        'departement_id',
        'semestre_id',
    ];

    /**
     * Une option appartient à un département
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function modules()
    {
        return $this->hasManyThrough(Module::class, Semestre::class, 'option_id', 'semestre_id');
    }

    /**
     * Une option appartient à un semestre
     */
    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    /**
     * Une option peut appartenir à plusieurs sessions d’examen
     */
    public function sessionExamens()
    {
        return $this->belongsToMany(
            SessionExamen::class,
            'option_session_examen'
        )->withTimestamps();
    }
}
