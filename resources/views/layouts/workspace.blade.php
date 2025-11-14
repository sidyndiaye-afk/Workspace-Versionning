<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Levell Workspace' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="{{ $bodyClass ?? 'workspace-body min-h-screen text-[#F8FFF1]' }}">
    <div class="flex min-h-screen flex-col">
        @yield('workspace')
    </div>
    @stack('scripts')
</body>
</html>
