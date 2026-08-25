<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DashboardFilterRequest;
use App\Services\Dashboard\DashboardAnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardAnalyticsService $analyticsService
    ) {
    }

    public function index(DashboardFilterRequest $request): View
    {
        $periodId = $request->input('period_id');
        $timeRange = $request->input('time_range', '30d');
        $departmentId = $request->input('department_id');

        $summary = $this->analyticsService->getDashboardSummary(
            periodId: $periodId ? (int) $periodId : null,
            range: $timeRange,
            departmentId: $departmentId ? (int) $departmentId : null
        );

        return view('page.dashboard', compact('summary'));
    }

    public function analyticsData(DashboardFilterRequest $request): JsonResponse
    {
        $periodId = $request->input('period_id');
        $timeRange = $request->input('time_range', '30d');
        $departmentId = $request->input('department_id');

        $summary = $this->analyticsService->getDashboardSummary(
            periodId: $periodId ? (int) $periodId : null,
            range: $timeRange,
            departmentId: $departmentId ? (int) $departmentId : null
        );

        return response()->json([
            'status' => 'success',
            'data'   => $summary,
        ]);
    }

    public function ganttData(DashboardFilterRequest $request): JsonResponse
    {
        $periodId = $request->input('period_id');
        $departmentId = $request->input('department_id');

        $gantt = $this->analyticsService->getGanttTimelineData(
            periodId: $periodId ? (int) $periodId : null,
            departmentId: $departmentId ? (int) $departmentId : null
        );

        return response()->json([
            'status' => 'success',
            'data'   => $gantt,
        ]);
    }
}
