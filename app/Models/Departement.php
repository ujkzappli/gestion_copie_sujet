<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Etablissement;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'libelle',
        'sigle',
        'etablissement_id',
    ];

    /**
     * Un département appartient à un établissement
     */
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function enseignants()
    {
        return $this->belongsToMany(
            User::class,
            'enseignant_departement',
            'departement_id',
            'utilisateur_id'
        );
    }

    public function option()
    {
        return $this->hasMany(Option::class);
    }

    public function scopeForUser($query, User $user)
    {
        if ($user->type === 'Admin') {
            return $query;
        }

        if (in_array($user->type, ['DA', 'CS'])) {
            return $query->where('etablissement_id', $user->etablissement_id);
        }

        if ($user->type === 'CD') {
            return $query->where('id', $user->departement_id);
        }

        return $query->whereNull('id'); // rien pour enseignant
    }


}