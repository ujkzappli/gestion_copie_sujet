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

    /* ================= RELATIONS ================= */

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }

    public function lotCopies()
    {
        return $this->hasMany(LotCopie::class);
    }
}