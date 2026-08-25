<?php

namespace App\Services\Dashboard;

use App\Models\Blog;
use App\Models\Departemen;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Member;
use App\Models\PeriodeKepengurusan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardAnalyticsService
{
    public function getDashboardSummary(?int $periodId = null, string $range = '30d', ?int $departmentId = null): array
    {
        if (!$periodId) {
            $currentPeriod = PeriodeKepengurusan::where('is_current', true)->first()
                ?? PeriodeKepengurusan::latest('start_date')->first();
            $periodId = $currentPeriod?->id;
        } else {
            $currentPeriod = PeriodeKepengurusan::find($periodId);
        }

        $cacheKey = "dashboard_summary_{$periodId}_{$range}_{$departmentId}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($periodId, $currentPeriod, $range, $departmentId) {
            return [
                'active_period'          => $currentPeriod,
                'periods'                => PeriodeKepengurusan::orderByDesc('start_date')->get(),
                'departments'            => Departemen::orderBy('name')->get(),
                'kpi'                    => $this->calculateKpiMetrics($periodId),
                'gantt_timeline'         => $this->getGanttTimelineData($periodId, $departmentId),
                'department_performance' => $this->getDepartmentPerformanceData($periodId),
                'trends'                 => $this->getTrendsData($range),
                'demographics'           => $this->getDemographicsData($periodId),
                'recent_activities'      => $this->getRecentActivities(8),
            ];
        });
    }

    public function calculateKpiMetrics(?int $periodId): array
    {
        $totalMembers = Member::count();
        $activeMembers = Member::where('is_active', true)->count();

        $eventsQuery = Event::query()
            ->when($periodId, fn ($q) => $q->where('period_id', $periodId));

        $totalEvents = (clone $eventsQuery)->count();
        $eventsUpcoming = (clone $eventsQuery)->where('status', 'upcoming')->count();
        $eventsOngoing = (clone $eventsQuery)->where('status', 'ongoing')->count();
        $eventsCompleted = (clone $eventsQuery)->where('status', 'completed')->count();
        $eventsCancelled = (clone $eventsQuery)->where('status', 'cancelled')->count();

        $completionRate = $totalEvents > 0 ? round(($eventsCompleted / $totalEvents) * 100, 1) : 0;

        $regQuery = EventRegistration::query()
            ->when($periodId, fn ($q) => $q->whereHas('event', fn ($e) => $e->where('period_id', $periodId)));

        $totalRegistrations = (clone $regQuery)->count();
        $certificatesSent = (clone $regQuery)->whereNotNull('certificate_sent_at')->count();
        $certificateRate = $totalRegistrations > 0 ? round(($certificatesSent / $totalRegistrations) * 100, 1) : 0;

        $totalBlogs = Blog::where('status', 'published')->count();
        $totalBlogViews = Blog::where('status', 'published')->sum('views_count') ?? 0;

        return [
            'total_members'       => $totalMembers,
            'active_members'      => $activeMembers,
            'total_events'        => $totalEvents,
            'events_upcoming'     => $eventsUpcoming,
            'events_ongoing'      => $eventsOngoing,
            'events_completed'    => $eventsCompleted,
            'events_cancelled'    => $eventsCancelled,
            'completion_rate'     => $completionRate,
            'total_registrations' => $totalRegistrations,
            'certificates_sent'   => $certificatesSent,
            'certificate_rate'    => $certificateRate,
            'total_blogs'         => $totalBlogs,
            'total_blog_views'    => $totalBlogViews,
        ];
    }

    public function getGanttTimelineData(?int $periodId, ?int $departmentId = null): array
    {
        $events = Event::with(['category', 'member.department'])
            ->withCount('registrations')
            ->when($periodId, fn ($q) => $q->where('period_id', $periodId))
            ->when($departmentId, fn ($q) => $q->whereHas('member', fn ($m) => $m->where('department_id', $departmentId)))
            ->orderBy('event_date')
            ->get();

        return $events->map(function ($event) {
            $startDate = $event->event_date ? Carbon::parse($event->event_date) : now();
            $endDate = (clone $startDate)->addDay();

            $color = match ($event->status) {
                'upcoming'  => '#3b82f6',
                'ongoing'   => '#f59e0b',
                'completed' => '#10b981',
                default     => '#ef4444',
            };

            return [
                'id'                 => $event->id,
                'title'              => $event->title,
                'slug'               => $event->slug,
                'department'         => $event->member?->department?->name ?? 'Umum HMIF',
                'category'           => $event->category?->name ?? 'Kegiatan',
                'pic'                => $event->member?->full_name ?? 'Panitia',
                'start'              => $startDate->format('Y-m-d'),
                'end'                => $endDate->format('Y-m-d'),
                'start_formatted'    => $startDate->locale('id')->translatedFormat('d M Y'),
                'status'             => $event->status,
                'status_label'       => ucfirst($event->status),
                'color'              => $color,
                'participants_count' => $event->registrations_count ?? 0,
            ];
        })->toArray();
    }

    public function getDepartmentPerformanceData(?int $periodId): array
    {
        $departments = Departemen::with(['members' => function ($q) use ($periodId) {
            $q->with(['events' => function ($ev) use ($periodId) {
                $ev->when($periodId, fn ($p) => $p->where('period_id', $periodId))
                   ->withCount('registrations');
            }]);
        }])->get();

        $categories = [];
        $eventsCount = [];
        $participantsCount = [];

        foreach ($departments as $dept) {
            $categories[] = $dept->name;
            $evCount = 0;
            $partCount = 0;

            foreach ($dept->members as $member) {
                foreach ($member->events as $event) {
                    $evCount++;
                    $partCount += $event->registrations_count ?? 0;
                }
            }

            $eventsCount[] = $evCount;
            $participantsCount[] = $partCount;
        }

        return [
            'categories'         => $categories,
            'events_count'       => $eventsCount,
            'participants_count' => $participantsCount,
        ];
    }

    public function getTrendsData(string $range = '30d'): array
    {
        $days = match ($range) {
            '7d'    => 7,
            '90d'   => 90,
            '1y'    => 365,
            default => 30,
        };

        $startDate = now()->subDays($days - 1)->startOfDay();
        $dates = [];
        $registrations = [];

        $rawRegistrations = EventRegistration::where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        for ($i = 0; $i < $days; $i++) {
            $current = (clone $startDate)->addDays($i);
            $key = $current->format('Y-m-d');
            $dates[] = $days > 60 ? $current->format('M d') : $current->format('d M');
            $registrations[] = $rawRegistrations[$key] ?? 0;
        }

        return [
            'dates'         => $dates,
            'registrations' => $registrations,
        ];
    }

    public function getDemographicsData(?int $periodId): array
    {
        $raw = EventRegistration::query()
            ->when($periodId, fn ($q) => $q->whereHas('event', fn ($e) => $e->where('period_id', $periodId)))
            ->select('participant_category', DB::raw('count(*) as total'))
            ->groupBy('participant_category')
            ->pluck('total', 'participant_category')
            ->toArray();

        $defaultCategories = ['Mahasiswa', 'Pelajar', 'Pekerja', 'Umum', 'Lainnya'];
        $labels = [];
        $series = [];

        foreach ($defaultCategories as $cat) {
            $count = $raw[$cat] ?? 0;
            $labels[] = $cat;
            $series[] = (int) $count;
        }

        foreach ($raw as $cat => $count) {
            if (!in_array($cat, $defaultCategories)) {
                $labels[] = $cat;
                $series[] = (int) $count;
            }
        }

        return [
            'labels' => $labels,
            'series' => $series,
        ];
    }

    public function getRecentActivities(int $limit = 8): array
    {
        $activities = collect();

        $recentRegs = EventRegistration::with('event')
            ->latest()
            ->limit($limit)
            ->get();

        foreach ($recentRegs as $reg) {
            $activities->push([
                'type'        => 'registration',
                'title'       => $reg->full_name . ' mendaftar ' . ($reg->event?->title ?? 'Kegiatan'),
                'subtitle'    => ($reg->participant_category ?? 'Peserta') . ' • ' . ($reg->institution ?? 'Institusi'),
                'time'        => $reg->created_at,
                'time_ago'    => $reg->created_at->locale('id')->diffForHumans(),
                'icon'        => 'fa-user-check',
                'badge_color' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
            ]);
        }

        $recentEvents = Event::latest()->limit(3)->get();
        foreach ($recentEvents as $event) {
            $activities->push([
                'type'        => 'event',
                'title'       => 'Event baru: ' . $event->title,
                'subtitle'    => 'Status: ' . ucfirst($event->status) . ' • ' . Carbon::parse($event->event_date)->format('d M Y'),
                'time'        => $event->created_at,
                'time_ago'    => $event->created_at->locale('id')->diffForHumans(),
                'icon'        => 'fa-calendar-days',
                'badge_color' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
            ]);
        }

        $recentBlogs = Blog::latest()->limit(3)->get();
        foreach ($recentBlogs as $blog) {
            $activities->push([
                'type'        => 'blog',
                'title'       => 'Artikel terbit: ' . $blog->title,
                'subtitle'    => ($blog->category?->name ?? 'Insight') . ' • ' . number_format($blog->views_count ?? 0) . ' views',
                'time'        => $blog->created_at,
                'time_ago'    => $blog->created_at->locale('id')->diffForHumans(),
                'icon'        => 'fa-newspaper',
                'badge_color' => 'bg-red-500/10 text-red-400 border-red-500/20',
            ]);
        }

        return $activities->sortByDesc('time')->take($limit)->values()->toArray();
    }
}
