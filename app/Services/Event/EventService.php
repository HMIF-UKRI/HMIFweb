<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventService
{
    public function createEvent(array $data, ?UploadedFile $thumbnail, User $user): Event
    {
        $member = $user->member;
        if (!$member) {
            throw new \RuntimeException('Akun Anda tidak memiliki profil Anggota / Member.');
        }

        return DB::transaction(function () use ($data, $thumbnail, $member) {
            $data['member_id'] = $member->id;
            $data['slug'] = $this->generateUniqueSlug($data['title']);
            unset($data['thumbnail']);

            $event = Event::create($data);

            if ($thumbnail) {
                $event->clearMediaCollection('thumbnails');
                $event->addMedia($thumbnail)->toMediaCollection('thumbnails');
            }

            return $event;
        });
    }

    public function updateEvent(Event $event, array $data, ?UploadedFile $thumbnail): Event
    {
        return DB::transaction(function () use ($event, $data, $thumbnail) {
            if (isset($data['title']) && $data['title'] !== $event->title) {
                $data['slug'] = $this->generateUniqueSlug($data['title'], $event->id);
            }

            unset($data['thumbnail']);
            $event->update($data);

            if ($thumbnail) {
                $event->clearMediaCollection('thumbnails');
                $event->addMedia($thumbnail)->toMediaCollection('thumbnails');
            }

            return $event;
        });
    }

    public function deleteEvent(Event $event): void
    {
        DB::transaction(function () use ($event) {
            $event->clearMediaCollection('thumbnails');
            $event->delete();
        });
    }

    public function uploadEditorImage(UploadedFile $file): array
    {
        $path = $file->store('editor-uploads', 'public');

        return [
            'success' => 1,
            'file' => [
                'url' => asset('storage/' . $path),
            ],
        ];
    }

    public function generateUniqueSlug(string $title, ?int $exceptId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (
            Event::where('slug', $slug)
                ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
