<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer');
        $this->applyFilters($query, $request);
        $logs = $query->paginate(50)->withQueryString();
        return view('activitylogs.index', compact('logs'));
    }

    public function history(Request $request)
    {
        $query = Activity::causedBy(auth()->user());
        $this->applyFilters($query, $request);
        $logs = $query->paginate(20)->withQueryString();
        return view('activitylogs.history', compact('logs'));
    }

    private function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', '%' . $request->search . '%')
                    ->orWhereHas('causer', function ($inner) use ($request) {
                        $inner->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // Filter Date Range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        } elseif ($request->filled('start_date')) {
            $query->where('created_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->filled('end_date')) {
            $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        // Sort Data
        $sort = $request->get('sort', 'desc');
        if ($sort === 'asc') {
            $query->oldest();
        } else {
            $query->latest();
        }
    }
}
