<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        return view('post.index', [
            'posts' => Post::with('user')->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('post.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $post = Auth::user()->posts()->create([
            ...$validated,
            'slug' => $this->uniqueSlug($validated['title']),
        ]);

        return redirect()->route('post.show', $post)->with('success', 'Postingan berhasil dibuat.');
    }

    public function show(Post $post): View
    {
        return view('post.show', compact('post'));
    }

    public function profileSaya(): View
    {
        $user = Auth::user();

        return view('post.profile-saya', [
            'user' => $user,
            'posts' => $user->posts()->latest()->paginate(10),
        ]);
    }

    private function uniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title) ?: 'post';
        $slug = $baseSlug;
        $counter = 2;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }

        return $slug;
    }
}
