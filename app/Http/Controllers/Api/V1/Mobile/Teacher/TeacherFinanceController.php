<?php

namespace App\Http\Controllers\Api\V1\Mobile\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TeacherFinanceController extends Controller
{
    public function moneyInfo(): JsonResponse
    {
        try {
            $user=Auth::user();
            $teacher=$user->teacher;
            $year = Carbon::now()->year;
            $payouts = $teacher->salaryPayouts()
                ->whereYear('salary_month', $year)
                ->get();
            $totalPayouts = $payouts->sum('amount');
            $adjustments = $teacher->salaryAdjustments()
                ->whereYear('created_at', $year)
                ->get();

            $totalBonuses  = $adjustments->where('type','bonus')->sum('amount');
            $totalPenalties = $adjustments->where('type','penalty')->sum('amount');
            $receipts = $teacher->salaryReceipts()
                ->whereYear('paid_on', $year)
                ->get();
            $totalReceipts = $receipts->sum('amount');
            $monthly = [];
            for ($m = 1; $m <= 12; $m++) {
                $monthName = Carbon::create($year, $m, 1)->format('F');
                $monthPayouts = $payouts->where(
                    fn($p) => Carbon::parse($p->salary_month)->month == $m
                )->sum('amount');
                $monthly[$monthName] = $monthPayouts;
            }
            return response()->json([
                'success' => true,
                'message' => __('mobile/teacher.money_info.success'),
                'data'    => [
                    'year'            => $year,
                    'total_payouts'   => $totalPayouts,
                    'total_bonuses'   => $totalBonuses,
                    'total_penalties' => $totalPenalties,
                    'total_receipts'  => $totalReceipts,
                    'monthly_payouts' => $monthly,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Teacher moneyInfo failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => __('mobile/teacher.money_info.error'),
            ], 500);
        }
    }
}