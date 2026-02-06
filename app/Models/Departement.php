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

}