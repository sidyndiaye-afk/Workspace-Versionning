@extends('layouts.app')

@section('content')
    <section class="px-6 py-10">
        <div class="max-w-5xl mx-auto space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-white/50 mb-1">Admin</p>
                    <h1 class="text-2xl font-semibold">Modifier : {{ $project->title }}</h1>
                </div>
                <a href="{{ route('projects.public.show', $project) }}"
                   class="text-sm text-emerald-300 hover:text-emerald-200">Voir la page</a>
            </div>

            <form action="{{ route('admin.projects.update', $project) }}" method="POST" class="space-y-6">
                @method('PUT')
                @include('projects._form')
            </form>
        </div>
    </section>
@endsection
