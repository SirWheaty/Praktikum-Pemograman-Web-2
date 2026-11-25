<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('projects.index', ['projects' => Project::latest()->get()]);
    }

    public function create(): View
    {
        return view('projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['slug'] = $this->uniqueSlug($validated['title']);
        $validated['category_id'] = $this->categoryId($validated['category']);
        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Project berhasil ditambahkan.');
    }

    public function show(Project $project): View
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        return view('projects.create', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['slug'] = $this->uniqueSlug($validated['title'], $project);
        $validated['category_id'] = $this->categoryId($validated['category']);
        $project->update($validated);

        return redirect()->route('projects.show', $project)->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'url', 'max:255'],
            'project_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
        ]);
    }

    private function uniqueSlug(string $title, ?Project $except = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (true) {
            $query = Project::where('slug', $slug);

            if ($except !== null) {
                $query->whereKeyNot($except->getKey());
            }

            if (! $query->exists()) {
                break;
            }

            $slug = $baseSlug.'-'.$counter++;
        }

        return $slug;
    }

    private function categoryId(string $name): int
    {
        $slug = Str::slug($name);
        $category = Category::firstOrCreate(
            ['slug' => $slug],
            ['name' => $name],
        );

        return $category->id;
    }
}
