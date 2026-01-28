<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Event;
use App\Models\Pengurus;
use App\Models\PeriodeKepengurusan;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function home()
    {
        $events = Event::with('category', 'media')
            ->where('status', '!=', 'cancelled')
            ->latest()
            ->take(3)
            ->get();

        $activePeriod = PeriodeKepengurusan::where('show_on_homepage', true)->first();
        if (!$activePeriod) {
            $activePeriod = PeriodeKepengurusan::where('is_current', true)->first();
        }
        if (!$activePeriod) {
            $activePeriod = PeriodeKepengurusan::orderBy('start_date', 'desc')->first();
        }

        $pengurus = [];
        $pengurusDepartments = collect();
        $pengurusBidang = collect();
        $allDepartments = Departemen::orderByRaw("CASE WHEN name = 'Ring 1' THEN 0 ELSE 1 END, name ASC")->get();
        if ($activePeriod) {
            $pengurus = Pengurus::with(['member.media', 'department'])
                ->where('period_id', $activePeriod->id)
                ->where('hierarchy_level', 1)
                ->orderBy('id', 'asc')
                ->get();

            $pengurusDepartments = Pengurus::with(['member.media', 'department'])
                ->where('period_id', $activePeriod->id)
                ->where('hierarchy_level', 2)
                ->orderBy('department_id', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            $pengurusBidang = Pengurus::with(['member.media', 'bidang', 'department'])
                ->where('period_id', $activePeriod->id)
                ->where('hierarchy_level', 3)
                ->orderBy('bidang_id', 'asc')
                ->orderBy('id', 'asc')
                ->get();
        }

        $bidangGroups = $pengurusBidang->groupBy(function ($item) {
            return $item->bidang?->name ?? 'Bidang Lainnya';
        });

        $departmentGroups = $allDepartments->mapWithKeys(function ($dept) use ($pengurusDepartments) {
            $heads = $pengurusDepartments->filter(function ($item) use ($dept) {
                return $item->department_id === $dept->id;
            });

            return [$dept->id => ['department' => $dept, 'heads' => $heads->values()]];
        });

        return view('page.home', compact('events', 'pengurus', 'activePeriod', 'bidangGroups', 'departmentGroups', 'pengurusBidang', 'allDepartments'));
    }

    public function index(Request $request)
    {
        $allPeriods = PeriodeKepengurusan::orderBy('start_date', 'desc')->get();

        $periodId = $request->get('period');

        if ($periodId) {
            $activePeriod = PeriodeKepengurusan::find($periodId);
        } else {
            $activePeriod = PeriodeKepengurusan::where('is_current', true)->first();
        }

        $pengurus = collect();
        $activeDepartments = collect();

        if ($activePeriod) {
            $activeDepartments = Departemen::whereHas('pengurus', function ($query) use ($activePeriod) {
                $query->where('period_id', $activePeriod->id);
            })->get();

            $pengurus = Pengurus::with(['member', 'media', 'department', 'bidang', 'period'])
                ->where('period_id', $activePeriod->id)
                ->orderBy('hierarchy_level', 'asc')
                ->orderBy('id', 'asc')
                ->get();
        }

        return view('page.struktur-pengurus', [
            'pengurus'      => $pengurus,
            'currentPeriod' => $allPeriods,
            'activePeriod'  => $activePeriod,
            'departments'   => $activeDepartments,
        ]);
    }
}
