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

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }

    // Accesseur propre pour département
    public function getDepartementAttribute()
    {
        return $this->enseignant?->departement;
    }

    // Accesseur propre pour établissement
    public function getEtablissementAttribute()
    {
        return $this->enseignant?->departement?->etablissement;
    }

    public function lotCopies()
    {
        return $this->hasMany(LotCopie::class);
    }
}
