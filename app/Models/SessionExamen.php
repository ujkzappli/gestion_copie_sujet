<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionExamen extends Model
{
    use HasFactory;

    protected $fillable = [
        'annee_academique',
        'type',
        'semestre_id',
    ];

    /* ================= RELATIONS ================= */

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public const TYPES = [
        'session normale',
        'session de rattrappage',
        'session speciale',
    ];

    public function options()
    {
        return $this->belongsToMany(
            Option::class,
            'option_session_examen'
        )->withTimestamps();
    }

    public function lotsCopies()
    {
        return $this->belongsToMany(LotCopie::class, 'lot_copies_session_examen')->withTimestamps();
    }

}
