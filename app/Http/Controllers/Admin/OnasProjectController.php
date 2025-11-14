<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnasProject;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OnasProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projects = OnasProject::with('contactUser')->orderByDesc('created_at')->paginate(20);

        return view('onas_projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('onas_projects.create', [
            'project' => new OnasProject(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $project = OnasProject::create($this->validatePayload($request));

        return redirect()
            ->route('admin.onas-projects.edit', $project)
            ->with('status', 'Projet ONAS créé.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OnasProject $onasProject): View
    {
        return view('onas_projects.edit', [
            'project' => $onasProject,
            'users' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OnasProject $onasProject): RedirectResponse
    {
        $onasProject->update($this->validatePayload($request, $onasProject));

        return redirect()
            ->route('admin.onas-projects.edit', $onasProject)
            ->with('status', 'Projet ONAS mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OnasProject $onasProject): RedirectResponse
    {
        $onasProject->delete();

        return redirect()
            ->route('admin.onas-projects.index')
            ->with('status', 'Projet ONAS supprimé.');
    }

    private function validatePayload(Request $request, ?OnasProject $project = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('onas_projects', 'slug')->ignore($project)],
            'status' => ['required', 'string', 'max:50'],
            'start_label' => ['nullable', 'string', 'max:255'],
            'end_label' => ['nullable', 'string', 'max:255'],
            'due_label' => ['nullable', 'string', 'max:255'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'cover_image_mobile' => ['nullable', 'string', 'max:255'],
            'objective' => ['nullable', 'string'],
            'timeline_intro_text' => ['nullable', 'string'],
            'contact_user_id' => ['nullable', Rule::exists('users', 'id')],
            'news' => ['nullable', 'array'],
            'news.*.title' => ['nullable', 'string', 'max:255'],
            'news.*.date' => ['nullable', 'string', 'max:255'],
            'news.*.description' => ['nullable', 'string'],
            'news.*.image' => ['nullable', 'string', 'max:255'],
            'news.*.anchor' => ['nullable', 'string', 'max:255'],
            'timeline' => ['nullable', 'array'],
            'timeline.*.title' => ['nullable', 'string', 'max:255'],
            'timeline.*.date' => ['nullable', 'string', 'max:255'],
            'timeline.*.status' => ['nullable', 'string', 'max:50'],
            'timeline.*.description' => ['nullable', 'string'],
            'timeline.*.narrativeBefore' => ['nullable', 'string'],
            'timeline.*.assets' => ['nullable', 'array'],
            'timeline.*.assets.*.label' => ['nullable', 'string', 'max:255'],
            'timeline.*.assets.*.type' => ['nullable', 'string', 'max:50'],
            'timeline.*.assets.*.href' => ['nullable', 'string', 'max:255'],
            'timeline.*.assets.*.upload' => ['nullable', 'file', 'max:12288'],
            'cover_image_upload' => ['nullable', 'image', 'max:3072'],
            'cover_image_mobile_upload' => ['nullable', 'image', 'max:3072'],
        ]);

        $payload = [
            'name' => $data['name'],
            'slug' => $data['slug'] ?: null,
            'status' => Str::upper($data['status']),
            'start_label' => $data['start_label'] ?? null,
            'end_label' => $data['end_label'] ?? null,
            'due_label' => $data['due_label'] ?? null,
            'progress' => $data['progress'] ?? 0,
            'cover_image' => $data['cover_image'] ?? null,
            'cover_image_mobile' => $data['cover_image_mobile'] ?? null,
            'objective' => $data['objective'] ?? null,
            'timeline_intro' => $this->parseLines($data['timeline_intro_text'] ?? ''),
            'contact_user_id' => $data['contact_user_id'] ?? null,
            'contact' => null,
            'news' => $this->sanitizeNews($data['news'] ?? []),
            'timeline' => $this->sanitizeTimeline($data['timeline'] ?? [], $request),
        ];

        foreach ([
            'cover_image_upload' => 'cover_image',
            'cover_image_mobile_upload' => 'cover_image_mobile',
        ] as $uploadField => $attribute) {
            if ($request->hasFile($uploadField)) {
                $path = $request->file($uploadField)->store('onas', 'public');
                $payload[$attribute] = Storage::url($path);
            }
        }

        return $payload;
    }

    private function parseLines(?string $value): ?array
    {
        if ($value === null) {
            return null;
        }

        $lines = collect(preg_split('/\r?\n\r?\n|\r?\n/', $value))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        return empty($lines) ? null : $lines;
    }

    private function sanitizeNews(array $news): array
    {
        return collect($news)
            ->map(function (array $item) {
                return array_filter([
                    'title' => $item['title'] ?? null,
                    'date' => $item['date'] ?? null,
                    'description' => $item['description'] ?? null,
                    'image' => $item['image'] ?? null,
                    'anchor' => $item['anchor'] ?? null,
                ], fn ($value) => $value !== null && $value !== '');
            })
            ->filter(fn ($item) => count($item) > 0)
            ->values()
            ->all();
    }

    private function sanitizeTimeline(array $timeline, Request $request): array
    {
        return collect($timeline)
            ->map(function (array $item, int $timelineIndex) use ($request) {
                return array_filter([
                    'title' => $item['title'] ?? null,
                    'date' => $item['date'] ?? null,
                    'status' => $item['status'] ?? null,
                    'description' => $item['description'] ?? null,
                    'narrativeBefore' => $item['narrativeBefore'] ?? null,
                    'assets' => $this->sanitizeAssets($item['assets'] ?? [], $request, $timelineIndex),
                ], fn ($value) => $value !== null && $value !== '');
            })
            ->filter(fn ($item) => count($item) > 0)
            ->values()
            ->all();
    }

    private function sanitizeAssets(array $assets, Request $request, int $timelineIndex): array
    {
        return collect($assets)
            ->map(function (array $asset, int $assetIndex) use ($request, $timelineIndex) {
                $file = $request->file("timeline.$timelineIndex.assets.$assetIndex.upload");
                $href = $asset['href'] ?? null;
                $type = $asset['type'] ?? null;

                if ($file) {
                    $stored = $file->store('onas/assets', 'public');
                    $href = Storage::url($stored);
                    $type = $type ?: 'file';
                }

                return array_filter([
                    'label' => $asset['label'] ?? null,
                    'type' => $type,
                    'href' => $href,
                ], fn ($value) => $value !== null && $value !== '');
            })
            ->filter(fn ($asset) => count($asset) > 0)
            ->values()
            ->all();
    }
}
