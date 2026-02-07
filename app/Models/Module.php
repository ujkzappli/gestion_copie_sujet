<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'nom',
        'semestre_id',
        'enseignant_id',
    ];

    // Relations
    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }

    // Relation calculée vers département
    public function departement()
    {
        return $this->enseignant ? $this->enseignant->departement : null;
    }

    // Relation calculée vers établissement
    public function etablissement()
    {
        return $this->enseignant && $this->enseignant->departement
            ? $this->enseignant->departement->etablissement
            : null;
    }

    public function lotCopies()
    {
        return $this->hasMany(LotCopie::class);
    }
}
