@php
    $prefix = "timeline[{$index}]";
    $statuses = ['completed' => 'Livré', 'in-progress' => 'En cours', 'on-hold' => 'En attente', 'future' => 'À venir'];
    $assetRepeater = "timeline-assets-{$index}";
    $assets = $step['assets'] ?? [];
@endphp
<div class="rounded-3xl border border-white/10 bg-white/5 p-4" data-repeater-item data-index="{{ $index }}">
    <div class="mb-3 flex items-center justify-between text-xs uppercase tracking-[0.2em] text-white/50">
        <span>Jalon</span>
        <button type="button" class="text-red-300 hover:text-red-200" data-repeater-remove title="Supprimer">×</button>
    </div>
    <div class="grid gap-3 md:grid-cols-2">
        <div>
            <label class="text-[0.65rem] uppercase tracking-[0.2em] text-white/60">Titre *</label>
            <input type="text" name="{{ $prefix }}[title]" data-name-pattern="timeline[__INDEX__][title]" value="{{ $step['title'] ?? '' }}" required class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-sm text-white" />
        </div>
        <div>
            <label class="text-[0.65rem] uppercase tracking-[0.2em] text-white/60">Date *</label>
            <input type="text" name="{{ $prefix }}[date]" data-name-pattern="timeline[__INDEX__][date]" value="{{ $step['date'] ?? '' }}" required class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-sm text-white" />
        </div>
    </div>
    <div class="mt-3 grid gap-3 md:grid-cols-2">
        <div>
            <label class="text-[0.65rem] uppercase tracking-[0.2em] text-white/60">Statut *</label>
            <select name="{{ $prefix }}[status]" data-name-pattern="timeline[__INDEX__][status]" required class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-sm text-white">
                <option value="">—</option>
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(($step['status'] ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mt-3">
        <label class="text-[0.65rem] uppercase tracking-[0.2em] text-white/60">Description *</label>
        <textarea name="{{ $prefix }}[description]" data-name-pattern="timeline[__INDEX__][description]" rows="2" required class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-sm text-white">{{ $step['description'] ?? '' }}</textarea>
    </div>
    <div class="mt-3">
        <label class="text-[0.65rem] uppercase tracking-[0.2em] text-white/60">Narration</label>
        <textarea name="{{ $prefix }}[narrativeBefore]" data-name-pattern="timeline[__INDEX__][narrativeBefore]" rows="2" class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-sm text-white">{{ $step['narrativeBefore'] ?? '' }}</textarea>
    </div>

    <div class="mt-4 space-y-3" data-repeater-wrapper="{{ $assetRepeater }}">
        <div class="flex items-center justify-between text-xs uppercase tracking-[0.2em] text-white/60">
            <span>Pièces jointes</span>
            <button type="button" class="rounded-full border border-white/20 px-3 py-1 text-[0.6rem] uppercase tracking-[0.2em] text-white transition hover:border-white/40 hover:bg-white/10" data-repeater-add="{{ $assetRepeater }}">Ajouter</button>
        </div>
        <div class="space-y-2" data-repeater="{{ $assetRepeater }}" data-parent-index="{{ $index }}" data-repeater-next-index="{{ count($assets) }}">
            @forelse ($assets as $assetIndex => $asset)
                @include('onas_projects.partials.timeline-asset', ['parentIndex' => $index, 'index' => $assetIndex, 'asset' => $asset])
            @empty
                <p class="text-xs text-white/40" data-repeater-empty>Pas de pièce jointe.</p>
            @endforelse
            <template data-repeater-template="{{ $assetRepeater }}">
                @include('onas_projects.partials.timeline-asset', ['parentIndex' => '__PARENT_INDEX__', 'index' => '__ASSET_INDEX__', 'asset' => []])
            </template>
        </div>
    </div>
</div>
