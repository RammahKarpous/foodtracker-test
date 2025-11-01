<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KMD\'s foodtracker' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gradient-radial from-[#0A0B0E] via-[#080A0F] to-[#06070B] min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl text-center text-white mb-8">KMD's foodtracker</h1>
        
        <div class="max-w-md mx-auto">
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>
</html>

