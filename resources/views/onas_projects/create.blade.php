@extends('layouts.app')

@section('content')
    <section class="px-6 py-10">
        <div class="mx-auto max-w-4xl space-y-6">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-white/50">Admin ONAS</p>
                <h1 class="text-2xl font-semibold">Nouveau projet</h1>
            </div>

            @if ($errors->any())
                <div class="rounded-2xl border border-red-400/40 bg-red-500/10 px-4 py-3 text-sm text-red-100">
                    <p class="font-semibold">Veuillez corriger les champs suivants :</p>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.onas-projects.store') }}" method="post" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @include('onas_projects._form', ['project' => $project, 'users' => $users])

                <div class="flex justify-end">
                    <button type="submit" class="rounded-full bg-emerald-500 px-6 py-2 text-sm font-semibold uppercase tracking-[0.2em] text-white hover:bg-emerald-400">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
