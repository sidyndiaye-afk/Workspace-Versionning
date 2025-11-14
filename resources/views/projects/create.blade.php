@extends('layouts.app')

@section('content')
    <section class="px-6 py-10">
        <div class="max-w-5xl mx-auto space-y-6">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-white/50 mb-1">Admin</p>
                <h1 class="text-2xl font-semibold">Nouveau projet</h1>
            </div>

            <form action="{{ route('admin.projects.store') }}" method="POST" class="space-y-6">
                @include('projects._form')
            </form>
        </div>
    </section>
@endsection
