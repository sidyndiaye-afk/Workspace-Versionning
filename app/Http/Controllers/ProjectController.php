<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function publicIndex(): View
    {
        $projects = Project::orderByDesc('start_date')
            ->orderByDesc('created_at')
            ->get();

        return view('projects.public-index', compact('projects'));
    }

    public function publicShow(Project $project): View
    {
        return view('projects.show', compact('project'));
    }

    public function index(): View
    {
        $projects = Project::orderByDesc('created_at')->paginate(15);

        return view('projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('projects.create', [
            'project' => new Project(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $project = Project::create($this->validatePayload($request));

        return redirect()
            ->route('admin.projects.edit', $project)
            ->with('status', 'Projet créé.');
    }

    public function edit(Project $project): View
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $project->update($this->validatePayload($request, $project));

        return redirect()
            ->route('admin.projects.edit', $project)
            ->with('status', 'Projet mis à jour.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('status', 'Projet supprimé.');
    }

    private function validatePayload(Request $request, ?Project $project = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects', 'slug')->ignore($project),
            ],
            'status' => ['required', 'string', 'max:50'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'objectif' => ['nullable', 'string'],
            'intro' => ['nullable', 'string'],
            'youtube_id' => ['nullable', 'string', 'max:100'],
            'files_note' => ['nullable', 'string'],
            'contact_json' => ['nullable', 'string'],
            'news_json' => ['nullable', 'string'],
            'timeline_json' => ['nullable', 'string'],
        ]);

        return [
            'title' => $data['title'],
            'slug' => $data['slug'],
            'status' => strtoupper(str_replace(' ', '_', $data['status'])),
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'cover_image' => $data['cover_image'] ?? null,
            'objectif' => $data['objectif'] ?? null,
            'intro' => $data['intro'] ?? null,
            'youtube_id' => $data['youtube_id'] ?? null,
            'files_note' => $data['files_note'] ?? null,
            'contact' => $this->decodeJsonField($data['contact_json'] ?? null),
            'news' => $this->decodeJsonField($data['news_json'] ?? null),
            'timeline' => $this->decodeJsonField($data['timeline_json'] ?? null) ?? [],
        ];
    }

    private function decodeJsonField(?string $value): ?array
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : null;
    }
}
