<div class="bg-white bg-opacity-10 backdrop-blur-lg border border-white border-opacity-20 rounded-2xl p-8 shadow-xl">
    <h2 class="text-2xl text-gray-400 mb-8 text-center">Inloggen</h2>
    
    <form wire:submit="login">
        <div class="mb-6">
            <input 
                wire:model="email" 
                type="email" 
                placeholder="Email" 
                class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 focus:border-transparent focus:ring-2 focus:ring-blue-600"
                required
            >
            @error('email')
                <p class="mt-1 text-red-400 text-sm">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <input 
                wire:model="password" 
                type="password" 
                placeholder="Wachtwoord" 
                class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 focus:border-transparent focus:ring-2 focus:ring-blue-600"
                required
            >
            @error('password')
                <p class="mt-1 text-red-400 text-sm">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="flex items-center text-gray-300">
                <input 
                    wire:model="remember" 
                    type="checkbox" 
                    class="mr-2"
                >
                <span>Onthouden</span>
            </label>
        </div>
        
        <button 
            type="submit" 
            class="w-full px-6 py-3 bg-gradient-to-r from-[#000000] via-[#0A0E1F] to-[#102459] text-white rounded-lg font-semibold hover:filter hover:brightness-110 transition"
        >
            Inloggen
        </button>
    </form>
</div>

