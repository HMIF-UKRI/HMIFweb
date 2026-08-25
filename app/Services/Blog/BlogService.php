<?php

namespace App\Services\Blog;

use App\Models\Blog;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogService
{
    public function createBlog(array $data, ?UploadedFile $thumbnail): Blog
    {
        return DB::transaction(function () use ($data, $thumbnail) {
            $data['slug'] = $this->generateUniqueSlug($data['title']);
            unset($data['thumbnail']);

            $blog = Blog::create($data);

            if ($thumbnail) {
                $blog->addMedia($thumbnail)->toMediaCollection('blog_thumbnails');
            }

            return $blog;
        });
    }

    public function updateBlog(Blog $blog, array $data, ?UploadedFile $thumbnail): Blog
    {
        return DB::transaction(function () use ($blog, $data, $thumbnail) {
            if (isset($data['title']) && $data['title'] !== $blog->title) {
                $data['slug'] = $this->generateUniqueSlug($data['title'], $blog->id);
            }

            unset($data['thumbnail']);
            $blog->update($data);

            if ($thumbnail) {
                $blog->clearMediaCollection('blog_thumbnails');
                $blog->addMedia($thumbnail)->toMediaCollection('blog_thumbnails');
            }

            return $blog;
        });
    }

    public function deleteBlog(Blog $blog): void
    {
        DB::transaction(function () use ($blog) {
            $blog->clearMediaCollection('blog_thumbnails');
            $blog->delete();
        });
    }

    public function uploadEditorImage(UploadedFile $file): array
    {
        $path = $file->store('editor-uploads/blog', 'public');

        return [
            'success' => 1,
            'file' => [
                'url' => asset('storage/' . $path),
            ],
        ];
    }

    public function incrementViews(Blog $blog): void
    {
        $sessionKey = 'viewed_blog_' . $blog->id;

        if (!session()->has($sessionKey)) {
            $blog->increment('views_count');
            session()->put($sessionKey, true);
        }
    }

    public function calculateReadingTime(?string $content): int
    {
        if (empty($content)) {
            return 1;
        }

        $text = '';
        $decoded = json_decode($content, true);

        if (json_last_error() === JSON_ERROR_NONE && isset($decoded['blocks']) && is_array($decoded['blocks'])) {
            foreach ($decoded['blocks'] as $block) {
                if (isset($block['data']['text'])) {
                    $text .= ' ' . strip_tags($block['data']['text']);
                }
                if (isset($block['data']['items']) && is_array($block['data']['items'])) {
                    foreach ($block['data']['items'] as $item) {
                        $text .= ' ' . (is_array($item) ? ($item['content'] ?? '') : $item);
                    }
                }
                if (isset($block['data']['caption'])) {
                    $text .= ' ' . strip_tags($block['data']['caption']);
                }
            }
        } else {
            $text = strip_tags($content);
        }

        $words = str_word_count(trim($text));

        return max(1, (int) ceil($words / 200));
    }

    public function generateUniqueSlug(string $title, ?int $exceptId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (
            Blog::where('slug', $slug)
                ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
