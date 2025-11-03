<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KMD\'s foodtracker' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body {
            background: radial-gradient(ellipse 1200px 800px at 20% 0%, #0A0B0E 0%, #080A0F 40%, #06070B 100%);
            min-height: 100vh;
            color: #222;
            margin: 0;
            padding: 0;
        }
        
        h1 {
            text-align: center;
            color: #fff;
            font-size: 1.4em;
            margin: 18px 0 10px 0;
        }
        
        @media (min-width: 700px) {
            h1 {
                font-size: 2em;
                margin-top: 32px;
            }
        }
    </style>
</head>
<body>
    <h1>KMD's foodtracker</h1>
    <div class="w-full max-w-md mx-auto mt-8">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>

