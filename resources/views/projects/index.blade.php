<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects | Portfolio</title>
    <style>
        :root { --ink: #17202a; --muted: #667085; --accent: #e05a3f; --paper: #f7f3ed; }
        * { box-sizing: border-box; } body { margin: 0; color: var(--ink); background: var(--paper); font-family: Georgia, serif; }
        nav, main { max-width: 1080px; margin: auto; padding: 28px 24px; } nav { display: flex; justify-content: space-between; align-items: center; font-family: Arial, sans-serif; }
        nav a { color: var(--ink); text-decoration: none; margin-left: 18px; } .brand { font-weight: bold; letter-spacing: .08em; }
        .hero { max-width: 1080px; margin: 40px auto 24px; padding: 0 24px; } h1 { font-size: clamp(2.5rem, 7vw, 5.5rem); line-height: .95; margin: 0 0 16px; max-width: 700px; } .intro { color: var(--muted); font: 1.1rem/1.6 Arial, sans-serif; max-width: 580px; }
        .notice { padding: 14px 18px; border-left: 4px solid var(--accent); background: #fff; font: 14px Arial, sans-serif; } .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; margin-top: 36px; }
        article { background: #fff; border: 1px solid #e4ddd4; } article img, .placeholder { width: 100%; height: 210px; object-fit: cover; display: block; background: #d8c8b7; } article section { padding: 22px; } .category { color: var(--accent); font: 12px Arial, sans-serif; text-transform: uppercase; letter-spacing: .12em; } h2 { margin: 9px 0; font-size: 1.7rem; } p { color: var(--muted); font: 15px/1.6 Arial, sans-serif; } .button { display: inline-block; padding: 11px 15px; color: #fff; background: var(--ink); text-decoration: none; font: 13px Arial, sans-serif; } .empty { color: var(--muted); font: 16px Arial, sans-serif; }
    </style>
</head>
<body>
    <nav><a class="brand" href="{{ route('projects.index') }}">ANTONIO / PROJECTS</a><div><a href="{{ url('/') }}">Home</a><a href="{{ route('projects.create') }}">Tambah Project</a></div></nav>
    <header class="hero"><h1>Karya yang pernah saya bangun.</h1><p class="intro">Kumpulan project pilihan, dari website hingga aplikasi yang membantu menyelesaikan masalah nyata.</p></header>
    <main>
        @if (session('success')) <div class="notice">{{ session('success') }}</div> @endif
        <div class="grid">
            @forelse ($projects as $project)
                <article>
                    @if ($project->image) <img src="{{ $project->image }}" alt="{{ $project->title }}"> @else <div class="placeholder"></div> @endif
                    <section><span class="category">{{ $project->category }}</span><h2>{{ $project->title }}</h2><p>{{ \Illuminate\Support\Str::limit($project->description, 120) }}</p><a class="button" href="{{ route('projects.show', $project) }}">Lihat detail</a></section>
                </article>
            @empty
                <p class="empty">Belum ada project. Tambahkan project pertama Anda.</p>
            @endforelse
        </div>
    </main>
</body>
</html>