<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departement;

class Etablissement extends Model
{
    use HasFactory;

    protected $table = 'etablissements';

    protected $fillable = [
        'sigle',
        'libelle',
    ];

    public function departements()
    {
        return $this->hasMany(Departement::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
