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

    // Laravel doit savoir quel champ est le mot de passe
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

}
