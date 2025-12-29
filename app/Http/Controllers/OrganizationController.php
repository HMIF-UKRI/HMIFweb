<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Member;
use App\Models\OrganizationPeriods;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $organizationPeriods = OrganizationPeriods::orderBy('start_date', 'desc')->get();

        if ($request->has('period')) {
            $activePeriod = $organizationPeriods->find($request->period);
        } else {
            $activePeriod = $organizationPeriods->where('is_current', true)->first()
                ?? $organizationPeriods->first();
        }

        $members = collect();
        $activeDepartments = collect();

        if ($activePeriod) {
            $members = Member::where('organization_period_id', $activePeriod->id)
                ->with('departemen')
                ->get()
                ->sortBy(function ($member) {
                    $position = strtolower($member->position);
                    if (str_contains($position, 'ketua')) return 1;
                    if (str_contains($position, 'wakil')) return 2;
                    if (str_contains($position, 'sekretaris')) return 3;
                    if (str_contains($position, 'bendahara')) return 4;
                    return 99;
                });

            $activeDepartments = Departemen::whereHas('members', function ($query) use ($activePeriod) {
                $query->where('organization_period_id', $activePeriod->id);
            })->get();
        }

        return view('page.struktur-pengurus', [
            'members' => $members,
            'activePeriod' => $activePeriod,
            'departments' => $activeDepartments,
            'organizationPeriods' => $organizationPeriods,
        ]);
    }
}
