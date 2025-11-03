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
            margin: 0;
        }
        
        .tab-section {
            width: 98vw;
            max-width: 480px;
            margin: 0 auto 24px auto;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.10);
            color: #f6f8fa;
            padding: 14px 4vw 18px 4vw;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.35);
            backdrop-filter: blur(20px) saturate(120%);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        nav button.active,
        nav a.active {
            background: linear-gradient(90deg, #101425 0%, #122553 60%, #1C3F8B 100%) !important;
            box-shadow: 0 8px 24px rgba(16, 36, 89, 0.45);
        }
        
        @media (min-width: 700px) {
            h1 {
                font-size: 2em;
            }
            
            .tab-section {
                max-width: 700px;
                padding: 32px 40px 28px 40px;
                border-radius: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="flex justify-between items-center px-4 my-4">
        <div></div>
        <h1>KMD's foodtracker</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-white text-2xl hover:opacity-70 transition" title="Uitloggen">
                🚪
            </button>
        </form>
    </div>
    <nav class="flex justify-center gap-2 my-5">
        <a 
            href="{{ route('products') }}"
            class="nav-link px-5 py-3 bg-gradient-to-r from-[#0B0D14] via-[#0D142A] to-[#123072] text-white rounded-lg cursor-pointer transition filter brightness-100 {{ request()->routeIs('products') ? 'active' : '' }}">
            Producten
        </a>
        <a 
            href="{{ route('diary') }}"
            class="nav-link px-5 py-3 bg-gradient-to-r from-[#0B0D14] via-[#0D142A] to-[#123072] text-white rounded-lg cursor-pointer transition filter brightness-100 {{ request()->routeIs('diary') ? 'active' : '' }}">
            Dagboek
        </a>
        <a 
            href="{{ route('overview') }}"
            class="nav-link px-5 py-3 bg-gradient-to-r from-[#0B0D14] via-[#0D142A] to-[#123072] text-white rounded-lg cursor-pointer transition filter brightness-100 {{ request()->routeIs('overview') ? 'active' : '' }}">
            Overzicht
        </a>
        <a 
            href="{{ route('nutrition-limits') }}"
            class="nav-link px-5 py-3 bg-gradient-to-r from-[#0B0D14] via-[#0D142A] to-[#123072] text-white rounded-lg cursor-pointer transition filter brightness-100 {{ request()->routeIs('nutrition-limits') ? 'active' : '' }}">
            Wijzig nutrition limieten
        </a>
    </nav>
    
    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
