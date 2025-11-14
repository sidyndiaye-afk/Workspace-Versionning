@php
    $prefix = "news[{$index}]";
@endphp
<div class="rounded-3xl border border-white/10 bg-white/5 p-4" data-repeater-item data-index="{{ $index }}">
    <div class="mb-3 flex items-center justify-between text-xs uppercase tracking-[0.2em] text-white/50">
        <span>News</span>
        <button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-white/15 bg-white/5 text-white/60 transition hover:border-red-400/60 hover:bg-red-500/20 hover:text-red-200" data-repeater-remove title="Supprimer">×</button>
    </div>
    <div class="grid gap-3 md:grid-cols-2">
        <div>
            <label class="text-[0.65rem] uppercase tracking-[0.2em] text-white/60">Titre *</label>
            <input type="text" name="{{ $prefix }}[title]" data-name-pattern="news[__INDEX__][title]" value="{{ $news['title'] ?? '' }}" required class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-sm text-white" />
        </div>
        <div>
            <label class="text-[0.65rem] uppercase tracking-[0.2em] text-white/60">Date *</label>
            <input type="text" name="{{ $prefix }}[date]" data-name-pattern="news[__INDEX__][date]" value="{{ $news['date'] ?? '' }}" required class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-sm text-white" />
        </div>
    </div>
    <div class="mt-3">
        <label class="text-[0.65rem] uppercase tracking-[0.2em] text-white/60">Description *</label>
        <textarea name="{{ $prefix }}[description]" data-name-pattern="news[__INDEX__][description]" rows="2" required class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-sm text-white">{{ $news['description'] ?? '' }}</textarea>
    </div>
    <div class="mt-3 grid gap-3 md:grid-cols-2">
        <div>
            <label class="text-[0.65rem] uppercase tracking-[0.2em] text-white/60">Image</label>
            <input type="text" name="{{ $prefix }}[image]" data-name-pattern="news[__INDEX__][image]" value="{{ $news['image'] ?? '' }}" class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-sm text-white" />
        </div>
        <div>
            <label class="text-[0.65rem] uppercase tracking-[0.2em] text-white/60">Ancre (ID section)</label>
            <input type="text" name="{{ $prefix }}[anchor]" data-name-pattern="news[__INDEX__][anchor]" value="{{ $news['anchor'] ?? '' }}" class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-sm text-white" />
        </div>
    </div>
</div>
