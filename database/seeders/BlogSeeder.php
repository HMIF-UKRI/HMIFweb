<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {

        $categories = ['Tutorial', 'Security', 'Web Development', 'Tech News', 'Campus Life'];

        foreach ($categories as $cat) {
            BlogCategory::updateOrCreate(
                ['slug' => Str::slug($cat)],
                ['name' => $cat]
            );
        }

        $categories = BlogCategory::all();
        $members = Member::all();

        if ($members->isEmpty()) {
            $this->command->warn('Seeder Blog membutuhkan data Member. Pastikan MemberSeeder sudah dijalankan.');
            return;
        }

        for ($i = 1; $i <= 10; $i++) {
            $title = fake()->sentence(fake()->numberBetween(6, 10));

            $blog = Blog::create([
                'member_id' => $members->random()->id,
                'blog_category_id' => $categories->random()->id,
                'title' => $title,
                'slug' => Str::slug($title),
                'summary' => fake()->paragraph(2),
                'content' => $this->generateDummyContent(),
                'views_count' => fake()->numberBetween(50, 5000),
                'status' => 'published',
            ]);

            try {
                $blog->addMediaFromUrl('https://picsum.photos/1200/800')
                    ->toMediaCollection('blog_thumbnails');
            } catch (\Exception $e) {
                $this->command->error("Gagal mendownload gambar untuk blog: " . $blog->title);
            }
        }
    }

    private function generateDummyContent()
    {
        return "
            <h2>Pendahuluan</h2>
            <p>" . fake()->paragraphs(2, true) . "</p>
            <img src='https://picsum.photos/800/400' alt='Dummy Image Content'>
            <h2>Pembahasan Utama</h2>
            <p>" . fake()->paragraphs(3, true) . "</p>
            <blockquote>" . fake()->sentence(10) . "</blockquote>
            <p>" . fake()->paragraphs(2, true) . "</p>
            <h2>Kesimpulan</h2>
            <p>" . fake()->paragraphs(1, true) . "</p>
        ";
    }
}
