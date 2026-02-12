<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendances;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    public function index()
    {
        $events = Event::withCount('attendances')
            ->paginate(10);

        return view('admin.attendances.index', compact('events'));
    }

    public function absensi($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $attendances = Attendances::with('member.generation')
            ->where('event_id', $event->id)
            ->orderBy('check_in_time', 'desc')
            ->get();

        return view('admin.attendances.attendance', compact('event', 'attendances'));
    }

    public function store(Request $request, $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        if (!Carbon::parse($event->event_date)->isToday()) {
            return redirect()->back()->with('error', 'Absensi hanya tersedia pada hari kegiatan.');
        }

        if (Auth::check()) {
            return $this->handleInternalAttendance($event);
        } else {
            return $this->handleExternalAttendance($request, $event);
        }
    }

    private function handleInternalAttendance($event)
    {
        $userId = Auth::id();

        $exists = Attendances::where('event_id', $event->id)
            ->where('member_id', $userId)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('info', 'Anda sudah melakukan absensi sebelumnya.');
        }

        Attendances::create([
            'event_id' => $event->id,
            'member_id' => $userId,
            'check_in_time' => now(),
            'participant_type' => 'internal',
            'is_present' => true
        ]);

        return redirect()->route('event.show', $event->slug)->with('success', 'Absensi berhasil dicatat!');
    }

    private function handleExternalAttendance(Request $request, $event)
    {
        $request->validate([
            'external_name' => 'required|string|max:255',
            'external_npm'  => 'required|string|max:20',
            'external_prodi' => 'required|string|max:100',
            'external_angkatan' => 'required|string|max:100',
        ]);

        $exists = Attendances::where('event_id', $event->id)
            ->where('external_npm', $request->external_npm)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Kamu sudah terdaftar dalam absensi kegiatan ini.');
        }

        Attendances::create([
            'event_id' => $event->id,
            'check_in_time' => now(),
            'participant_type' => 'external',
            'external_name' => $request->external_name,
            'external_npm'  => $request->external_npm,
            'external_prodi' => $request->external_prodi,
            'external_angkatan' => $request->external_angkatan,
            'is_present' => true
        ]);

        return redirect()->route('event.show', $event->slug)->with('success', 'Absensi tamu berhasil dicatat!');
    }

    public function storeManual(Request $request, $eventId)
    {
        $request->validate([
            'participant_type' => 'required|in:internal,external',
            'member_id'        => 'required_if:participant_type,internal',
            'external_name'    => 'required_if:participant_type,external',
            'external_npm'     => 'required_if:participant_type,external',
        ]);

        Attendances::create([
            'event_id'         => $eventId,
            'member_id'        => $request->member_id,
            'participant_type' => $request->participant_type,
            'external_name'    => $request->external_name,
            'external_npm'     => $request->external_npm,
            'external_prodi'   => $request->external_prodi,
            'check_in_time'    => now(),
            'is_present'       => true
        ]);

        return back()->with('success', 'Data berhasil ditambahkan secara manual.');
    }

    public function showQrCode($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $attendanceUrl = route('attendance.scan', ['slug' => $event->slug]);

        $qrcode = QrCode::size(250)
            ->gradient(185, 28, 28, 0, 0, 0, 'diagonal')
            ->margin(1)
            ->generate($attendanceUrl);

        return view('admin.attendances.qrcode', compact('qrcode', 'event'));
    }

    public function processScan($slug)
    {
        try {
            $event = Event::where('slug', $slug)->firstOrFail();

            if (!Carbon::parse($event->event_date)->isToday()) {
                return redirect()->route('event.show', $slug)
                    ->with('error', 'Maaf, absensi hanya tersedia pada hari kegiatan.');
            }

            if (!Auth::check()) {
                return view('page.attendance.external_form', compact('event'));
            }

            return view('page.attendance.scan', compact('event'));
        } catch (\Exception $e) {
            return redirect()->route('event.index')->with('error', 'Kegiatan tidak ditemukan.');
        }
    }

    public function exportPdf($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $attendances = Attendances::with('member')->where('event_id', $event->id)->orderBy('check_in_time', 'asc')->get();

        $pdf = Pdf::loadView('admin.attendances.pdf', compact('event', 'attendances'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->download('Absensi_' . str_replace(' ', '_', $event->title) . '.pdf');
    }
}
