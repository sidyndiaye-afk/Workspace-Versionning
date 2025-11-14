@php
    $timelineIntro = old('timeline_intro_text', isset($project) && $project->timeline_intro ? implode("\n\n", $project->timeline_intro) : '');
    $contactUsers = $users ?? collect();
    $newsItems = old('news', $project->news ?? []);
    $timelineItems = old('timeline', $project->timeline ?? []);
@endphp

<div class="space-y-6">
    <div class="grid gap-4 md:grid-cols-2">
        @foreach ([
            ['label' => 'Nom', 'name' => 'name', 'required' => true, 'value' => old('name', $project->name)],
            ['label' => 'Slug', 'name' => 'slug', 'value' => old('slug', $project->slug), 'placeholder' => 'laisser vide pour auto'],
            ['label' => 'Statut', 'name' => 'status', 'value' => old('status', $project->status ?? 'EN COURS')],
            ['label' => 'Progression (%)', 'name' => 'progress', 'type' => 'number', 'value' => old('progress', $project->progress ?? 0)],
            ['label' => 'Début', 'name' => 'start_label', 'value' => old('start_label', $project->start_label)],
            ['label' => 'Fin', 'name' => 'end_label', 'value' => old('end_label', $project->end_label)],
            ['label' => 'Échéance', 'name' => 'due_label', 'value' => old('due_label', $project->due_label)],
        ] as $field)
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold uppercase tracking-[0.2em] text-white/70" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                <input
                    id="{{ $field['name'] }}"
                    name="{{ $field['name'] }}"
                    type="{{ $field['type'] ?? 'text' }}"
                    value="{{ $field['value'] }}"
                    @if(!empty($field['required'])) required @endif
                    placeholder="{{ $field['placeholder'] ?? '' }}"
                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-white"
                />
            </div>
        @endforeach
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        @foreach ([
            ['label' => 'Cover image', 'name' => 'cover_image', 'upload' => 'cover_image_upload', 'value' => old('cover_image', $project->cover_image)],
            ['label' => 'Cover image mobile', 'name' => 'cover_image_mobile', 'upload' => 'cover_image_mobile_upload', 'value' => old('cover_image_mobile', $project->cover_image_mobile)],
        ] as $fileField)
            <div class="space-y-2">
                <label class="text-sm font-semibold uppercase tracking-[0.2em] text-white/70">{{ $fileField['label'] }}</label>
                <div class="flex flex-col gap-3 rounded-3xl border border-dashed border-white/15 bg-white/5 p-4" data-dropzone>
                    <input type="hidden" name="{{ $fileField['name'] }}" value="{{ $fileField['value'] }}" data-dropzone-input>
                    <input type="file" accept="image/*" name="{{ $fileField['upload'] }}" class="hidden" data-dropzone-file>
                    @if ($fileField['value'])
                        <img src="{{ $fileField['value'] }}" alt="{{ $fileField['label'] }}" class="h-32 w-full rounded-2xl object-cover" data-dropzone-preview>
                    @else
                        <div class="flex h-32 items-center justify-center rounded-2xl border border-white/10 bg-black/20 text-xs uppercase tracking-[0.2em] text-white/50" data-dropzone-placeholder>
                            Glisser-déposer ou cliquer pour choisir
                        </div>
                    @endif
                    <button type="button" class="rounded-full border border-white/20 px-4 py-1 text-xs uppercase tracking-[0.2em] text-white" data-dropzone-button>
                        Choisir un fichier
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold uppercase tracking-[0.2em] text-white/70" for="objective">Objectif</label>
        <textarea id="objective" name="objective" rows="4" class="w-full rounded-2xl border border-white/10 bg-white/5 p-4 text-sm text-white">{{ old('objective', $project->objective) }}</textarea>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold uppercase tracking-[0.2em] text-white/70" for="timeline_intro_text">Timeline intro (paragraphe par ligne)</label>
        <textarea id="timeline_intro_text" name="timeline_intro_text" rows="4" class="w-full rounded-2xl border border-white/10 bg-white/5 p-4 text-sm text-white">{{ $timelineIntro }}</textarea>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold uppercase tracking-[0.2em] text-white/70" for="contact_user_id">Contact (utilisateur)</label>
            <select id="contact_user_id" name="contact_user_id" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-white">
                <option value="">— Sélectionner un utilisateur —</option>
                @foreach ($contactUsers as $user)
                    <option value="{{ $user->id }}" @selected(old('contact_user_id', $project->contact_user_id) == $user->id)>
                        {{ $user->name }} — {{ $user->email }}
                    </option>
                @endforeach
            </select>
            <p class="mt-2 text-xs text-white/50">La fiche projet affichera automatiquement les informations (nom, rôle, email, téléphone, avatar) de l’utilisateur choisi.</p>
        </div>
    </div>

    <div class="space-y-4" data-repeater-wrapper="news">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-sm font-semibold uppercase tracking-[0.2em] text-white/70">Actualités</h2>
                <p class="text-xs text-white/50">Ajoutez les cartes news affichées sur la fiche projet.</p>
            </div>
            <button type="button" class="rounded-full border border-white/20 px-4 py-1 text-xs uppercase tracking-[0.2em] text-white transition hover:border-white/40 hover:bg-white/10" data-repeater-add="news">Ajouter</button>
        </div>
        <div class="space-y-3" data-repeater="news" data-repeater-next-index="{{ count($newsItems) }}">
            @forelse ($newsItems as $index => $news)
                @include('onas_projects.partials.news-item', ['index' => $index, 'news' => $news])
            @empty
                <p class="text-xs text-white/40" data-repeater-empty>Pas encore de news.</p>
            @endforelse
            <template data-repeater-template="news">
                @include('onas_projects.partials.news-item', ['index' => '__INDEX__', 'news' => []])
            </template>
        </div>
    </div>

    <div class="space-y-4" data-repeater-wrapper="timeline">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-sm font-semibold uppercase tracking-[0.2em] text-white/70">Timeline</h2>
                <p class="text-xs text-white/50">Ajoutez les jalons du projet (date, statut, description...).</p>
            </div>
            <button type="button" class="rounded-full border border-white/20 px-4 py-1 text-xs uppercase tracking-[0.2em] text-white transition hover:border-white/40 hover:bg-white/10" data-repeater-add="timeline">Ajouter</button>
        </div>
        <div class="space-y-3" data-repeater="timeline" data-repeater-next-index="{{ count($timelineItems) }}">
            @forelse ($timelineItems as $index => $step)
                @include('onas_projects.partials.timeline-item', ['index' => $index, 'step' => $step])
            @empty
                <p class="text-xs text-white/40" data-repeater-empty>Pas encore de jalon.</p>
            @endforelse
            <template data-repeater-template="timeline">
                @include('onas_projects.partials.timeline-item', ['index' => '__INDEX__', 'step' => []])
            </template>
        </div>
    </div>

    <p class="text-xs text-white/50">
        Astuce&nbsp;: vous pouvez enrichir les actualités et jalons en ajoutant autant de blocs que nécessaire.
    </p>
</div>
