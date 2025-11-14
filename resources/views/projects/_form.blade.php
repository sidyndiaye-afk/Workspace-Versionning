@php
    $contactJson = old('contact_json', $project->contact ? json_encode($project->contact, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '');
    $newsJson = old('news_json', $project->news ? json_encode($project->news, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '');
    $timelineJson = old('timeline_json', $project->timeline ? json_encode($project->timeline, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '');
@endphp

@csrf

<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label class="block text-xs uppercase tracking-[0.3em] text-white/60">Titre</label>
        <input type="text" name="title" value="{{ old('title', $project->title) }}" required
               class="mt-2 w-full rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none">
        @error('title') <p class="text-xs text-rose-300 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-xs uppercase tracking-[0.3em] text-white/60">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $project->slug) }}" required
               class="mt-2 w-full rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none">
        @error('slug') <p class="text-xs text-rose-300 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid gap-6 md:grid-cols-3 mt-6">
    <div>
        <label class="block text-xs uppercase tracking-[0.3em] text-white/60">Statut</label>
        <input type="text" name="status" value="{{ old('status', $project->status ?? 'DRAFT') }}" required
               class="mt-2 w-full rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none">
        @error('status') <p class="text-xs text-rose-300 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-xs uppercase tracking-[0.3em] text-white/60">Date début</label>
        <input type="date" name="start_date" value="{{ old('start_date', optional($project->start_date)->format('Y-m-d')) }}"
               class="mt-2 w-full rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none">
        @error('start_date') <p class="text-xs text-rose-300 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-xs uppercase tracking-[0.3em] text-white/60">Date fin</label>
        <input type="date" name="end_date" value="{{ old('end_date', optional($project->end_date)->format('Y-m-d')) }}"
               class="mt-2 w-full rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none">
        @error('end_date') <p class="text-xs text-rose-300 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6">
    <label class="block text-xs uppercase tracking-[0.3em] text-white/60">Image de couverture</label>
    <input type="text" name="cover_image" value="{{ old('cover_image', $project->cover_image) }}"
           class="mt-2 w-full rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none">
    @error('cover_image') <p class="text-xs text-rose-300 mt-1">{{ $message }}</p> @enderror
</div>

<div class="mt-6">
    <label class="block text-xs uppercase tracking-[0.3em] text-white/60">Objectif</label>
    <textarea name="objectif" rows="3"
              class="mt-2 w-full rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none">{{ old('objectif', $project->objectif) }}</textarea>
    @error('objectif') <p class="text-xs text-rose-300 mt-1">{{ $message }}</p> @enderror
</div>

<div class="mt-6">
    <label class="block text-xs uppercase tracking-[0.3em] text-white/60">Introduction</label>
    <textarea name="intro" rows="4"
              class="mt-2 w-full rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none">{{ old('intro', $project->intro) }}</textarea>
    @error('intro') <p class="text-xs text-rose-300 mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid gap-6 md:grid-cols-3 mt-6">
    <div>
        <label class="block text-xs uppercase tracking-[0.3em] text-white/60">YouTube ID</label>
        <input type="text" name="youtube_id" value="{{ old('youtube_id', $project->youtube_id) }}"
               class="mt-2 w-full rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none">
    </div>
    <div class="md:col-span-2">
        <label class="block text-xs uppercase tracking-[0.3em] text-white/60">Note fichiers</label>
        <input type="text" name="files_note" value="{{ old('files_note', $project->files_note) }}"
               class="mt-2 w-full rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none">
    </div>
</div>

<div class="mt-8 grid gap-6 md:grid-cols-3">
    <div class="md:col-span-1">
        <label class="block text-xs uppercase tracking-[0.3em] text-white/60">Contact (JSON)</label>
        <textarea name="contact_json" rows="10"
                  class="mt-2 w-full rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-xs font-mono focus:border-emerald-400 focus:outline-none"
                  placeholder='{"name":"..."}'>{{ $contactJson }}</textarea>
        @error('contact_json') <p class="text-xs text-rose-300 mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-1">
        <label class="block text-xs uppercase tracking-[0.3em] text-white/60">News (JSON)</label>
        <textarea name="news_json" rows="10"
                  class="mt-2 w-full rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-xs font-mono focus:border-emerald-400 focus:outline-none"
                  placeholder='[{"title":"..."}]'>{{ $newsJson }}</textarea>
        @error('news_json') <p class="text-xs text-rose-300 mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-1">
        <label class="block text-xs uppercase tracking-[0.3em] text-white/60">Timeline (JSON)</label>
        <textarea name="timeline_json" rows="10"
                  class="mt-2 w-full rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-xs font-mono focus:border-emerald-400 focus:outline-none"
                  placeholder='[{"title":"", "description":""}]'>{{ $timelineJson }}</textarea>
        @error('timeline_json') <p class="text-xs text-rose-300 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-8">
    <button type="submit"
            class="inline-flex items-center gap-2 rounded-xl bg-emerald-500/90 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-white hover:bg-emerald-400">
        Sauvegarder
    </button>
</div>
