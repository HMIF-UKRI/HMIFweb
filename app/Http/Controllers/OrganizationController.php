<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\OrganizationPeriods;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $allPeriods = OrganizationPeriods::orderBy('start_date', 'desc')->get();

        $periodId = $request->get('period');

        if ($periodId) {
            $activePeriod = OrganizationPeriods::find($periodId);
        } else {
            $activePeriod = OrganizationPeriods::where('is_current', true)->first();
        }

        $members = collect();
        $activeDepartments = collect();

        if ($activePeriod instanceof OrganizationPeriods) {
            $activeDepartments = Departemen::whereHas('members', function ($query) use ($activePeriod) {
                $query->where('organization_period_id', $activePeriod->id);
            })->get();

            foreach ($activeDepartments as $department) {
                $departmentMembers = $department->members()
                    ->where('organization_period_id', $activePeriod->id)
                    ->orderBy('name')
                    ->get();

                $members = $members->merge($departmentMembers);
            }
        }

        return view('page.struktur-pengurus', [
            'members' => $members,
            'currentPeriod' => $allPeriods,
            'activePeriod' => $activePeriod,
            'departments' => $activeDepartments,
        ]);
    }
}
