@php($title = $project->title)
@extends('layouts.app')

@section('content')
    @php
        $contact = $project->contact ?? [];
        $news = $project->news ?? [];
        $timelineData = $project->timeline ?? [];
        $introParagraphs = $project->intro ? preg_split("/\n{2,}/", $project->intro) : [];
    @endphp

    <section class="bg-[#0E1B0E] text-[#F8FFE8]">
        <div class="relative h-[60vh] w-full overflow-hidden">
            @if ($project->cover_image)
                <img src="{{ $project->cover_image }}" alt="{{ $project->title }}" class="absolute inset-0 h-full w-full object-cover opacity-70">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-[#0E1B0E] via-[#0E1B0E]/80 to-transparent"></div>
            <div class="relative z-10 mx-auto flex h-full max-w-5xl flex-col justify-end px-6 pb-12">
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-200/80">{{ $project->status }}</p>
                <h1 class="mt-4 text-4xl font-semibold leading-tight">{{ $project->title }}</h1>
                <p class="mt-4 max-w-3xl text-base text-white/80">{{ $project->objectif }}</p>
                <div class="mt-6 text-sm text-white/60">
                    {{ optional($project->start_date)->format('d M Y') }} — {{ optional($project->end_date)->format('d M Y') }}
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-6xl px-6 py-10 space-y-10">
            <div class="grid gap-8 md:grid-cols-[2fr,1fr]">
                <div class="space-y-4">
                    @foreach (($introParagraphs ?? []) as $paragraph)
                        <p class="text-white/80 leading-relaxed">{{ $paragraph }}</p>
                    @endforeach
                </div>
                <div class="space-y-6">
                    @if (!empty($contact))
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                            <p class="text-xs uppercase tracking-[0.3em] text-white/50 mb-4">Contact projet</p>
                            <div class="flex items-center gap-4">
                                @if (!empty($contact['avatarUrl']))
                                    <img src="{{ $contact['avatarUrl'] }}" alt="{{ $contact['name'] ?? 'Contact' }}" class="h-16 w-16 rounded-2xl object-cover">
                                @endif
                                <div>
                                    <div class="text-lg font-semibold">{{ $contact['name'] ?? '—' }}</div>
                                    <div class="text-sm text-white/60">{{ $contact['role'] ?? '' }}</div>
                                </div>
                            </div>
                            <div class="mt-4 space-y-2 text-sm text-white/70">
                                @if (!empty($contact['email']))
                                    <div>Email : <a href="mailto:{{ $contact['email'] }}" class="text-emerald-300">{{ $contact['email'] }}</a></div>
                                @endif
                                @if (!empty($contact['phone']))
                                    <div>Téléphone : {{ $contact['phone'] }}</div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if (!empty($news))
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-6 space-y-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-white/50">News</p>
                            <div class="space-y-4">
                                @foreach ($news as $item)
                                    <div class="rounded-xl border border-white/5 bg-white/5 p-4">
                                        <div class="text-xs text-white/50">{{ $item['date'] ?? '' }}</div>
                                        <div class="font-semibold">{{ $item['title'] ?? '' }}</div>
                                        <p class="text-sm text-white/70">{{ $item['description'] ?? '' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if ($project->youtube_id)
                <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                    <div class="aspect-video">
                        <iframe src="https://www.youtube.com/embed/{{ $project->youtube_id }}"
                                class="h-full w-full rounded-2xl"
                                title="Vidéo YouTube"
                                allowfullscreen></iframe>
                    </div>
                </div>
            @endif

            <div class="relative">
                <div class="timeline-line"></div>
                <div class="space-y-6">
                    @foreach ($timelineData as $step)
                        <div class="timeline-step relative rounded-3xl border border-white/10 bg-white/5 p-6 pl-12">
                            <div class="flex flex-wrap items-center gap-3 text-xs uppercase tracking-[0.3em] text-white/50">
                                <span>{{ $step['status'] ?? '' }}</span>
                                <span class="text-white/40">•</span>
                                <span>{{ $step['date'] ?? '' }}</span>
                                @if (!empty($step['iconKey']))
                                    <span class="text-emerald-300">{{ $step['iconKey'] }}</span>
                                @endif
                            </div>
                            <h3 class="mt-3 text-2xl font-semibold">{{ $step['title'] ?? '' }}</h3>
                            <p class="mt-2 text-sm text-white/80">{{ $step['description'] ?? '' }}</p>
                            @if (!empty($step['narrativeBefore']))
                                <p class="mt-4 text-sm text-white/70 leading-relaxed">{{ $step['narrativeBefore'] }}</p>
                            @endif

                            @if (!empty($step['pdf']))
                                <div class="mt-4">
                                    <a href="{{ $step['pdf'] }}" class="inline-flex items-center gap-2 text-sm text-emerald-300 hover:text-emerald-200" target="_blank" rel="noreferrer">
                                        Consulter le PDF
                                    </a>
                                </div>
                            @endif

                            @if (!empty($step['assets']))
                                <div class="mt-4 space-y-2">
                                    @foreach ($step['assets'] as $asset)
                                        <a href="{{ $asset['href'] ?? '#' }}"
                                           @if (!empty($asset['href'])) target="_blank" rel="noreferrer" @endif
                                           class="flex items-center justify-between rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-sm hover:bg-white/10">
                                            <div>
                                                <div class="font-semibold">{{ $asset['label'] ?? 'Asset' }}</div>
                                                <div class="text-xs text-white/50">{{ $asset['type'] ?? '' }}</div>
                                            </div>
                                            <span class="text-xs text-emerald-300">{{ $asset['status'] ?? '' }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            @if (!empty($step['images']))
                                <div class="mt-4 grid gap-3 md:grid-cols-3">
                                    @foreach ($step['images'] as $image)
                                        <div class="rounded-xl border border-white/10 bg-white/5 p-2">
                                            <img src="{{ $image }}" alt="" class="h-40 w-full rounded-lg object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if (!empty($step['videos']))
                                <div class="mt-4 grid gap-4 md:grid-cols-2">
                                    @foreach ($step['videos'] as $video)
                                        <video controls class="w-full rounded-2xl border border-white/10 bg-black/30">
                                            <source src="{{ $video['src'] ?? '' }}" type="video/mp4">
                                        </video>
                                    @endforeach
                                </div>
                            @endif

                            @if (!empty($step['youtubeId']))
                                <div class="mt-4 aspect-video">
                                    <iframe src="https://www.youtube.com/embed/{{ $step['youtubeId'] }}"
                                            class="h-full w-full rounded-2xl"
                                            allowfullscreen></iframe>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
