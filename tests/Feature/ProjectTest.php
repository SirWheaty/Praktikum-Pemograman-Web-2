<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\ProjectSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_are_public_and_project_changes_require_authentication(): void
    {
        $project = Project::create([
            'title' => 'Example Project',
            'slug' => 'example-project',
            'description' => 'A project used for route tests.',
            'category' => 'Testing',
        ]);

        $this->get(route('projects.index'))
            ->assertOk()
            ->assertSee('Example Project');
        $this->get(route('projects.show', $project))->assertOk();
        $this->getJson('/api/projects')
            ->assertOk()
            ->assertJsonPath('data.0.slug', 'example-project');
        $this->get(route('projects.create'))->assertRedirect(route('login'));
    }

    public function test_updating_project_title_preserves_a_unique_slug(): void
    {
        $this->actingAs(User::factory()->create());

        $first = Project::create([
            'title' => 'First Project',
            'slug' => 'first-project',
            'description' => 'First project.',
            'category' => 'Testing',
        ]);
        Project::create([
            'title' => 'Second Project',
            'slug' => 'second-project',
            'description' => 'Second project.',
            'category' => 'Testing',
        ]);

        $this->put(route('projects.update', $first), [
            'title' => 'Second Project',
            'description' => 'Updated project.',
            'category' => 'Testing',
        ])->assertRedirect(route('projects.show', $first));

        $this->assertDatabaseHas('projects', [
            'id' => $first->id,
            'slug' => 'second-project-2',
        ]);
    }

    public function test_projects_api_supports_search_category_and_category_counts(): void
    {
        $category = Category::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
        ]);
        Project::create([
            'title' => 'Portfolio App',
            'slug' => 'portfolio-app',
            'description' => 'A portfolio project.',
            'category' => $category->name,
            'category_id' => $category->id,
            'status' => 'published',
        ]);

        $this->getJson('/api/projects?search=portfolio')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.slug', 'portfolio-app');

        $this->getJson('/api/projects?category=web-development')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.slug', 'portfolio-app');

        $this->getJson('/api/categories')
            ->assertOk()
            ->assertJsonFragment([
                'name' => 'Web Development',
                'projects_count' => 1,
            ]);
    }

    public function test_project_seeder_can_run_more_than_once(): void
    {
        $this->seed(ProjectSeeder::class);
        $this->seed(ProjectSeeder::class);

        $this->assertDatabaseCount('projects', 2);
    }
}
