<div class="w-full">
    <div class="flex items-center justify-center gap-4 mb-6">
        <button 
            wire:click="previousDay" 
            class="bg-transparent border-none text-blue-600 text-3xl cursor-pointer"
            title="Vorige dag"
        >
            &#8592;
        </button>
        <span class="text-lg text-gray-400 font-semibold">{{ $this->formatDate($selectedDate) }}</span>
        <button 
            wire:click="nextDay" 
            class="bg-transparent border-none text-blue-600 text-3xl cursor-pointer"
            title="Volgende dag"
        >
            &#8594;
        </button>
    </div>
    
    @if (session()->has('message'))
        <div class="mb-4 px-4 py-3 bg-green-600 bg-opacity-30 border border-green-500 border-opacity-50 rounded-lg text-green-200 text-center">
            {{ session('message') }}
        </div>
    @endif
    
    <h2 class="text-gray-400 text-xl mb-6">Wat heb je vandaag gegeten?</h2>
    
    <form wire:submit.prevent="save" class="w-full flex flex-col gap-2 mb-6">
        <select 
            wire:model="moment" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
            <option value="">Kies eetmoment...</option>
            <option>Ontbijt</option>
            <option>Lunch</option>
            <option>Tussendoor</option>
            <option>Diner</option>
            <option>Voor training</option>
            <option>Na training</option>
        </select>
        
        <input 
            wire:model="productNaam" 
            list="products" 
            placeholder="Zoek of kies product..." 
            autocomplete="off"
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        <datalist id="products">
            @foreach($this->products as $product)
                <option value="{{ $product }}">
            @endforeach
        </datalist>
        
        <input 
            wire:model="gram" 
            type="text" 
            pattern="[0-9]*[.,]?[0-9]*" 
            placeholder="Aantal gram" 
            class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
            required
        >
        
        <button 
            type="submit" 
            class="w-full px-6 py-3 bg-gradient-to-r from-[#000000] via-[#0A0E1F] to-[#102459] text-white rounded-lg font-semibold hover:brightness-110 transition mt-2"
        >
            Toevoegen aan dagboek
        </button>
    </form>
    
    <div class="w-full overflow-x-auto mb-6">
        <table class="w-full border-collapse border-spacing-0 bg-transparent">
            <thead>
                <tr>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Moment</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Product</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Gram</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Kcal</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Vet</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Verz. vet</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Kh</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Suiker</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Eiwit</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">✏️</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">🗑️</th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->entriesForDate as $entry)
                    <tr class="border-b border-white border-opacity-8">
                        <td class="px-2 py-2 text-gray-300 text-xs">{{ $entry->moment }}</td>
                        <td class="px-2 py-2 text-gray-300 text-xs">{{ $entry->product_naam }}</td>
                        <td class="px-2 py-2 text-gray-300 text-xs">{{ $entry->gram }}</td>
                        <td class="px-2 py-2 text-gray-300 text-xs">{{ $entry->kcal }}</td>
                        <td class="px-2 py-2 text-gray-300 text-xs">{{ $entry->vet }}</td>
                        <td class="px-2 py-2 text-gray-300 text-xs">{{ $entry->verzadigd }}</td>
                        <td class="px-2 py-2 text-gray-300 text-xs">{{ $entry->koolhydraten }}</td>
                        <td class="px-2 py-2 text-gray-300 text-xs">{{ $entry->suiker }}</td>
                        <td class="px-2 py-2 text-gray-300 text-xs">{{ $entry->eiwit }}</td>
                        <td class="px-2 py-2">
                            <button 
                                wire:click="edit({{ $entry->id }})" 
                                class="text-lg cursor-pointer"
                                title="Bewerk"
                            >
                                ✏️
                            </button>
                        </td>
                        <td class="px-2 py-2">
                            <button 
                                wire:click="deleteEntry({{ $entry->id }})" 
                                wire:confirm="Bent u zeker dat u het wilt verwijderen?"
                                class="text-lg cursor-pointer"
                                title="Verwijder"
                            >
                                🗑️
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <h3 class="text-gray-400 text-lg mb-4">Overzicht per eetmoment en totaal</h3>
    
    <div class="w-full overflow-x-auto">
        <table class="w-full border-collapse border-spacing-0 bg-transparent">
            <thead>
                <tr>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Moment</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Kcal</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Vet</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Verzadigd vet</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Koolhydraten</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Suiker</th>
                    <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Eiwit</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $summary = $this->momentenSummary;
                    $limits = $this->limits;
                @endphp
                @foreach($summary as $moment => $totals)
                    <tr class="border-b border-white border-opacity-8">
                        <td class="px-2 py-2 text-gray-300 text-xs font-semibold">{{ $moment }}</td>
                        <td class="px-2 py-2 text-xs {{ $totals['kcal'] > $limits['kcal'] ? 'text-red-600 font-bold' : 'text-gray-300' }}">{{ number_format($totals['kcal'], 1) }}</td>
                        <td class="px-2 py-2 text-xs {{ $totals['vet'] > $limits['vet'] ? 'text-red-600 font-bold' : 'text-gray-300' }}">{{ number_format($totals['vet'], 1) }}</td>
                        <td class="px-2 py-2 text-xs {{ $totals['verzadigd'] > $limits['verzadigd'] ? 'text-red-600 font-bold' : 'text-gray-300' }}">{{ number_format($totals['verzadigd'], 1) }}</td>
                        <td class="px-2 py-2 text-xs {{ $totals['koolhydraten'] > $limits['koolhydraten'] ? 'text-red-600 font-bold' : 'text-gray-300' }}">{{ number_format($totals['koolhydraten'], 1) }}</td>
                        <td class="px-2 py-2 text-xs {{ $totals['suiker'] > $limits['suiker'] ? 'text-red-600 font-bold' : 'text-gray-300' }}">{{ number_format($totals['suiker'], 1) }}</td>
                        <td class="px-2 py-2 text-xs {{ $totals['eiwit'] > $limits['eiwit'] ? 'text-red-600 font-bold' : 'text-gray-300' }}">{{ number_format($totals['eiwit'], 1) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Edit Modal -->
    @if($editingId)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; display: flex; align-items: center; justify-content: center;">
            <div class="bg-white bg-opacity-10 backdrop-blur-lg border border-white border-opacity-20 rounded-2xl p-8 shadow-xl max-w-md w-full mx-4" style="max-height: 90vh; overflow-y: auto;">
                <h2 class="text-2xl text-gray-400 mb-6 text-center">Entry bewerken</h2>
                
                <form wire:submit.prevent="update" class="flex flex-col gap-2">
                    <select 
                        wire:model="editMoment" 
                        class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 focus:border-transparent focus:ring-2 focus:ring-blue-600"
                        required
                    >
                        <option value="">Kies eetmoment...</option>
                        <option>Ontbijt</option>
                        <option>Lunch</option>
                        <option>Tussendoor</option>
                        <option>Diner</option>
                        <option>Voor training</option>
                        <option>Na training</option>
                    </select>
                    
                    <input 
                        wire:model="editProductNaam" 
                        list="products" 
                        placeholder="Zoek of kies product..." 
                        autocomplete="off"
                        class="w-full px-4 py-3 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg text-gray-300 placeholder-gray-500 focus:border-transparent focus:ring-2 focus:ring-blue-600"
                        required
                    >
                    
                    <input 
                        wire:model="editGram" 
                        type="text" 
                        pattern="[0-9]*[.,]?[0-9]*" 
                        placeholder="Aantal gram" 
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
