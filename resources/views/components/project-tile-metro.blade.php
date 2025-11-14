@props([
    'title',
    'status' => 'encours',
    'summary' => '',
    'progress' => 0,
    'image' => null,
    'href' => null,
    'icon' => null,
    'glow' => false,
    'class' => '',
])
@php
    $statuses = [
        'termine' => [
            'label' => 'TERMINÉ',
            'badge' => 'bg-[#B0CA1C20] border-[#B0CA1CB3] text-[#E9F6E1]',
            'card' => 'border border-[#B0CA1C26] ring-1 ring-[#B0CA1C1f] bg-[rgba(13,24,16,0.78)] text-[#F6FFE8]',
            'glow' => 'border-[#B0CA1C66] ring-[#B0CA1C33] shadow-[0_0_0_1px_rgba(176,202,28,0.35),0_28px_70px_-24px_rgba(176,202,28,0.45)] before:pointer-events-none before:absolute before:inset-0 before:-z-10 before:rounded-[20px] before:bg-[radial-gradient(circle_at_30%_20%,rgba(176,202,28,0.25),transparent_60%)]',
            'accent' => 'text-[#B0CA1C]',
            'metrics' => 'text-[#E5F2DD]/80',
            'summary' => 'text-[#D3DACF]/85',
            'progress' => 'bg-gradient-to-r from-[#B0CA1C] via-[#9FC11A] to-[#6A9420]',
            'progressGlow' => 'bg-gradient-to-r from-[#B0CA1C] via-[#CFEA6A] to-[#6ED8D3]',
            'ctaBase' => 'border border-[#B0CA1C4d] bg-[#B0CA1C1a] text-[#EAF2D6] shadow-[0_12px_32px_-18px_rgba(176,202,28,0.65)]',
            'ctaHover' => 'hover:border-[#B0CA1C80] hover:bg-[#B0CA1C2b] hover:text-[#F7FFE8] hover:backdrop-blur-md hover:shadow-[0_16px_40px_-18px_rgba(176,202,28,0.75)]',
            'mediaRing' => 'ring-1 ring-[#B0CA1C1a]',
            'mediaGlow' => 'ring-[#B0CA1C40]',
        ],
        'encours' => [
            'label' => 'EN COURS',
            'badge' => 'bg-[#72D8D21a] border-[#72D8D2B3] text-[#72D8D2]',
            'card' => 'border border-[#72D8D24d] ring-1 ring-[#72D8D21f] bg-[rgba(10,26,28,0.76)] text-[#E6F7F8]',
            'glow' => 'border-[#72D8D266] ring-[#72D8D233] shadow-[0_0_0_1px_rgba(114,216,210,0.35),0_28px_70px_-24px_rgba(114,216,210,0.45)] before:pointer-events-none before:absolute before:inset-0 before:-z-10 before:rounded-[20px] before:bg-[radial-gradient(circle_at_30%_20%,rgba(114,216,210,0.28),transparent_60%)]',
            'accent' => 'text-[#72D8D2]',
            'metrics' => 'text-[#72D8D2]/80',
            'summary' => 'text-[#CDEBEC]/85',
            'progress' => 'bg-gradient-to-r from-[#72D8D2] via-[#58BFC0] to-[#2A8C8A]',
            'progressGlow' => 'bg-gradient-to-r from-[#72D8D2] via-[#9FE5E1] to-[#4CC4C6]',
            'ctaBase' => 'border border-[#72D8D24d] bg-[#72D8D21a] text-[#E5FBFB] shadow-[0_12px_32px_-18px_rgba(114,216,210,0.55)]',
            'ctaHover' => 'hover:border-[#72D8D280] hover:bg-[#72D8D22b] hover:text-[#F2FFFF] hover:backdrop-blur-md hover:shadow-[0_16px_40px_-18px_rgba(114,216,210,0.65)]',
            'mediaRing' => 'ring-1 ring-[#72D8D21a]',
            'mediaGlow' => 'ring-[#72D8D240]',
        ],
        'bloque' => [
            'label' => 'BLOQUÉ',
            'badge' => 'bg-[#FFCE5A1F] border-[#FFCE5AB3] text-[#FFCE5A]',
            'card' => 'border border-[#FFCE5A40] ring-1 ring-[#FFCE5A1f] bg-[rgba(36,24,12,0.78)] text-[#FFF4DE]',
            'glow' => 'border-[#FFCE5A66] ring-[#FFCE5A33] shadow-[0_0_0_1px_rgba(255,206,90,0.35),0_28px_70px_-24px_rgba(255,206,90,0.45)] before:pointer-events-none before:absolute before:inset-0 before:-z-10 before:rounded-[20px] before:bg-[radial-gradient(circle_at_30%_20%,rgba(255,206,90,0.28),transparent_60%)]',
            'accent' => 'text-[#FFCE5A]',
            'metrics' => 'text-[#FFE9C9]/80',
            'summary' => 'text-[#F8E2BF]/85',
            'progress' => 'bg-gradient-to-r from-[#FFCE5A] via-[#FFB347] to-[#FF8A3C]',
            'progressGlow' => 'bg-gradient-to-r from-[#FFCE5A] via-[#FFDFA0] to-[#FFB667]',
            'ctaBase' => 'border border-[#FFCE5A4d] bg-[#FFCE5A1a] text-[#FFF3DD] shadow-[0_12px_32px_-18px_rgba(255,206,90,0.55)]',
            'ctaHover' => 'hover:border-[#FFCE5A80] hover:bg-[#FFCE5A2b] hover:text-[#FFF7E8] hover:backdrop-blur-md hover:shadow-[0_16px_40px_-18px_rgba(255,206,90,0.65)]',
            'mediaRing' => 'ring-1 ring-[#FFCE5A1a]',
            'mediaGlow' => 'ring-[#FFCE5A40]',
        ],
    ];
    $statusKey = strtolower($status);
    $info = $statuses[$statusKey] ?? $statuses['encours'];
    $progressValue = max(0, min(100, (int) $progress));
    $descriptor = $statusKey === 'termine'
        ? sprintf('%d%% — Livré', $progressValue)
        : sprintf('%d%% — En cours de finalisation', $progressValue);
