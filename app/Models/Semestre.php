<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'libelle',
    ];

    /* ================= RELATIONS ================= */

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function sessionExamens()
    {
        return $this->hasMany(SessionExamen::class);
    }

    /* ================= ACCESSOR ================= */
    public function getLibelleAttribute()
    {
        return 'Semestre ' . $this->numero;
    }
}
