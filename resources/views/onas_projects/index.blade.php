@extends('layouts.app')

@section('content')
    <section class="px-6 py-10">
        <div class="mx-auto max-w-5xl space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-white/50">Admin ONAS</p>
                    <h1 class="text-2xl font-semibold">Projets ONAS</h1>
                </div>
                <a href="{{ route('admin.onas-projects.create') }}" class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold uppercase tracking-[0.2em] text-white hover:bg-emerald-400">
                    Nouveau projet
                </a>
            </div>

            @if (session('status'))
                <div class="rounded-2xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-white">
                    {{ session('status') }}
                </div>
            @endif

            <div class="overflow-x-auto rounded-2xl border border-white/10 bg-white/5">
                <table class="min-w-full divide-y divide-white/10 text-sm">
                    <thead class="bg-white/5 text-left text-xs uppercase tracking-[0.2em] text-white/60">
                        <tr>
                            <th class="px-4 py-3">Nom</th>
                            <th class="px-4 py-3">Slug</th>
                            <th class="px-4 py-3">Statut</th>
                            <th class="px-4 py-3">Contact</th>
                            <th class="px-4 py-3">Progression</th>
                            <th class="px-4 py-3">Mise à jour</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse ($projects as $project)
                            <tr>
                                <td class="px-4 py-3 font-semibold">{{ $project->name }}</td>
                                <td class="px-4 py-3 text-white/70">{{ $project->slug }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-full border border-white/10 px-3 py-1 text-xs uppercase tracking-[0.2em] text-white/80">
                                        {{ $project->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-white/70">
                                    {{ optional($project->contactUser)->name ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-white/80">{{ $project->progress }}%</td>
                                <td class="px-4 py-3 text-white/60">{{ optional($project->updated_at)->diffForHumans() }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.onas-projects.edit', $project) }}" class="text-emerald-300 hover:text-emerald-200">Modifier</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-white/60">Aucun projet ONAS pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $projects->links() }}
        </div>
    </section>
@endsection