@endphp

<article @class([
    'card-spotlight group relative flex h-full flex-col overflow-hidden rounded-[20px] backdrop-blur-2xl shadow-[0_32px_60px_-28px_rgba(6,12,10,0.8)] glass-surface',
    $info['card'],
    $glow ? $info['glow'] : null,
    $class,
])>
    <header class="flex items-start justify-between gap-3 px-[var(--tile-pad-x)] pt-6">
        <div class="flex items-start gap-3">
            @if ($icon)
                <x-icon :name="$icon" :class="'text-2xl ' . $info['accent']" />
            @endif
            <h3 class="text-lg font-semibold leading-tight">{{ $title }}</h3>
        </div>
        <span class="inline-flex items-center rounded-full border px-3 py-1 text-[0.58rem] font-semibold uppercase tracking-[0.18em] backdrop-blur-md {{ $info['badge'] }}">
            {{ $info['label'] }}
        </span>
    </header>
    <p class="px-[var(--tile-pad-x)] pt-3 text-sm font-light leading-relaxed line-clamp-2 {{ $info['summary'] }}">
        {{ $summary }}
    </p>
    <div class="relative mt-5 px-[var(--tile-pad-x)]">
        <div class="relative w-full overflow-hidden rounded-[16px] transition duration-500 {{ $info['mediaRing'] }} {{ $glow ? $info['mediaGlow'] : '' }}">
            <div class="relative h-[165px] w-full md:h-[200px]">
                @if ($image)
                    <img src="{{ $image }}" alt="{{ $title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.04]" loading="lazy">
                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/60 via-black/25 to-transparent"></div>
                @endif
            </div>
        </div>
    </div>
    <div class="mt-6 flex flex-1 flex-col px-[var(--tile-pad-x)] pb-[var(--tile-pad-y)]">
        <div class="mb-2 flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.22em] {{ $info['metrics'] }}">
            <x-icon name="bar-chart-3" :class="'h-4 w-4 ' . $info['accent']" />
            <span>Progression</span>
        </div>
        <div class="mb-3 text-xs text-white/80">{{ $descriptor }}</div>
        <div class="h-2.5 w-full overflow-hidden rounded-full bg-white/10 ring-1 ring-black/20">
            <div class="progress-bar h-full rounded-full {{ $glow ? $info['progressGlow'] : $info['progress'] }}" style="width: {{ $progressValue }}%"></div>
        </div>
        @if ($href)
            <div class="mt-6 flex">
                <a href="{{ $href }}" class="inline-flex w-full items-center justify-center gap-2 rounded-full px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.24em] transition-all duration-300 {{ $info['ctaBase'] }} {{ $info['ctaHover'] }}">
                    Voir les détails
                </a>
            </div>
        @endif
    </div>
</article>
