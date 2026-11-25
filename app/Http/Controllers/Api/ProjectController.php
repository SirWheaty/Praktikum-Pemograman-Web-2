<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::query()
            ->with('categoryRelation')
            ->where('status', 'published')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $category = $request->string('category')->toString();
                $query->whereHas('categoryRelation', fn ($categoryQuery) =>
                    $categoryQuery->where('slug', $category));
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return ProjectResource::collection($projects);
    }

    public function show(Project $project)
    {
        if ($project->status !== 'published') {
            abort(404);
        }

        return new ProjectResource($project->load('categoryRelation'));
    }
}
