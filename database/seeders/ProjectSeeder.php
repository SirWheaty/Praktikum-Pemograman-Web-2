<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::updateOrCreate(
            ['slug' => 'portfolio-website'],
            [
                'title' => 'Portfolio Website',
                'description' => 'Website portfolio responsif untuk menampilkan profil, keahlian, dan karya terbaik.',
                'category' => 'Web Development',
                'image' => 'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?auto=format&fit=crop&w=1200&q=80',
                'project_url' => 'https://example.com/portfolio',
                'github_url' => 'https://github.com/example/portfolio',
            ],
        );

        Project::updateOrCreate(
            ['slug' => 'task-management-app'],
            [
                'title' => 'Task Management App',
                'description' => 'Aplikasi pengelolaan tugas dengan status, prioritas, dan kolaborasi sederhana.',
                'category' => 'Application',
                'image' => 'https://images.unsplash.com/photo-1540350394557-8d14678e7f91?auto=format&fit=crop&w=1200&q=80',
                'project_url' => 'https://example.com/tasks',
                'github_url' => 'https://github.com/example/task-management',
            ],
        );
    }
}
