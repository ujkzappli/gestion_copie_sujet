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
}
