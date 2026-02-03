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

        $activePeriod = PeriodeKepengurusan::where('is_current', true)->first();

        $pengurus = collect();
        $pengurusBidang = collect();
        $departmentGroups = collect();

        if ($activePeriod) {
            $allPengurus = Pengurus::with(['member', 'department', 'bidang', 'media'])
                ->where('period_id', $activePeriod->id)
                ->get();

            $pengurus = $allPengurus->where('hierarchy_level', 1)->sortBy('id');

            $pengurusForGroups = $allPengurus->whereIn('hierarchy_level', [1, 2]);

            $pengurusBidang = $allPengurus->where('hierarchy_level', 3)
                ->sortBy(['bidang_id', 'id']);

            $departmentGroups = $pengurusForGroups->groupBy('department_id')
                ->map(function ($heads) {

                    $dept = $heads->first()->department;
                    if (!$dept) return null;

                    return [
                        'department' => $heads->first()->department,
                        'heads' => $heads->values()
                    ];
                })
                ->filter()
                ->sortBy(function ($item) {
                    $name = strtolower($item->department->name ?? 'tanpa departemen');

                    $priority = [
                        'ring 1' => 0,
                        'pendidikan' => 1,
                        'pelatihan dan pengembangan' => 2,
                        'pengabdian masyarakat' => 3,
                        'minat dan bakat' => 4,
                        'humas internal' => 5,
                        'humas eksternal' => 6,
                        'media dan publikasi' => 7,
                    ];

                    return $priority[$name] ?? 99;
                });
        }

        return view('page.home', compact('events', 'pengurus', 'activePeriod', 'departmentGroups', 'pengurusBidang'));
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
