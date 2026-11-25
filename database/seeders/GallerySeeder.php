<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@example.com')->first();

        if (! $user) {
            return;
        }

        $galleries = [
            [
                'title' => 'Portfolio Design',
                'slug' => 'portfolio-design',
                'description' => 'Tampilan modern untuk portofolio website.',
                'picture' => 'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Creative Workspace',
                'slug' => 'creative-workspace',
                'description' => 'Inspirasi ruang kerja kreatif.',
                'picture' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=80',
            ],
        ];

        foreach ($galleries as $gallery) {
            Post::updateOrCreate(
                ['slug' => $gallery['slug']],
                [
                    ...$gallery,
                    'body' => $gallery['description'],
                    'user_id' => $user->id,
                ],
            );
        }
    }
}
