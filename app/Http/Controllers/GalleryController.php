<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('gallery.index', [
            'galleries' => Post::whereNotNull('picture')
                ->where('picture', '!=', '')
                ->latest()
                ->paginate(30),
        ]);
    }

    public function create(): View
    {
        return view('gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'picture' => ['required', 'image', 'max:1999'],
        ]);

        $filename = $request->file('picture')->store('posts_image', 'public');

        Auth::user()->posts()->create([
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title']),
            'body' => $validated['description'],
            'description' => $validated['description'],
            'picture' => basename($filename),
        ]);

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil ditambahkan.');
    }

    public function edit(Post $gallery): View
    {
        return view('gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Post $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'picture' => ['nullable', 'image', 'max:1999'],
        ]);

        $updates = [
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title'], $gallery),
            'body' => $validated['description'],
            'description' => $validated['description'],
        ];

        if ($request->hasFile('picture')) {
            $this->deletePicture($gallery->picture);
            $filename = $request->file('picture')->store('posts_image', 'public');
            $updates['picture'] = basename($filename);
        }

        $gallery->update($updates);

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil diperbarui.');
    }

    public function destroy(Post $gallery): RedirectResponse
    {
        $this->deletePicture($gallery->picture);
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil dihapus.');
    }

    private function uniqueSlug(string $title, ?Post $except = null): string
    {
        $baseSlug = Str::slug($title) ?: 'gallery';
        $slug = $baseSlug;
        $counter = 2;

        while (true) {
            $query = Post::where('slug', $slug);
            if ($except !== null) {
                $query->whereKeyNot($except->getKey());
            }
            if (! $query->exists()) {
                return $slug;
            }
            $slug = $baseSlug.'-'.$counter++;
        }
    }

    private function deletePicture(?string $picture): void
    {
        if ($picture && ! Str::startsWith($picture, ['http://', 'https://'])) {
            Storage::disk('public')->delete('posts_image/'.$picture);
        }
    }
}
