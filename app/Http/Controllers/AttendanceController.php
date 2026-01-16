<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendances;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Event $event)
    {
        // Menampilkan daftar hadir untuk event spesifik
        $attendances = Attendances::with('member')
            ->where('event_id', $event->id)
            ->orderBy('check_in_time', 'desc')
            ->get();

        return view('admin.attendances.index', compact('event', 'attendances'));
    }

    public function store(Request $request, Event $event)
    {
        // Validasi ganda: Jika internal butuh member_id, jika external butuh nama/prodi
        $validated = $request->validate([
            'participant_type' => 'required|in:internal,external',
            'member_id'        => 'required_if:participant_type,internal|exists:members,id',
            'external_name'    => 'required_if:participant_type,external|string|max:100',
            'external_npm'     => 'nullable|string|max:20',
            'external_prodi'   => 'nullable|string|max:100',
        ]);

        // Cegah double absen untuk member internal pada event yang sama
        if ($request->participant_type === 'internal') {
            $exists = Attendances::where('event_id', $event->id)
                ->where('member_id', $request->member_id)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Anggota ini sudah melakukan absensi.');
            }
        }

        Attendances::create(array_merge($validated, [
            'event_id'      => $event->id,
            'check_in_time' => now(),
            'is_present'    => true
        ]));

        return redirect()->back()->with('success', 'Absensi berhasil dicatat.');
    }

    public function report(Event $event)
    {
        // Mengambil statistik kehadiran untuk dashboard
        $stats = [
            'total'    => Attendances::where('event_id', $event->id)->count(),
            'internal' => Attendances::where('event_id', $event->id)->where('participant_type', 'internal')->count(),
            'external' => Attendances::where('event_id', $event->id)->where('participant_type', 'external')->count(),
        ];

        return view('admin.attendances.report', compact('event', 'stats'));
    }
}
