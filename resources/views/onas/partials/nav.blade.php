@props([
    'navItems' => [],
    'activeHref' => null,
])
<div class="pointer-events-none fixed left-0 right-0 top-0 z-50 flex justify-center px-4 pt-6">
    <div class="pointer-events-auto w-full max-w-6xl rounded-2xl border border-[rgba(176,202,28,0.35)] bg-black/40 px-5 py-4 shadow-[0_28px_80px_-35px_rgba(9,20,12,0.9)] backdrop-blur-2xl">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <a href="{{ route('onas.dashboard') }}" class="flex items-center gap-3">
                <div class="relative h-12 w-12 overflow-hidden rounded-xl border border-[rgba(176,202,28,0.4)] bg-white/10 shadow-[0_6px_18px_-10px_rgba(176,202,28,0.6)]">
                    <img src="/media/levell-logo.png" alt="Levell" class="object-contain" loading="lazy">
                </div>
                <div class="flex flex-col leading-tight">
                    <span class="text-[0.7rem] font-semibold uppercase tracking-[0.38em] text-[#B0CA1C]">Dashboard ONAS</span>
                    <span class="text-[0.7rem] font-medium text-[#E9F4E2]/70">Suivi des projets</span>
                </div>
            </a>
            <nav aria-label="Navigation ONAS" class="flex flex-wrap gap-2 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/70">
                @foreach ($navItems as $item)
                    @php
                        $hasChildren = !empty($item['children']);
                        $childCollection = collect($item['children'] ?? []);
                        $childIsActive = $childCollection->contains(fn ($child) => $child['active'] ?? false);
                        $isActive = $childIsActive || ($activeHref === $item['href']);
                        $baseClasses = 'inline-flex items-center gap-1.5 rounded-xl border border-transparent px-4 py-2 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#B0CA1C]';
                        $stateClasses = $isActive ? 'text-[#B0CA1C]' : 'text-white/70 hover:text-[#B0CA1C]';
                    @endphp
                    <div class="group nav-group relative" data-nav-item>
                        @if ($hasChildren)
                            <button type="button" class="{{ $baseClasses }} {{ $stateClasses }}" data-nav-trigger aria-expanded="false" aria-haspopup="true">
                                <span>{{ $item['label'] }}</span>
                                <x-icon name="chevron-down" class="h-4 w-4 transition-transform duration-200" data-nav-chevron />
                            </button>
                        @else
                            <a href="{{ $item['href'] }}" class="{{ $baseClasses }} {{ $stateClasses }}">
                                {{ $item['label'] }}
                            </a>
                        @endif

                        @if ($hasChildren)
                            <div
                                class="nav-dropdown absolute left-1/2 top-full z-40 mt-3 w-60 -translate-x-1/2 rounded-2xl border border-[rgba(176,202,28,0.35)] bg-black/60 p-3 shadow-[0_28px_55px_-25px_rgba(8,18,11,0.9)] backdrop-blur-xl"
                                data-nav-dropdown
                            >
                                <ul class="flex flex-col gap-1.5 text-[0.65rem] uppercase tracking-[0.2em]">
                                    <li>
                                        <a href="{{ $item['href'] }}" class="flex w-full items-center justify-between rounded-xl px-3 py-2 text-sm font-medium transition {{ $isActive && !$childIsActive ? 'bg-[#B0CA1C1A] text-[#B0CA1C] ring-1 ring-[#B0CA1C66]' : 'text-white/75 hover:bg-white/10 hover:text-[#B0CA1C]' }}">
                                            {{ $item['label'] }}
                                        </a>
                                    </li>
                                    @foreach ($childCollection as $child)
                                        <li>
                                            <a href="{{ $child['href'] }}" class="flex w-full items-center justify-between rounded-xl px-3 py-2 text-sm font-medium transition {{ ($child['active'] ?? false) ? 'bg-[#B0CA1C1A] text-[#B0CA1C] ring-1 ring-[#B0CA1C66]' : 'text-white/75 hover:bg-white/10 hover:text-[#B0CA1C]' }}">
                                                {{ $child['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endforeach
            </nav>
        </div>
    </div>
</div>
