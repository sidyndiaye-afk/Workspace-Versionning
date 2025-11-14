@extends('layouts.app')

@section('content')
    <section class="px-6 py-10">
        <div class="max-w-6xl mx-auto space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-white/50 mb-1">Admin</p>
                    <h1 class="text-2xl font-semibold">Gestion des projets</h1>
                </div>
                <a href="{{ route('admin.projects.create') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-emerald-500/90 px-4 py-2 text-sm font-semibold uppercase tracking-wide text-white hover:bg-emerald-400">
                    Nouveau projet
                </a>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-white/10 bg-white/5">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-xs uppercase tracking-[0.25em] text-white/60">
                        <tr>
                            <th class="px-4 py-3">Titre</th>
                            <th class="px-4 py-3">Slug</th>
                            <th class="px-4 py-3">Statut</th>
                            <th class="px-4 py-3">Période</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr class="border-t border-white/5">
                                <td class="px-4 py-4">
                                    <div class="font-semibold">{{ $project->title }}</div>
                                    <div class="text-xs text-white/50">Créé le {{ $project->created_at->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-4 py-4 text-white/80">{{ $project->slug }}</td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center rounded-full border border-white/10 px-3 py-1 text-xs">
                                        {{ $project->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-white/70">
                                    {{ optional($project->start_date)->format('d/m/Y') }} - {{ optional($project->end_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('projects.public.show', $project) }}" class="text-xs text-emerald-300 hover:text-emerald-200">Voir</a>
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="text-xs text-blue-300 hover:text-blue-200">Éditer</a>
                                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Supprimer ce projet ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-rose-300 hover:text-rose-200">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div>
                {{ $projects->links() }}
            </div>
        </div>
    </section>
@endsection
