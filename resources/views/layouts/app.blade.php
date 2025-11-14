<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Workspace V1' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .timeline-line {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 1.2rem;
            width: 2px;
            background: linear-gradient(180deg, rgba(95, 193, 184, 0.4), rgba(248, 255, 232, 0.2));
        }

        .timeline-step::before {
            content: '';
            position: absolute;
            left: 0.75rem;
            top: 0.75rem;
            width: 14px;
            height: 14px;
            border-radius: 9999px;
            background: #5fc1b8;
            box-shadow: 0 0 0 4px rgba(95, 193, 184, 0.25);
        }
    </style>
    @stack('head')
</head>
<body class="{{ $bodyClass ?? 'workspace-body min-h-screen text-[#F5F0E7]' }}">
    <header class="border-b border-white/10 bg-black/40 backdrop-blur-xl px-6 py-4 flex items-center justify-between text-sm">
        <a href="/" class="text-lg font-semibold tracking-[0.32em] uppercase text-[#B0CA1C]">Levell Workspace</a>
        <nav class="flex items-center gap-3">
            <a href="/projects" class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-xs uppercase tracking-[0.28em] text-white/70 transition hover:border-white/30 hover:text-white">Projets</a>
            @auth
                <a href="{{ route('admin.onas-projects.index') }}" class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-xs uppercase tracking-[0.28em] text-white/70 transition hover:border-white/30 hover:text-white">Admin ONAS</a>
                <form action="{{ route('logout') }}" method="post" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-xs uppercase tracking-[0.28em] text-white/70 transition hover:border-white/30 hover:text-white">
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-xs uppercase tracking-[0.28em] text-white/70 transition hover:border-white/30 hover:text-white">Connexion</a>
            @endauth
        </nav>
    </header>

    @if (session('status'))
        <div class="bg-emerald-600/20 border border-emerald-400/40 text-sm text-emerald-100 px-6 py-3">
            {{ session('status') }}
        </div>
    @endif

    <main class="min-h-[70vh]">
        @yield('content')
    </main>

    <footer class="border-t border-white/10 px-6 py-6 text-xs text-white/60">
        Levell Workspace · Laravel V1 — {{ now()->year }}
    </footer>
    @stack('scripts')
</body>
</html>
