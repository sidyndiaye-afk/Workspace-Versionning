<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class OnasProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'start_label',
        'end_label',
        'due_label',
        'progress',
        'cover_image',
        'cover_image_mobile',
        'objective',
        'timeline_intro',
        'contact',
        'news',
        'timeline',
        'contact_user_id',
    ];

    protected $casts = [
        'timeline_intro' => 'array',
        'contact' => 'array',
        'news' => 'array',
        'timeline' => 'array',
    ];

    public function contactUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contact_user_id');
    }

    protected static function booted(): void
    {
        static::saving(function (self $project): void {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->name);
            }
        });
    }
}
