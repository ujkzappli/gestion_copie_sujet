<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function sessionExamens()
    {
        return $this->belongsToMany(SessionExamen::class, 'lot_copies_session_examen')->withTimestamps();
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

    protected $appends = ['statut_calcule'];

    public function getStatutCalculeAttribute()
    {
        $now = Carbon::now();

        if (is_null($this->date_disponible)) {
            \Log::error('date_disponible est NULL pour LotCopie id=' . $this->id);
            return 'Statut inconnu';
        }

        // Rien récupéré
        if (is_null($this->date_recuperation)) {
            $limite = $this->date_disponible->copy()->addDays(2);
            return $now->gt($limite) ? 'En retard' : 'En cours';
        }

        // Récupéré mais pas remis
        if (is_null($this->date_remise)) {
            $limite = $this->date_recuperation->copy()->addDays(3);
            return $now->gt($limite) ? 'En retard' : 'En cours';
        }

        return 'Validé';
    }
}
