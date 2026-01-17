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

        $pengurus = [];
        if ($activePeriod) {
            $pengurus = Pengurus::with(['member.media', 'department'])
                ->where('period_id', $activePeriod->id)
                ->where('hierarchy_level', 1)
                ->orderBy('id', 'asc')
                ->get();
        }

        return view('page.home', compact('events', 'pengurus', 'activePeriod'));
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
