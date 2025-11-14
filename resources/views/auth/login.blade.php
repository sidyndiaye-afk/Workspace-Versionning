@extends('layouts.app')

@section('content')
    <section class="flex min-h-[70vh] items-center justify-center px-6 py-16">
        <div class="w-full max-w-md space-y-6 rounded-3xl border border-white/10 bg-white/5 p-8 shadow-[0_40px_80px_-60px_rgba(0,0,0,0.8)]">
            <div class="text-center">
                <p class="text-xs uppercase tracking-[0.3em] text-white/50">Administration</p>
                <h1 class="text-2xl font-semibold">Connexion</h1>
            </div>

            @if ($errors->any())
                <div class="rounded-2xl border border-red-400/40 bg-red-500/10 px-4 py-3 text-sm text-red-100">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.perform') }}" method="post" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-white" />
                </div>
                <div class="space-y-2">
                    <label for="password" class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">Mot de passe</label>
                    <input type="password" id="password" name="password" required class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-white" />
                </div>
                <label class="inline-flex items-center gap-2 text-xs text-white/70">
                    <input type="checkbox" name="remember" class="rounded border-white/20 bg-white/10" />
                    Se souvenir de moi
                </label>
                <button type="submit" class="w-full rounded-full bg-emerald-500 py-2 text-sm font-semibold uppercase tracking-[0.3em] text-white hover:bg-emerald-400">
                    Se connecter
                </button>
            </form>
        </div>
    </section>
@endsection
