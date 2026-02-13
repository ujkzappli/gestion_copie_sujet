<?php

namespace App\Services\Dashboard;

use App\Models\LotCopie;
use Carbon\Carbon;

class LotCopiesChartService
{
    public function lotsByPeriod($period = 'month')
    {
        $query = LotCopie::query();

        match ($period) {
            'today' => $query->whereDate('created_at', today()),
            'week'  => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'month' => $query->whereMonth('created_at', now()->month),
            'year'  => $query->whereYear('created_at', now()->year),
            default => null,
        };

        return $query
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}
