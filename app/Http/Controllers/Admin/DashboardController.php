<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAppointments = Appointment::count();

        $pendingAppointments = Appointment::where('status', 'pending')->count();

        $approvedAppointments = Appointment::where('status', 'approved')->count();

        $todayAppointments = Appointment::whereDate(
            'appointment_date',
            Carbon::today()
        )->count();

        $recentAppointments = Appointment::with('service')
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalAppointments',
            'pendingAppointments',
            'approvedAppointments',
            'todayAppointments',
            'recentAppointments'
        ));
    }
}