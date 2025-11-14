@php
    use Illuminate\Support\Str;

    $assetPath = static function (?string $path) {
        if (!$path) {
            return null;
        }

        return Str::startsWith($path, ['http://', 'https://']) ? $path : asset(ltrim($path, '/'));
    };

    $statusLabels = [
        'completed' => 'Livré',
        'in-progress' => 'En cours',
        'on-hold' => 'En attente',
        'future' => 'À venir',
    ];

    $statusBadge = [
        'completed' => 'text-[#B9F977]',
        'in-progress' => 'text-[#72D8D2]',
        'on-hold' => 'text-[#72D8D2]',
        'future' => 'text-white/60',
    ];

    $timelineIntro = collect($project['timeline_intro'] ?? [])->filter();
    $contact = $project['contact'] ?? [];
    $newsItems = $news ?? collect();
    $newsCount = $newsItems->count();
@endphp

@extends('layouts.workspace')

@section('workspace')
<div class="relative min-h-screen bg-[#0E1B0E] text-[#F8FFE8]">
    @include('onas.partials.nav', ['navItems' => $navItems, 'activeHref' => $activeHref])

    <main class="w-full min-h-screen flex flex-col gap-12 pb-20">
        {{-- Hero --}}
        <section class="relative mx-2.5 mb-2.5 mt-0 overflow-hidden rounded-b-[10px] bg-[#0E1B0E] shadow-[0_40px_80px_-60px_rgba(0,0,0,0.6)]">
            <div class="relative h-[72vh] sm:h-[65vh] md:h-[60vh]">
                <img
                    src="{{ $assetPath($project['cover_image'] ?? null) }}"
                    alt="{{ $project['name'] }}"
                    class="hidden h-full w-full object-cover object-top sm:block"
                    loading="lazy"
                />
                @if (!empty($project['cover_image_mobile']))
                    <img
                        src="{{ $assetPath($project['cover_image_mobile']) }}"
                        alt="{{ $project['name'] }}"
                        class="h-full w-full object-cover object-center sm:hidden"
                        loading="lazy"
                    />
                @endif
                <div class="absolute inset-0 bg-gradient-to-b from-white/30 via-[#3C5C3D]/55 to-[#0E1B0E]/92"></div>

                <div class="absolute inset-x-0 bottom-0 px-6 pb-10 md:px-10 lg:px-16">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div class="flex min-w-0 flex-1 flex-col gap-4">
                            <h1 class="text-3xl font-semibold text-[#F8FFE8] drop-shadow-[0_24px_48px_rgba(6,14,8,0.6)]">
                                {{ $project['name'] }}
                            </h1>
                            <div class="flex flex-wrap gap-6 text-[0.75rem] font-medium uppercase tracking-[0.18em] text-white/80">
                                @if (!empty($project['start']))
                                    <span>
                                        Démarré&nbsp;:
                                        <span class="font-semibold normal-case tracking-normal text-white">
                                            {{ $project['start'] }}
                                        </span>
                                    </span>
                                @endif
                                @php
                                    $endLabel = ($project['status'] ?? '') === 'TERMINÉ' ? 'Livré' : 'Échéance';
                                    $endValue = $project['status'] === 'TERMINÉ'
                                        ? ($project['end'] ?? null)
                                        : ($project['due'] ?? $project['end'] ?? null);
                                @endphp
                                @if ($endValue)
                                    <span>
                                        {{ $endLabel }}&nbsp;:
                                        <span class="font-semibold normal-case tracking-normal text-white">
                                            {{ $endValue }}
                                        </span>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <div class="relative flex flex-col items-center gap-2 text-center">
                                <div class="relative h-24 w-24">
                                    <div class="absolute inset-0 overflow-hidden rounded-full border border-white/30 bg-white/30 shadow-[0_18px_45px_-18px_rgba(4,12,6,0.45)]">
                                        <div class="water-fill-mask absolute inset-[6px] overflow-hidden rounded-full border border-[#F2F7E3] bg-[#F8FCEA]">
                                            <div class="water-fill" style="height: {{ $stats['progress'] ?? 0 }}%"></div>
                                            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_28%_20%,rgba(255,255,255,0.45),transparent_55%)] opacity-70 mix-blend-soft-light"></div>
                                            <div class="pointer-events-none absolute inset-x-0 top-1 h-[32%] bg-gradient-to-b from-white/60 via-white/10 to-transparent opacity-45"></div>
                                        </div>
                                    </div>
                                    <span class="absolute inset-0 flex flex-col items-center justify-center text-lg font-semibold text-[#0B1A0D] drop-shadow-[0_4px_12px_rgba(255,255,255,0.35)]">
                                        {{ $stats['progress'] ?? 0 }}%
                                    </span>
                                </div>
                                <span class="text-xs uppercase tracking-[0.2em] text-white/60">Avancement</span>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        @if (!empty($project['objective']))
            <section class="px-6 md:px-10 lg:px-16">
                <div class="rounded-3xl border border-white/10 bg-[#142414]/70 p-6 text-sm text-[#D7E8CD] shadow-[0_30px_60px_-40px_rgba(3,8,6,0.9)]">
                    {{ $project['objective'] }}
                </div>
            </section>
        @endif

        {{-- KPI + News + Contact --}}
        <section class="px-6 md:px-10 lg:px-16">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-[2fr_5fr_3fr]">
                <div class="flex flex-col gap-4 rounded-2xl border border-white/10 bg-[#132215] p-6 shadow-[0_24px_60px_-32px_rgba(0,0,0,0.65)]">
                    <div class="flex items-baseline justify-between">
                        <h3 class="text-sm uppercase tracking-[0.22em] text-[#91A982]">Tâches</h3>
                        <span class="text-xs uppercase tracking-[0.2em] text-white/40">Timeline</span>
                    </div>
                    <div class="flex items-end justify-center gap-2 text-[#F8FFE8]">
                        <span class="text-[140px] leading-none">{{ $stats['completed'] ?? 0 }}</span>
                        <span class="text-5xl font-light">/{{ $stats['total'] ?? 0 }}</span>
                    </div>
                    <p class="text-xs uppercase tracking-[0.22em] text-[#9AB58B]">Étapes validées</p>
                    <div class="flex items-center gap-3">
                        <div class="h-2 w-full overflow-hidden rounded-full bg-white/5">
                            <div class="h-full rounded-full bg-gradient-to-r from-[#CBEA6A] via-[#8DC75E] to-[#4F8D42]" style="width: {{ $stats['progress'] ?? 0 }}%"></div>
                        </div>
                        <span class="text-sm font-semibold text-[#CBEA6A]">{{ $stats['progress'] ?? 0 }}%</span>
                    </div>
                </div>

                <div class="relative rounded-2xl border border-white/10 bg-[#101C10] shadow-[0_24px_60px_-32px_rgba(0,0,0,0.65)]" data-news-carousel>
                    @if ($newsCount > 0)
                        <div class="relative h-[320px] sm:h-[360px] overflow-hidden">
                            <div class="flex h-full transition-transform duration-500 ease-out" data-news-track>
                                @foreach ($newsItems as $index => $item)
                                    @php
                                        $anchorHref = !empty($item['anchor']) ? '#' . $item['anchor'] : null;
                                        $slideTag = $anchorHref ? 'a' : 'div';
                                    @endphp
                                    <{{ $slideTag }}
                                        @if($anchorHref) href="{{ $anchorHref }}" @endif
                                        class="news-slide flex h-full min-w-full flex-col gap-4 px-6 py-6 sm:px-8"
                                    >
                                        <div class="flex flex-col gap-3">
                                            <span class="text-[0.65rem] uppercase tracking-[0.22em] text-[#C7DAB6]">{{ $item['date'] ?? '' }}</span>
                                            <h4 class="text-lg font-semibold text-white">{{ $item['title'] ?? '' }}</h4>
                                            @if (!empty($item['description']))
                                                <p class="text-sm text-[#C6D9C0]">{{ $item['description'] }}</p>
                                            @endif
                                        </div>
                                        @if (!empty($item['image']))
                                            <div class="flex flex-1 items-center justify-center">
                                                <img src="{{ $assetPath($item['image']) }}" alt="{{ $item['title'] ?? '' }}" class="max-h-48 w-full rounded-2xl object-cover" loading="lazy">
                                            </div>
                                        @endif
                                        <div class="flex items-center justify-between text-[0.65rem] uppercase tracking-[0.18em] text-white/50">
                                            <span>News projet</span>
                                            <span data-news-counter></span>
                                        </div>
                                    </{{ $slideTag }}>
                                @endforeach
                            </div>
                            @if ($newsCount > 1)
                                <button type="button" class="news-arrow left" data-news-prev aria-label="Actualité précédente">
                                    <x-icon name="chevron-down" class="h-4 w-4 rotate-90" />
                                </button>
                                <button type="button" class="news-arrow right" data-news-next aria-label="Actualité suivante">
                                    <x-icon name="chevron-down" class="h-4 w-4 -rotate-90" />
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="flex h-full min-h-[220px] items-center justify-center px-6 text-center">
                            <p class="text-xs uppercase tracking-[0.16em] text-[#7F8D78]">Aucune actualité partagée pour l’instant.</p>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col items-center gap-6 rounded-2xl border border-white/10 bg-gradient-to-br from-[#23341B] via-[#182711] to-[#101B0A] p-6 text-center text-[#F0F8E6] shadow-[0_30px_70px_-32px_rgba(8,14,6,0.6)]">
                    <div class="relative h-28 w-28 overflow-hidden rounded-[1.2rem] border border-white/20 bg-white/5 shadow-[0_22px_48px_-26px_rgba(10,18,8,0.7)]">
                        <img
                            src="{{ $assetPath($contact['avatar'] ?? '/media/photo_sidy.jpeg') }}"
                            alt="{{ $contact['name'] ?? 'Contact projet' }}"
                            class="h-full w-full object-cover"
                            style="object-position: {{ $contact['avatar_position'] ?? 'center' }}"
                            loading="lazy"
                        >
                    </div>
                    <div class="flex flex-col items-center gap-2 text-sm">
                        <span class="text-[0.62rem] uppercase tracking-[0.28em] text-[#9CB88F]">Contact projet</span>
                        <span class="text-xl font-semibold uppercase tracking-[0.2em] text-[#F8FFE8]">{{ $contact['name'] ?? 'SIDY BOUYA NDIAYE' }}</span>
                        <span class="rounded-full bg-white/10 px-4 py-1 text-[0.7rem] uppercase tracking-[0.18em] text-[#CBEA6A]">{{ $contact['role'] ?? 'IT Manager' }}</span>
                    </div>
                    <div class="h-px w-12 rounded-full bg-white/15"></div>
                    <div class="flex flex-col items-center gap-3 text-sm font-medium tracking-wide text-[#E3F2D5]">
                        @if (!empty($contact['phone']))
                            <span class="inline-flex items-center gap-2">
                                <x-icon name="phone" class="h-4 w-4 text-[#CBEA6A]" />
                                <span>{{ $contact['phone'] }}</span>
                            </span>
                        @endif
                        @if (!empty($contact['email']))
                            <span class="inline-flex flex-wrap items-center justify-center gap-2 text-[0.85rem] lowercase">
                                <x-icon name="mail" class="h-4 w-4 text-[#CBEA6A]" />
                                <a href="mailto:{{ $contact['email'] }}" class="break-all text-[#F8FFE8]">{{ $contact['email'] }}</a>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- Timeline --}}
        <section class="flex flex-col gap-10 px-6 md:px-10 lg:px-16">
            <div class="flex flex-col gap-2">
                <h2 class="text-lg font-semibold uppercase tracking-[0.3em] text-[#F8FFE8]">Étapes du projet</h2>
                <p class="text-xs uppercase tracking-[0.24em] text-[#6F7D6C]">Défilez pour suivre chaque jalon</p>
            </div>

            <div class="relative pl-0 sm:pl-24">
                <div class="timeline-line">
                    <div class="timeline-line-gradient" style="background: {{ $timelineStyles['statusGradient'] ?? 'rgba(45,62,45,0.45)' }}"></div>
                    <div class="timeline-line-progress" style="background: {{ $timelineStyles['completedGradient'] ?? '#B9F977' }}; height: {{ $timelineStyles['completedHeight'] ?? 0 }}%"></div>
                </div>

                <div class="flex flex-col gap-12 sm:gap-16" data-timeline-container>
                    @if ($timelineIntro->isNotEmpty())
                        <div class="w-full max-w-xl sm:max-w-none sm:pl-20">
                            <div class="space-y-4 text-sm italic leading-relaxed text-[#DCEBD2]/90 sm:text-base">
                                @foreach ($timelineIntro as $line)
                                    <p>{{ $line }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @foreach ($timeline as $index => $step)
                        @php
                            $stepId = $step['anchor'] ?? Str::slug($step['title'] ?? ('etape-' . $index));
                            $status = $step['status'] ?? 'future';
                            $badgeClass = $statusBadge[$status] ?? 'text-white/60';
                            $label = $statusLabels[$status] ?? $statusLabels['future'];
                            $backgroundImage = $assetPath($step['background_image'] ?? null);
                            $backgroundImageMobile = $assetPath($step['background_image_mobile'] ?? $step['background_image'] ?? null);
                            $overlay = $step['background_overlay'] ?? 'linear-gradient(120deg, rgba(14,27,14,0.95) 0%, rgba(14,27,14,0.85) 60%, rgba(14,27,14,0.4) 100%)';
                        @endphp
                        <article id="{{ $stepId }}" class="timeline-step relative w-full max-w-xl sm:max-w-none sm:pl-20" data-timeline-step data-timeline-status="{{ $status }}">
                            <div class="timeline-marker">
                                <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="timeline-card relative overflow-hidden rounded-[24px] border border-white/10 bg-[#111D11]/90 p-6 shadow-[0_32px_60px_-28px_rgba(6,12,10,0.8)]">
                                @if ($backgroundImage)
                                    <div class="absolute inset-0">
                                        <picture>
                                            @if ($backgroundImageMobile && $backgroundImageMobile !== $backgroundImage)
                                                <source media="(max-width: 640px)" srcset="{{ $backgroundImageMobile }}">
                                            @endif
                                            <img src="{{ $backgroundImage }}" alt="{{ $step['title'] ?? '' }}" class="h-full w-full object-cover" loading="lazy">
                                        </picture>
                                        <div class="absolute inset-0" style="background: {{ $overlay }}"></div>
                                    </div>
                                @endif
                                <div class="relative z-10 space-y-4">
                                    <div class="flex flex-wrap items-center gap-3 text-xs uppercase tracking-[0.2em]">
                                        <span class="rounded-full border border-white/10 px-3 py-1 text-white/70">{{ $step['date'] ?? '' }}</span>
                                        <span class="font-semibold {{ $badgeClass }}">{{ $label }}</span>
                                    </div>
                                    <div class="flex flex-col gap-3">
                                        <h3 class="text-2xl font-semibold">{{ $step['title'] ?? '' }}</h3>
                                        @if (!empty($step['description']))
                                            <p class="text-sm text-white/80">{{ $step['description'] }}</p>
                                        @endif
                                    </div>
                                    @if (!empty($step['narrative_before']))
                                        @foreach ((array) $step['narrative_before'] as $paragraph)
                                            <p class="text-sm text-white/70">{{ $paragraph }}</p>
                                        @endforeach
                                    @endif

                                    @if (!empty($step['assets']))
                                        <div class="space-y-2">
                                            @foreach ($step['assets'] as $asset)
                                                @php
                                                    $assetLabel = $asset['label'] ?? 'Pièce jointe';
                                                    $assetType = strtoupper($asset['type'] ?? 'LIEN');
                                                    $assetHref = $asset['href'] ?? null;
                                                @endphp
                                                <a
                                                    @if($assetHref) href="{{ $assetPath($assetHref) }}" target="{{ Str::startsWith($assetHref, ['http://', 'https://']) ? '_blank' : '_self' }}" @endif
                                                    class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white transition hover:bg-white/10"
                                                >
                                                    <div>
                                                        <p class="font-semibold">{{ $assetLabel }}</p>
                                                        <p class="text-xs text-white/60">{{ $assetType }}</p>
                                                    </div>
                                                    @if ($assetHref)
                                                        <span class="text-xs uppercase tracking-[0.2em] text-[#CBEA6A]">Ouvrir</span>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if (!empty($step['images']))
                                        @if (!empty($step['images_button_label']))
                                            <p class="text-xs uppercase tracking-[0.2em] text-white/60">{{ $step['images_button_label'] }}</p>
                                        @endif
                                        <div class="grid gap-3 sm:grid-cols-2">
                                            @foreach ($step['images'] as $image)
                                                <figure class="overflow-hidden rounded-2xl border border-white/10 bg-white/5">
                                                    <img src="{{ $assetPath($image) }}" alt="{{ $step['title'] ?? '' }}" class="h-48 w-full object-cover" loading="lazy">
                                                </figure>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if (!empty($step['videos']))
                                        <div class="grid gap-4 sm:grid-cols-{{ count($step['videos']) > 1 ? 2 : 1 }}">
                                            @foreach ($step['videos'] as $video)
                                                <video controls class="w-full rounded-2xl border border-white/10 bg-black/30">
                                                    <source src="{{ $assetPath($video['src'] ?? null) }}" type="video/mp4">
                                                </video>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if (!empty($step['youtube_id']))
                                        <div class="aspect-video">
                                            <iframe
                                                src="https://www.youtube.com/embed/{{ $step['youtube_id'] }}"
                                                class="h-full w-full rounded-2xl"
                                                loading="lazy"
                                                allowfullscreen
                                            ></iframe>
                                        </div>
                                    @endif

                                    @if (!empty($step['narrative_after']))
                                        @foreach ((array) $step['narrative_after'] as $paragraph)
                                            <p class="text-sm text-white/70">{{ $paragraph }}</p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        @include('partials.workspace-footer')
    </main>
</div>
@endsection
