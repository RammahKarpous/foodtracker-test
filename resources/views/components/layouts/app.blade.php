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
        
        nav button.active {
            background: linear-gradient(90deg, #101425 0%, #122553 60%, #1C3F8B 100%) !important;
            box-shadow: 0 8px 24px rgba(16, 36, 89, 0.45);
        }
        
        @media (min-width: 700px) {
            h1 {
                font-size: 2em;
                margin-top: 32px;
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
    <h1>KMD's foodtracker</h1>
    <nav class="flex justify-center gap-2 my-5">
        <button 
            class="tab-btn px-5 py-3 bg-gradient-to-r from-[#0B0D14] via-[#0D142A] to-[#123072] text-white rounded-lg cursor-pointer transition filter brightness-100 border border-white/8"
            data-tab="producten">
            Producten
        </button>
        <button 
            class="tab-btn px-5 py-3 bg-gradient-to-r from-[#0B0D14] via-[#0D142A] to-[#123072] text-white rounded-lg cursor-pointer transition filter brightness-100 border border-white/8"
            data-tab="dagboek">
            Dagboek
        </button>
        <button 
            class="tab-btn px-5 py-3 bg-gradient-to-r from-[#0B0D14] via-[#0D142A] to-[#123072] text-white rounded-lg cursor-pointer transition filter brightness-100 border border-white/8"
            data-tab="overzicht">
            Overzicht
        </button>
        <button 
            class="tab-btn px-5 py-3 bg-gradient-to-r from-[#0B0D14] via-[#0D142A] to-[#123072] text-white rounded-lg cursor-pointer transition filter brightness-100 border border-white/8"
            data-tab="nutrition-limieten">
            Wijzig nutrition limieten
        </button>
        <form action="{{ route('logout') }}" method="POST" class="ml-4">
            @csrf
            <button type="submit" class="px-5 py-3 bg-gradient-to-r from-[#000000] via-[#0A0E1F] to-[#102459] text-white rounded-lg cursor-pointer hover:brightness-110 transition">
                Uitloggen
            </button>
        </form>
    </nav>
    
    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
