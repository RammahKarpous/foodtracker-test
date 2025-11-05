<div class="w-full">
    @if (session()->has('message'))
        <div class="mb-4 px-4 py-3 bg-green-600 bg-opacity-30 border border-green-500 border-opacity-50 rounded-lg text-green-200 text-center">
            {{ session('message') }}
        </div>
    @endif
    
    <h2 class="text-gray-400 text-xl mb-6">Voeg een product toe</h2>
    
    <form wire:submit.prevent="save" class="w-full flex flex-col gap-2 mb-4">
        <input 
            wire:model="naam" 
            type="text" 
            placeholder="Productnaam" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        <input 
            wire:model="kcal" 
            type="text" 
            pattern="[0-9]*[.,]?[0-9]*" 
            placeholder="Kcal/100g" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        <input 
            wire:model="vet" 
            type="text" 
            pattern="[0-9]*[.,]?[0-9]*" 
            placeholder="Vetten/100g (g)" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        <input 
            wire:model="verzadigd" 
            type="text" 
            pattern="[0-9]*[.,]?[0-9]*" 
            placeholder="Verzadigd vet/100g (g)" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        <input 
            wire:model="koolhydraten" 
            type="text" 
            pattern="[0-9]*[.,]?[0-9]*" 
            placeholder="Koolhydraten/100g (g)" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        <input 
            wire:model="suiker" 
            type="text" 
            pattern="[0-9]*[.,]?[0-9]*" 
            placeholder="Suiker/100g (g)" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        <input 
            wire:model="eiwit" 
            type="text" 
            pattern="[0-9]*[.,]?[0-9]*" 
            placeholder="Eiwit/100g (g)" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        <button 
            type="submit" 
            class="w-full px-6 py-3 bg-gradient-to-r from-[#000000] via-[#0A0E1F] to-[#102459] text-white rounded-lg font-semibold hover:brightness-110 transition mt-2"
        >
            Toevoegen
        </button>
    </form>
    
    <div class="w-full overflow-x-auto mb-4">
        <input 
            wire:model.live.debounce.300ms="search" 
            type="text" 
            placeholder="Zoek product..." 
            list="products-list"
            autocomplete="off"
            class="w-full px-4 py-3 bg-gray-900 border border-white border-opacity-10 rounded-lg text-white placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
        >
        <datalist id="products-list">
            @foreach($this->products as $product)
                <option value="{{ $product->naam }}">
            @endforeach
        </datalist>
    </div>
    
    <div class="w-full overflow-x-auto">
        <table class="w-full border-collapse border-spacing-0 bg-transparent">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-gray-400 font-semibold border-b-2 border-white border-opacity-10">Naam</th>
                    <th class="px-4 py-3 text-gray-400 font-semibold border-b-2 border-white border-opacity-10">Kcal</th>
                    <th class="px-4 py-3 text-gray-400 font-semibold border-b-2 border-white border-opacity-10">Vet</th>
                    <th class="px-4 py-3 text-gray-400 font-semibold border-b-2 border-white border-opacity-10">Verz. vet</th>
                    <th class="px-4 py-3 text-gray-400 font-semibold border-b-2 border-white border-opacity-10">Koolhydraten</th>
                    <th class="px-4 py-3 text-gray-400 font-semibold border-b-2 border-white border-opacity-10">Suiker</th>
                    <th class="px-4 py-3 text-gray-400 font-semibold border-b-2 border-white border-opacity-10">Eiwit</th>
                    <th class="px-4 py-3 text-gray-400 font-semibold border-b-2 border-white border-opacity-10">✏️</th>
                    <th class="px-4 py-3 text-gray-400 font-semibold border-b-2 border-white border-opacity-10">🗑️</th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->products as $product)
                    <tr class="border-b border-white border-opacity-8">
                        <td class="px-4 py-3 text-gray-300">{{ $product->naam }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $product->kcal }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $product->vet }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $product->verzadigd }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $product->koolhydraten }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $product->suiker }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $product->eiwit }}</td>
                        <td class="px-4 py-3">
                            <button 
                                wire:click="edit({{ $product->id }})" 
                                class="text-2xl cursor-pointer"
                                title="Bewerk"
                            >
                                ✏️
                            </button>
                        </td>
                        <td class="px-4 py-3">
                            <button 
                                wire:click="delete({{ $product->id }})" 
                                wire:confirm="Bent u zeker dat u het wilt verwijderen?"
                                class="text-2xl cursor-pointer"
                                title="Verwijder"
                            >
                                🗑️
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($this->products->isEmpty())
            <p class="text-center text-gray-400 mt-4">Geen producten gevonden</p>
        @endif
    </div>

    <!-- Edit Modal -->
    @if($editingId)
        <div class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-[9999]" style="position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; bottom: 0 !important;">
            <div class="bg-black border border-white border-opacity-20 rounded-2xl p-8 shadow-xl max-w-md w-full mx-4">
                <h2 class="text-2xl text-gray-400 mb-6 text-center">Product bewerken</h2>
                
                <form wire:submit.prevent="update" class="flex flex-col gap-2">
                    <input 
                        wire:model="editNaam" 
                        type="text" 
                        placeholder="Productnaam" 
                        class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
                        required
                    >
                    <input 
                        wire:model="editKcal" 
                        type="text" 
                        pattern="[0-9]*[.,]?[0-9]*" 
                        placeholder="Kcal/100g" 
                        class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
                        required
                    >
                    <input 
                        wire:model="editVet" 
                        type="text" 
                        pattern="[0-9]*[.,]?[0-9]*" 
                        placeholder="Vetten/100g (g)" 
                        class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
                        required
                    >
                    <input 
                        wire:model="editVerzadigd" 
                        type="text" 
                        pattern="[0-9]*[.,]?[0-9]*" 
                        placeholder="Verzadigd vet/100g (g)" 
                        class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
                        required
                    >
                    <input 
                        wire:model="editKoolhydraten" 
                        type="text" 
                        pattern="[0-9]*[.,]?[0-9]*" 
                        placeholder="Koolhydraten/100g (g)" 
                        class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
                        required
                    >
                    <input 
                        wire:model="editSuiker" 
                        type="text" 
                        pattern="[0-9]*[.,]?[0-9]*" 
                        placeholder="Suiker/100g (g)" 
                        class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
                        required
                    >
                    <input 
                        wire:model="editEiwit" 
                        type="text" 
                        pattern="[0-9]*[.,]?[0-9]*" 
                        placeholder="Eiwit/100g (g)" 
                        class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
                        required
                    >
                    
                    <div class="flex gap-2 mt-4">
                        <button 
                            type="submit" 
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-[#000000] via-[#0A0E1F] to-[#102459] text-white rounded-lg font-semibold hover:brightness-110 transition"
                        >
                            Bijwerken
                        </button>
                        <button 
                            type="button" 
                            wire:click="closeModal" 
                            class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg font-semibold hover:brightness-110 transition"
                        >
                            Annuleren
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
