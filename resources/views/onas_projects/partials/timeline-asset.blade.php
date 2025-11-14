@php
    $prefix = "timeline[{$parentIndex}][assets][{$index}]";
    $types = [
        'link' => 'Lien',
        'file' => 'Fichier',
        'image' => 'Image',
        'video' => 'Vidéo',
        'pdf' => 'PDF',
        'psd' => 'PSD',
        'source' => 'Source',
    ];
@endphp
<div class="rounded-2xl border border-white/10 bg-white/5 p-3" data-repeater-item data-index="{{ $index }}">
    <div class="mb-2 flex items-center justify-between text-[0.6rem] uppercase tracking-[0.2em] text-white/50">
        <span>Pièce jointe</span>
        <button type="button" class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-white/15 bg-white/5 text-white/60 transition hover:border-red-400/60 hover:bg-red-500/20 hover:text-red-200" data-repeater-remove title="Supprimer">×</button>
    </div>
    <div class="grid gap-2 md:grid-cols-2">
        <div>
            <label class="text-[0.6rem] uppercase tracking-[0.2em] text-white/60">Label</label>
            <input type="text" name="{{ $prefix }}[label]" data-name-pattern="timeline[__PARENT_INDEX__][assets][__ASSET_INDEX__][label]" value="{{ $asset['label'] ?? '' }}" class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-xs text-white" />
        </div>
        <div>
            <label class="text-[0.6rem] uppercase tracking-[0.2em] text-white/60">Type</label>
            <select name="{{ $prefix }}[type]" data-name-pattern="timeline[__PARENT_INDEX__][assets][__ASSET_INDEX__][type]" class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-xs text-white">
                <option value="">—</option>
                @foreach ($types as $value => $label)
                    <option value="{{ $value }}" @selected(($asset['type'] ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mt-2">
        <label class="text-[0.6rem] uppercase tracking-[0.2em] text-white/60">Lien</label>
        <input type="text" name="{{ $prefix }}[href]" data-name-pattern="timeline[__PARENT_INDEX__][assets][__ASSET_INDEX__][href]" value="{{ $asset['href'] ?? '' }}" class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-xs text-white" />
    </div>
    <div class="mt-2">
        <label class="text-[0.6rem] uppercase tracking-[0.2em] text-white/60">Uploader un fichier</label>
        <input type="file" name="{{ $prefix }}[upload]" data-name-pattern="timeline[__PARENT_INDEX__][assets][__ASSET_INDEX__][upload]" class="w-full rounded-2xl border border-white/10 bg-white/10 px-3 py-2 text-xs text-white" />
        <p class="mt-1 text-[0.6rem] text-white/40">Si un fichier est téléversé, il sera utilisé à la place du lien.</p>
    </div>
</div>
