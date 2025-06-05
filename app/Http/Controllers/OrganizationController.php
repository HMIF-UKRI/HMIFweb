<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\OrganizationPeriods;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $currentPeriod = OrganizationPeriods::where('is_current', true)->first();
        $member = collect();

        if ($currentPeriod) {
            $activeDepartments = Departemen::whereHas('member', function ($query) use ($currentPeriod) {
                $query->where('organization_periods_id', $currentPeriod->id);
            })->get();

            foreach ($activeDepartments as $department) {
                $departmentMember = $department->member()
                    ->where('organization_periods_id', $currentPeriod->id)
                    ->orderBy('name')
                    ->get();

                $member = $member->merge($departmentMember);
            }
        }

        return view('struktur-pengurus', compact('currentPeriod', 'member'));
    }
}
