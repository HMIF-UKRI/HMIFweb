<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Event;
use App\Models\Member;
use App\Models\OrganizationPeriods;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function home(Request $request)
    {
        $events = Event::latest()->take(3)->get();

        $positionOrder = [
            'Ketua Himpunan',
            'Wakil Ketua Himpunan',
            'Sekretaris',
            'Bendahara',
        ];

        $members = Member::whereHas('organizationPeriod', function ($query) {
            $query->where('is_current', true);
        })
            ->get()
            ->sort(function ($a, $b) use ($positionOrder) {
                $posA = array_search($a->position, $positionOrder);
                $posB = array_search($b->position, $positionOrder);

                $posA = ($posA === false) ? 999 : $posA;
                $posB = ($posB === false) ? 999 : $posB;

                if ($posA === $posB) {
                    return strnatcasecmp($a->name, $b->name);
                }

                return $posA <=> $posB;
            })
            ->take(4)
            ->values();

        return view('page.home', compact('members', 'events'));
    }

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
            $positionOrder = [
                'Ketua Himpunan',
                'Wakil Ketua Himpunan',
                'Sekretaris',
                'Kesekretariatan',
                'Bendahara',
                'Bendahara 2',
            ];

            $activeDepartments = Departemen::whereHas('members', function ($query) use ($activePeriod) {
                $query->where('organization_period_id', $activePeriod->id);
            })->get();

            foreach ($positionOrder as $position) {
                $positionMembers = Member::where('organization_period_id', $activePeriod->id)
                    ->where('position', $position)
                    ->orderBy('name')
                    ->get();

                $members = $members->merge($positionMembers);
            }

            $otherMembers = Member::where('organization_period_id', $activePeriod->id)
                ->whereNotIn('position', $positionOrder)
                ->orderBy('name')
                ->get();

            $members = $members->merge($otherMembers);
        }

        return view('page.struktur-pengurus', [
            'members' => $members,
            'currentPeriod' => $allPeriods,
            'activePeriod' => $activePeriod,
            'departments' => $activeDepartments,
        ]);
    }
}
