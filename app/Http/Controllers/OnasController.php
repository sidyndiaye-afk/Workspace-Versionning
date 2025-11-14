<?php

namespace App\Http\Controllers;

use App\Models\OnasProject;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OnasController extends Controller
{
    public function dashboard(): View
    {
        $projects = OnasProject::query()
            ->orderBy('name')
            ->get()
            ->map(function (OnasProject $project): array {
                return [
                    'id' => $project->id,
                    'slug' => $project->slug,
                    'name' => $project->name,
                    'status' => Str::upper($project->status ?? ''),
                    'progress' => (int) ($project->progress ?? 0),
                    'start' => $project->start_label,
                    'end' => $project->end_label,
                    'due' => $project->due_label,
                    'thumbnail' => $project->cover_image,
                    'cover_image' => $project->cover_image,
                    'cover_image_mobile' => $project->cover_image_mobile,
                    'objective' => $project->objective,
                    'timeline_intro' => $project->timeline_intro ?? [],
                    'contact' => $project->contact ?? [],
                    'news' => $project->news ?? [],
                    'timeline' => $project->timeline ?? [],
                ];
            });

        $projectMap = $projects->keyBy('name');
        $projectMapBySlug = $projects->keyBy('slug');
        $navItems = $this->buildNavItems();

        $completed = $projects->where('status', 'TERMINÉ')->values();
        $ongoing = $projects->where('status', 'EN COURS')->values();
        $averageProgress = (int) round($ongoing->avg('progress'));

        $heroTiles = $this->buildTiles(config('onas.hero_tiles', []), $projectMap, $projectMapBySlug);
        $gamouFocus = $this->buildTiles(config('onas.gamou_focus', []), $projectMap, $projectMapBySlug);
        $creaHighlights = $this->buildTiles(config('onas.crea_highlights', []), $projectMap, $projectMapBySlug);
        $kpiCards = $this->buildKpiCards($completed, $ongoing, $averageProgress);

        return view('onas.dashboard', [
            'title' => 'Dashboard ONAS',
            'navItems' => $navItems,
            'heroTiles' => $heroTiles,
            'gamouFocus' => $gamouFocus,
            'creaHighlights' => $creaHighlights,
            'kpiCards' => $kpiCards,
            'stats' => [
                'completed' => $completed->count(),
                'ongoing' => $ongoing->count(),
                'average' => $averageProgress,
            ],
            'activeHref' => route('onas.dashboard'),
        ]);
    }

    public function project(string $slug): View
    {
        $model = OnasProject::where('slug', $slug)->firstOrFail();

        $contactUser = $model->contactUser;

        $project = [
            'name' => $model->name,
            'status' => Str::upper($model->status ?? ''),
            'start' => $model->start_label,
            'end' => $model->end_label,
            'due' => $model->due_label,
            'progress' => $model->progress,
            'cover_image' => $model->cover_image,
            'cover_image_mobile' => $model->cover_image_mobile,
            'objective' => $model->objective,
            'timeline_intro' => $model->timeline_intro ?? [],
            'contact' => $model->contact ?? [],
            'news' => $model->news ?? [],
            'timeline' => $model->timeline ?? [],
        ];

        if ($contactUser) {
            $contact = array_filter([
                'name' => $contactUser->name,
                'role' => $contactUser->role,
                'email' => $contactUser->email,
                'phone' => $contactUser->phone,
                'avatarUrl' => $contactUser->avatar_url,
            ]);
            $project['contact'] = array_filter(array_merge($contact, $project['contact'] ?? []));
        }

        $timeline = collect($project['timeline']);
        $completedSteps = $timeline->where('status', 'completed')->count();
        $totalSteps = $timeline->count();
        $calculatedProgress = $totalSteps > 0 ? (int) round(($completedSteps / $totalSteps) * 100) : 0;

        $timelineStyles = $this->buildTimelineGradients($timeline);

        return view('onas.project', [
            'title' => $project['name'],
            'project' => $project,
            'slug' => $slug,
            'timeline' => $timeline,
            'news' => collect($project['news'] ?? []),
            'navItems' => $this->buildNavItems($slug),
            'activeHref' => route('onas.projects.show', $slug),
            'stats' => [
                'completed' => $completedSteps,
                'total' => $totalSteps,
                'progress' => $calculatedProgress,
            ],
            'timelineStyles' => $timelineStyles,
        ]);
    }

    private function buildNavItems(?string $activeSlug = null): array
    {
        $config = collect(config('onas.nav', []));
        $current = url()->current();

        return $config->map(function (array $item) use ($current, $activeSlug): array {
            $href = $item['slug'] ? route($item['target'], $item['slug']) : route('onas.dashboard');
            $children = collect($item['children'] ?? [])->map(fn (string $childSlug) => [
                'label' => Str::headline(str_replace('-', ' ', $childSlug)),
                'href' => route('onas.projects.show', $childSlug),
                'active' => false,
            ])->map(function (array $child) use ($current, $activeSlug): array {
                $child['active'] = $current === $child['href'] || $activeSlug === Str::afterLast($child['href'], '/');
                return $child;
            })->all();

            return [
                'label' => $item['label'],
                'href' => $href,
                'children' => $children,
            ];
        })->all();
    }

    private function buildTiles(array $tiles, Collection $projectMapByName, Collection $projectMapBySlug): array
    {
        return collect($tiles)->map(function (array $tile) use ($projectMapByName, $projectMapBySlug): array {
            $project = $projectMapBySlug->get($tile['slug'] ?? '') ?? $projectMapByName->get($tile['title'] ?? '');
            $progress = $project['progress'] ?? ($tile['progress'] ?? 0);
            $image = $project['thumbnail'] ?? ($tile['image'] ?? null);

            return [
                'id' => $tile['id'] ?? Str::uuid()->toString(),
                'title' => $tile['title'] ?? ($project['name'] ?? 'Projet'),
                'status' => $tile['status'] ?? 'encours',
                'summary' => $tile['summary'] ?? '',
                'progress' => $progress,
                'image' => $image,
                'href' => $this->projectUrl($tile['slug'] ?? ($project['slug'] ?? null), $tile['hash'] ?? null),
                'icon' => $tile['icon'] ?? null,
                'glow' => (bool) Arr::get($tile, 'glow', false),
            ];
        })->all();
    }

    private function buildKpiCards(Collection $completed, Collection $ongoing, int $average): array
    {
        $projectIcons = config('onas.project_icons', []);

        $buildEntry = function (array $project, string $barClass) use ($projectIcons) {
            $detail = trim(($project['start'] ?? '') . (isset($project['end']) ? ' → ' . $project['end'] : (isset($project['due']) ? ' – Échéance ' . $project['due'] : '')));

            return [
                'title' => $project['name'],
                'detail' => $detail,
                'progress' => $project['progress'] ?? 0,
                'icon' => $projectIcons[$project['name']] ?? 'sparkles',
                'barClass' => $barClass,
            ];
        };

        return [
            [
                'id' => 'kpi-completed',
                'type' => 'list',
                'icon' => 'trophy',
                'label' => 'Projets terminés',
                'tileClass' => 'bg-gradient-to-br from-[#1B2D17]/95 via-[#132012]/96 to-[#0D150F]/98',
                'iconClass' => 'bg-[#233315]/80 text-[#B0CA1C]',
                'entryIconClass' => 'border border-[#B0CA1C33] bg-[#1A2614] text-[#B0CA1C]',
                'labelClass' => 'text-[#B0CA1C]',
                'entries' => $completed->take(3)->map(fn ($project) => $buildEntry($project, 'bg-gradient-to-r from-[#B0CA1C] via-[#9FC11A] to-[#6A9420]'))->all(),
                'empty' => 'Aucune livraison validée',
            ],
            [
                'id' => 'kpi-ongoing',
                'type' => 'list',
                'icon' => 'activity',
                'label' => 'Projets en cours',
                'tileClass' => 'bg-gradient-to-br from-[#142726]/95 via-[#0F1F1D]/96 to-[#0A1513]/98',
                'iconClass' => 'bg-[#123532]/75 text-[#72D8D2]',
                'entryIconClass' => 'border border-[#72D8D233] bg-[#0F2424] text-[#72D8D2]',
                'labelClass' => 'text-[#72D8D2]',
                'entries' => $ongoing->take(3)->map(fn ($project) => $buildEntry($project, 'bg-gradient-to-r from-[#72D8D2] via-[#58BFC0] to-[#2A8C8A]'))->all(),
                'empty' => 'Aucun chantier actif',
            ],
            [
                'id' => 'kpi-progress',
                'type' => 'progress',
                'icon' => 'gauge-circle',
                'label' => 'Avancement global',
                'tileClass' => 'bg-gradient-to-br from-[#1D2C2F]/95 via-[#152125]/96 to-[#0F181C]/98',
                'iconClass' => 'bg-[#1C3035]/75 text-[#78CFE0]',
                'entryIconClass' => '',
                'labelClass' => 'text-[#72D8D2]',
                'entries' => [],
                'empty' => '',
                'value' => $average,
            ],
        ];
    }

    private function projectUrl(?string $slug, ?string $hash = null): string
    {
        if (blank($slug)) {
            return route('onas.dashboard');
        }

        $url = route('onas.projects.show', $slug);

        return $hash ? $url . '#' . $hash : $url;
    }

    private function buildTimelineGradients(Collection $timeline): array
    {
        if ($timeline->isEmpty()) {
            return [
                'statusGradient' => 'rgba(45,62,45,0.45)',
                'completedGradient' => 'rgba(185,249,119,0.8)',
                'completedHeight' => 0,
            ];
        }

        $segment = 100 / max($timeline->count(), 1);
        $statusColors = [
            'completed' => '#B9F977',
            'in-progress' => '#72D8D2',
            'on-hold' => '#72D8D2',
            'future' => 'rgba(114,216,210,0.35)',
        ];

        $parts = [];
        $completedParts = [];
        $lastCompleted = $timeline->keys()->filter(fn ($index) => ($timeline[$index]['status'] ?? null) === 'completed')->last();

        foreach ($timeline as $index => $step) {
            $start = $index * $segment;
            $end = ($index + 1) * $segment;
            $color = $statusColors[$step['status'] ?? 'future'] ?? $statusColors['future'];
            $parts[] = sprintf('%s %.2f%% , %s %.2f%%', $color, $start, $color, $end);

            $completedParts[] = sprintf('%s %.2f%% , %s %.2f%%',
                $index <= $lastCompleted ? '#B9F977' : 'transparent',
                $start,
                $index <= $lastCompleted ? '#B9F977' : 'transparent',
                $end
            );
        }

        $completedCount = $timeline->where('status', 'completed')->count();
        $completedHeight = $timeline->count() ? ($completedCount / $timeline->count()) * 100 : 0;

        return [
            'statusGradient' => 'linear-gradient(to bottom, ' . implode(', ', $parts) . ')',
            'completedGradient' => 'linear-gradient(to bottom, ' . implode(', ', $completedParts) . ')',
            'completedHeight' => $completedHeight,
        ];
    }
}
