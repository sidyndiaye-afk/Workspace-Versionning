<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'status',
        'start_date',
        'end_date',
        'cover_image',
        'objectif',
        'intro',
        'youtube_id',
        'files_note',
        'contact',
        'news',
        'timeline',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'contact' => 'array',
        'news' => 'array',
        'timeline' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $project): void {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
