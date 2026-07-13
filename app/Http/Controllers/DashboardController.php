<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Member;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDoctors = Doctor::count();
        $totalMembers = Member::count();
        $totalArticles = Article::count();
        $totalBookings = Consultation::count();
        $totalOngoing = Consultation::where('status', 'ongoing')->count();
        $totalDone = Consultation::where('status', 'done')->count();
        $totalPending = Consultation::where('status', 'pending')->count();

        $statusBreakdown = [
            'pending' => $totalPending,
            'ongoing' => $totalOngoing,
            'done'    => $totalDone,
        ];

        $typeBreakdown = [
            'general consultation'    => Consultation::where('consultation_type', 'general consultation')->count(),
            'specialist consultation' => Consultation::where('consultation_type', 'specialist consultation')->count(),
        ];

        $bookingTrendLabels = [];
        $bookingTrendData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $bookingTrendLabels[] = $date->format('d M');
            $bookingTrendData[] = Consultation::whereDate('created_at', $date->toDateString())->count();
        }

        return view('dashboard', compact(
            'totalDoctors',
            'totalMembers',
            'totalArticles',
            'totalBookings',
            'totalOngoing',
            'totalDone',
            'totalPending',
            'statusBreakdown',
            'typeBreakdown',
            'bookingTrendLabels',
            'bookingTrendData'
        ));
    }
}