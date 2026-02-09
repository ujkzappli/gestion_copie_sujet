<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom_utilisateur',
        'prenom_utilisateur',
        'email',
        'password',
        'matricule_utilisateur',
        'photo',
        'adresse',
        'phone_country_code',
        'phone_number',
        'type',
        'departement_id',
        'etablissement_id',
        
    ];

    protected $hidden = [
        'password',
    ];

    
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function modules()
    {
        return $this->hasMany(Module::class, 'enseignant_id');
    }

    public function getFullPhoneAttribute()
    {
        if ($this->phone_country_code && $this->phone_number) {
            return $this->phone_country_code . $this->phone_number;
        }
        return null;
    }

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function departementsEnseignes()
    {
        return $this->belongsToMany(
            Departement::class,
            'enseignant_departement',
            'utilisateur_id',
            'departement_id'
        );
    }

    public function lotsCopies()
    {
        return $this->hasMany(LotCopie::class, 'utilisateur_id');
    }

    public function scopeEnseignantsForUser($query, User $user)
    {
        if ($user->type === 'Admin') {
            return $query->where('type', 'Enseignant');
        }

        if (in_array($user->type, ['DA', 'CS'])) {
            return $query
                ->where('type', 'Enseignant')
                ->whereHas('departementsEnseignes', function ($q) use ($user) {
                    $q->where('etablissement_id', $user->etablissement_id);
                });
        }

        if ($user->type === 'CD') {
            return $query
                ->where('type', 'Enseignant')
                ->whereHas('departementsEnseignes', function ($q) use ($user) {
                    $q->where('departement_id', $user->departement_id);
                });
        }

        return $query->whereNull('id');
    }

    // pour en fonction du type diriger vers tel blade ou sidebar 

    public function isAdmin() {
        return $this->type === 'Admin';
    }

    public function isPresident() {
        return $this->type === 'President';
    }

    public function isEnseignant() {
        return $this->type === 'Enseignant';
    }

    public function isCD() {
        return $this->type === 'CD';
    }

    public function isCS() {
        return $this->type === 'CS';
    }

    public function isDA() {
        return $this->type === 'DA';
    }



}
