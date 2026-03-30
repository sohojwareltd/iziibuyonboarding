<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcquirerMaster;
use App\Models\AuditLog;
use App\Models\KYCFieldMaster;
use App\Models\Onboarding;
use App\Models\Partner;
use App\Models\PaymentMethodMaster;
use App\Models\SolutionMaster;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = now()->startOfDay();

        $totalOnboardings = Onboarding::count();
        $newToday = Onboarding::where('created_at', '>=', $today)->count();
        $inProgress = Onboarding::whereIn('status', ['sent', 'in-review'])->count();
        $approved = Onboarding::whereIn('status', ['approved', 'active'])->count();
        $completedKyc = Onboarding::whereNotNull('kyc_completed_at')->count();

        $statusBreakdown = [
            ['label' => 'Draft', 'value' => Onboarding::where('status', 'draft')->count(), 'tone' => 'slate'],
            ['label' => 'Sent', 'value' => Onboarding::where('status', 'sent')->count(), 'tone' => 'blue'],
            ['label' => 'In Review', 'value' => Onboarding::where('status', 'in-review')->count(), 'tone' => 'amber'],
            ['label' => 'Approved', 'value' => Onboarding::where('status', 'approved')->count(), 'tone' => 'emerald'],
            ['label' => 'Active', 'value' => Onboarding::where('status', 'active')->count(), 'tone' => 'indigo'],
        ];

        $systemOverview = [
            ['label' => 'Partners', 'value' => Partner::count(), 'description' => 'Connected business partners'],
            ['label' => 'Solutions', 'value' => SolutionMaster::count(), 'description' => 'Configured solution masters'],
            ['label' => 'Active Acquirers', 'value' => AcquirerMaster::where('is_active', true)->count(), 'description' => 'Live acquiring integrations'],
            ['label' => 'Active Payment Methods', 'value' => PaymentMethodMaster::where('is_active', true)->count(), 'description' => 'Enabled payment methods'],
            ['label' => 'Active KYC Fields', 'value' => KYCFieldMaster::where('status', 'active')->count(), 'description' => 'Published KYC field rules'],
            ['label' => 'Admin Users', 'value' => User::where('role_id', 1)->count(), 'description' => 'Back-office accounts'],
        ];

        $recentOnboardings = Onboarding::with(['partner', 'solution'])
            ->latest()
            ->limit(6)
            ->get();

        $recentAuditLogs = AuditLog::latest()
            ->limit(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalOnboardings',
            'newToday',
            'inProgress',
            'approved',
            'completedKyc',
            'statusBreakdown',
            'systemOverview',
            'recentOnboardings',
            'recentAuditLogs'
        ));
    }
}