<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotCopie extends Model
{
    use HasFactory;

    protected $table = 'lot_copies';

    protected $fillable = [
        'module_id',
        'nombre_copies',
        'date_disponible',
        'date_recuperation',
        'date_remise',
        'statut',
        'utilisateur_id',
    ];

    protected $casts = [
        'date_disponible' => 'datetime',
        'date_recuperation' => 'datetime',
        'date_remise' => 'datetime',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function scopeForUser($query, User $user)
    {
        if ($user->type === 'Admin') {
            return $query;
        }

        if (in_array($user->type, ['DA', 'CS'])) {
            return $query->whereHas('module.semestre.options.departement', function ($q) use ($user) {
                $q->where('etablissement_id', $user->etablissement_id);
            });
        }

        if ($user->type === 'CD') {
            return $query->whereHas('module.semestre.options', function ($q) use ($user) {
                $q->where('departement_id', $user->departement_id);
            });
        }

        if ($user->type === 'Enseignant') {
            return $query->where('utilisateur_id', $user->id);
        }

        return $query->whereNull('id');
    }
}
