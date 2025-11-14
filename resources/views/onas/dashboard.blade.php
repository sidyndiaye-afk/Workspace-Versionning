@extends('layouts.workspace')

@php
    $gridMap = [0 => 'md:col-span-3', 1 => 'md:col-span-3', 2 => 'md:col-span-4', 3 => 'md:col-span-2', 4 => 'md:col-span-3', 5 => 'md:col-span-3'];
@endphp

@section('workspace')
<div class="relative flex-1">
    @include('onas.partials.nav', ['navItems' => $navItems, 'activeHref' => $activeHref])
    <main>
        <section class="relative isolate flex min-h-screen w-full flex-col justify-center overflow-hidden bg-[#0D1610] px-6 py-14 sm:px-10 lg:px-20">
            <div class="pointer-events-none absolute inset-0 bg-cover bg-center opacity-100" style="background-image: url('{{ asset('media/home.png') }}');"></div>
            <div class="relative h-[70vh]"></div>
        </section>

        <section class="relative bg-gradient-to-br from-[#0F1911] via-[#0D1513] to-[#0A1617]">
            <div class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(900px_520px_at_6%_-8%,rgba(176,202,28,0.1),transparent_60%)]"></div>
            <div class="pointer-events-none absolute inset-0 -z-10 bg-[linear-gradient(140deg,rgba(18,56,40,0.16),transparent_55%,rgba(114,216,199,0.08))]"></div>
            <div class="mx-auto w-full max-w-[1440px] space-y-10 px-5 py-10 md:px-8 lg:px-12">
                <header class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div class="space-y-2">
                        <h1 class="text-xl font-semibold tracking-wide text-[#F8FFF1] md:text-2xl">Vue d’ensemble des projets</h1>
                        <p class="max-w-xl text-sm text-[#A7C0AF]">Synthèse opérationnelle des livrables, chantiers prioritaires et dynamique globale de production.</p>
                    </div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-[rgba(176,202,28,0.35)] bg-black/25 px-4 py-2 text-xs uppercase tracking-[0.32em] text-[#B0CA1C]">Mise à jour live</span>
                </header>

                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($kpiCards as $card)
                        <article class="min-h-[220px] rounded-[20px] border border-[#B0CA1C26] p-6 text-[#E6F3DB] {{ $card['tileClass'] }}">
                            <div class="flex h-full flex-col gap-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl {{ $card['iconClass'] }}">
                                        <x-icon :name="$card['icon']" class="h-5 w-5" />
                                    </div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.32em] {{ $card['labelClass'] }}">{{ $card['label'] }}</p>
                                </div>
                                @if ($card['type'] === 'progress')
                                    <div class="flex flex-1 items-center justify-center py-4">
                                        <div class="flex h-44 w-44 flex-col items-center justify-center rounded-full border border-white/10 bg-black/20 text-center">
                                            <span class="text-4xl font-semibold text-[#72D8D2]">{{ $card['value'] }}%</span>
                                            <span class="mt-2 text-[0.65rem] uppercase tracking-[0.3em] text-white/50">Avancement global</span>
                                        </div>
                                    </div>
                                @else
                                    <ul class="flex flex-1 flex-col gap-2.5 p-1">
                                        @forelse ($card['entries'] as $entry)
                                            <li class="flex items-center gap-3 rounded-xl bg-black/20 px-3 py-2">
                                                <div class="flex h-9 w-9 items-center justify-center rounded-lg {{ $card['entryIconClass'] }}">
                                                    <x-icon :name="$entry['icon']" class="h-4 w-4" />
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between text-sm font-medium text-white/85">
                                                        <span>{{ $entry['title'] }}</span>
                                                        <span class="text-xs font-semibold text-white/45">{{ $entry['progress'] }}%</span>
                                                    </div>
                                                    <span class="text-[0.65rem] uppercase tracking-[0.2em] text-white/45">{{ $entry['detail'] }}</span>
                                                    <div class="mt-2 h-1.5 w-full rounded-full bg-white/10">
                                                        <div class="h-full rounded-full {{ $entry['barClass'] }}" style="width: {{ $entry['progress'] }}%"></div>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-sm text-white/50">{{ $card['empty'] }}</li>
                                        @endforelse
                                    </ul>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="flex flex-col gap-6 text-[#ECF8E8]">
                    <div class="flex flex-wrap gap-3 text-xs text-white/65">
                        <span class="inline-flex items-center gap-2 rounded-full border border-[#B0CA1C26] bg-black/15 px-3 py-1">
                            <span class="h-2 w-2 rounded-full bg-[#B0CA1C]"></span>
                            {{ $stats['completed'] }} livrés
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full border border-[#B0CA1C26] bg-black/15 px-3 py-1">
                            <span class="h-2 w-2 rounded-full bg-[#6ED8D3]"></span>
                            {{ $stats['ongoing'] }} en cours
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full border border-[#B0CA1C26] bg-black/15 px-3 py-1">
                            <span class="h-2 w-2 rounded-full bg-[#78CFE0]"></span>
                            {{ $stats['average'] }}% de progression moyenne
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-[var(--tile-gap)] md:grid-cols-6 [grid-auto-rows:1fr]">
                        @foreach ($heroTiles as $index => $tile)
                            <div class="{{ $gridMap[$index] ?? 'md:col-span-3' }}">
                                <x-project-tile-metro
                                    :title="$tile['title']"
                                    :status="$tile['status']"
                                    :summary="$tile['summary']"
                                    :progress="$tile['progress']"
                                    :image="$tile['image']"
                                    :href="$tile['href']"
                                    :icon="$tile['icon']"
                                    :glow="$tile['glow']"
                                />
                            </div>
                        @endforeach
                    </div>

                    <section class="mt-12 space-y-6">
                        <header class="flex flex-col gap-2">
                            <h2 class="text-lg font-semibold uppercase tracking-[0.28em] text-[#B0CA1C]">Focus Campagne Gamou</h2>
                            <p class="max-w-2xl text-sm text-[#A7C0AF]">De la stratégie aux livrables finaux : retrouvez le plan digital Gamou, les créations associées et la campagne vidéo montée.</p>
                        </header>
                        <div class="grid gap-[var(--tile-gap)] md:grid-cols-3 [grid-auto-rows:1fr]">
                            @foreach ($gamouFocus as $tile)
                                <x-project-tile-metro
                                    :title="$tile['title']"
                                    :status="$tile['status']"
                                    :summary="$tile['summary']"
                                    :progress="$tile['progress']"
                                    :image="$tile['image']"
                                    :href="$tile['href']"
                                    :icon="$tile['icon']"
                                    glow
                                />
                            @endforeach
                        </div>
                    </section>

                    <section class="mt-12 space-y-6">
                        <header class="flex flex-col gap-2">
                            <h2 class="text-lg font-semibold uppercase tracking-[0.28em] text-[#72D8D2]">Créations ONAS disponibles</h2>
                            <p class="max-w-2xl text-sm text-[#A7C0AF]">Les campagnes Tabaski et Hivernage sont prêtes : maquettes officielles, déclinaisons print et fichiers sources sont accessibles en un clic.</p>
                        </header>
                        <div class="grid gap-[var(--tile-gap)] md:grid-cols-2 [grid-auto-rows:1fr]">
                            @foreach ($creaHighlights as $tile)
                                <x-project-tile-metro
                                    :title="$tile['title']"
                                    :status="$tile['status']"
                                    :summary="$tile['summary']"
                                    :progress="$tile['progress']"
                                    :image="$tile['image']"
                                    :href="$tile['href']"
                                    :icon="$tile['icon']"
                                />
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </section>
        @include('partials.workspace-footer')
    </main>
</div>
@endsection
