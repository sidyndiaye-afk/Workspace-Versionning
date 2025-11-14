@extends('layouts.app')

@section('content')
    <section class="px-6 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="mb-8">
                <p class="text-xs uppercase tracking-[0.3em] text-white/50 mb-2">Workspace</p>
                <h1 class="text-3xl font-semibold">Projets ONAS</h1>
                <p class="text-white/70 mt-2">Retrouvez l’intégralité des dossiers projet importés depuis le frontend Next.js.</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    <a href="{{ route('projects.public.show', $project) }}"
                       class="rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 transition p-5 flex flex-col gap-4">
                        <div class="aspect-[4/3] overflow-hidden rounded-xl bg-slate-900/50">
                            @if ($project->cover_image)
                                <img src="{{ $project->cover_image }}" alt="{{ $project->title }}" class="w-full h-full object-cover opacity-90 hover:opacity-100 transition">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-white/30 text-sm">Pas d’image</div>
                            @endif
                        </div>
                        <div class="text-xs uppercase tracking-[0.25em] text-emerald-300/80">
                            {{ $project->status }}
                        </div>
                        <h2 class="text-xl font-semibold">{{ $project->title }}</h2>
                        <p class="text-sm text-white/70 line-clamp-3">{{ $project->objectif }}</p>
                        <div class="mt-auto text-xs text-white/50">
                            {{ optional($project->start_date)->format('d M Y') }} — {{ optional($project->end_date)->format('d M Y') }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
