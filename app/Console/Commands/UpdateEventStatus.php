<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Carbon\Carbon;

class UpdateEventStatus extends Command
{
    protected $signature = 'event:update-status';

    protected $description = 'Update status event berdasarkan tanggal hari ini';

    public function handle()
    {
        $today = Carbon::today()->toDateString();
        $this->info("Memulai pengecekan status event untuk tanggal: $today");

        $upcomingCount = Event::where('event_date', '>', $today)
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'upcoming')
            ->update(['status' => 'upcoming']);

        $completedCount = Event::where('event_date', '<', $today)
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'completed')
            ->update(['status' => 'completed']);

        $this->info("Berhasil: $upcomingCount event diubah ke 'upcoming'.");
        $this->info("Berhasil: $completedCount event diubah ke 'completed'.");

        return Command::SUCCESS;
    }
}
