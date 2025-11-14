<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OnasProject;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OnasProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = config('onas-projects', []);

        foreach ($projects as $slug => $payload) {
            $contactData = $payload['contact'] ?? [];
            $contactUserId = null;

            if (!empty($contactData['email'])) {
                $user = User::firstOrNew(['email' => $contactData['email']]);
                $user->name = $contactData['name'] ?? ($user->name ?? Str::headline(str_replace('-', ' ', $slug)));
                $user->role = $contactData['role'] ?? $user->role;
                $user->phone = $contactData['phone'] ?? $user->phone;
                $user->avatar_url = $contactData['avatarUrl'] ?? $user->avatar_url;
                $user->is_admin = true;
                if (!$user->exists) {
                    $user->password = Hash::make('password');
                }
                $user->save();
                $contactUserId = $user->id;
            }

            OnasProject::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $payload['name'] ?? Str::headline(str_replace('-', ' ', $slug)),
                    'status' => $payload['status'] ?? 'EN COURS',
                    'start_label' => $payload['start'] ?? null,
                    'end_label' => $payload['end'] ?? null,
                    'due_label' => $payload['due'] ?? null,
                    'progress' => $payload['progress'] ?? 0,
                    'cover_image' => $payload['cover_image'] ?? null,
                    'cover_image_mobile' => $payload['cover_image_mobile'] ?? null,
                    'objective' => $payload['objective'] ?? null,
                    'timeline_intro' => $payload['timeline_intro'] ?? [],
                    'contact_user_id' => $contactUserId,
                    'contact' => $payload['contact'] ?? [],
                    'news' => $payload['news'] ?? [],
                    'timeline' => $payload['timeline'] ?? [],
                ]
            );
        }
    }
}
