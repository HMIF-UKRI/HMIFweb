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
        $members = collect();

        if ($currentPeriod) {
            $activeDepartments = Departemen::whereHas('members', function ($query) use ($currentPeriod) {
                $query->where('organization_period_id', $currentPeriod->id);
            })->get();

            foreach ($activeDepartments as $department) {
                $departmentMembers = $department->members()
                    ->where('organization_period_id', $currentPeriod->id)
                    ->orderBy('name')
                    ->get();

                $members = $members->merge($departmentMembers);
            }
        }

        return view('page.struktur-pengurus', [
            'members' => $members,
            'currentPeriod' => $currentPeriod,
            'departments' => $activeDepartments ?? collect(),
        ]);
    }
}
