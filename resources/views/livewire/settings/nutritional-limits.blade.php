<div class="w-full">
    <h2 class="text-gray-400 text-xl mb-6">Nutrition limieten aanpassen</h2>
    
    @if(session()->has('message'))
        <div class="mb-4 p-4 bg-green-500 bg-opacity-20 border border-green-500 rounded-lg text-green-400">
            {{ session('message') }}
        </div>
    @endif
    
    <form wire:submit="save" class="w-full flex flex-col gap-2 mb-4">
        <input 
            wire:model="kcal_limiet" 
            type="text" 
            pattern="[0-9]*[.,]?[0-9]*" 
            placeholder="Kcal limiet" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        @error('kcal_limiet')
            <p class="text-red-400 text-sm">{{ $message }}</p>
        @enderror
        
        <input 
            wire:model="vet_limiet" 
            type="text" 
            pattern="[0-9]*[.,]?[0-9]*" 
            placeholder="Vet limiet (g)" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        @error('vet_limiet')
            <p class="text-red-400 text-sm">{{ $message }}</p>
        @enderror
        
        <input 
            wire:model="verzadigd_limiet" 
            type="text" 
            pattern="[0-9]*[.,]?[0-9]*" 
            placeholder="Verzadigd vet limiet (g)" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        @error('verzadigd_limiet')
            <p class="text-red-400 text-sm">{{ $message }}</p>
        @enderror
        
        <input 
            wire:model="koolhydraten_limiet" 
            type="text" 
            pattern="[0-9]*[.,]?[0-9]*" 
            placeholder="Koolhydraten limiet (g)" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        @error('koolhydraten_limiet')
            <p class="text-red-400 text-sm">{{ $message }}</p>
        @enderror
        
        <input 
            wire:model="suiker_limiet" 
            type="text" 
            pattern="[0-9]*[.,]?[0-9]*" 
            placeholder="Suiker limiet (g)" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        @error('suiker_limiet')
            <p class="text-red-400 text-sm">{{ $message }}</p>
        @enderror
        
        <input 
            wire:model="eiwit_limiet" 
            type="text" 
            pattern="[0-9]*[.,]?[0-9]*" 
            placeholder="Eiwit limiet (g)" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        @error('eiwit_limiet')
            <p class="text-red-400 text-sm">{{ $message }}</p>
        @enderror
        
        <button 
            type="submit" 
            class="w-full px-6 py-3 bg-gradient-to-r from-[#000000] via-[#0A0E1F] to-[#102459] text-white rounded-lg font-semibold hover:brightness-110 transition mt-2"
        >
            Opslaan
        </button>
    </form>
</div>
