<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KMD\'s foodtracker' }}</title>
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="192x192" href="/icons/icon-192.png">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <meta name="theme-color" content="#0B0D14">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Foodtracker">
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

