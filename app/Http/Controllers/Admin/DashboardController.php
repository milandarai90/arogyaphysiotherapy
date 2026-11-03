<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\WebsiteVisit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Existing appointment statistics.
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

        // Website visit statistics.
        $totalVisits = WebsiteVisit::count();

        $uniqueVisitors = WebsiteVisit::distinct('visitor_id')
            ->count('visitor_id');

        $todayVisits = WebsiteVisit::whereDate(
            'visited_at',
            today()
        )->count();

        $yesterdayVisits = WebsiteVisit::whereDate(
            'visited_at',
            today()->subDay()
        )->count();

        $monthlyVisits = WebsiteVisit::whereYear(
            'visited_at',
            now()->year
        )->whereMonth(
            'visited_at',
            now()->month
        )->count();

        $todayUniqueVisitors = WebsiteVisit::whereDate(
            'visited_at',
            today()
        )->distinct('visitor_id')->count('visitor_id');

        // Daily visits for the last 30 days.
        $dailyVisitData = WebsiteVisit::select(
                DB::raw('DATE(visited_at) as visit_date'),
                DB::raw('COUNT(*) as total_visits'),
                DB::raw('COUNT(DISTINCT visitor_id) as unique_visitors')
            )
            ->where('visited_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy(DB::raw('DATE(visited_at)'))
            ->orderBy('visit_date')
            ->get()
            ->keyBy('visit_date');

        $chartLabels = [];
        $chartVisits = [];
        $chartUniqueVisitors = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();

            $chartLabels[] = Carbon::parse($date)->format('d M');
            $chartVisits[] = (int) ($dailyVisitData[$date]->total_visits ?? 0);
            $chartUniqueVisitors[] = (int) ($dailyVisitData[$date]->unique_visitors ?? 0);
        }

        // Most visited pages.
        $popularPages = WebsiteVisit::select(
                'page_path',
                DB::raw('COUNT(*) as total_visits'),
                DB::raw('COUNT(DISTINCT visitor_id) as unique_visitors')
            )
            ->groupBy('page_path')
            ->orderByDesc('total_visits')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalAppointments',
            'pendingAppointments',
            'approvedAppointments',
            'todayAppointments',
            'recentAppointments',
            'totalVisits',
            'uniqueVisitors',
            'todayVisits',
            'yesterdayVisits',
            'monthlyVisits',
            'todayUniqueVisitors',
            'chartLabels',
            'chartVisits',
            'chartUniqueVisitors',
            'popularPages'
        ));
    }
}