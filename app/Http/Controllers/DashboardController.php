<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        }

        return $this->userDashboard($user);
    }

    /**
     * Logic for Admin Dashboard.
     */
    private function adminDashboard()
    {

        $recentActivities = Activity::with('causer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('recentActivities'));
    }

    /**
     * Logic for Regular User Dashboard.
     */
    private function userDashboard($user)
    {
        $myActivities = Activity::causedBy($user)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard-user', compact('myActivities'));
    }
}
