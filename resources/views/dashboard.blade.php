<x-layouts.app>
    <section 
        id="producten-section" 
        class="tab-section hidden"
        data-tab-section="producten"
    >
        @livewire('products.index')
    </section>

    <section 
        id="dagboek-section" 
        class="tab-section hidden"
        data-tab-section="dagboek"
    >
        @livewire('diary.index')
    </section>

    <section 
        id="overzicht-section" 
        class="tab-section hidden"
        data-tab-section="overzicht"
    >
        @livewire('overview.index')
    </section>

    <section 
        id="nutrition-limieten-section" 
        class="tab-section hidden"
        data-tab-section="nutrition-limieten"
    >
        @livewire('settings.nutritional-limits')
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabSections = document.querySelectorAll('.tab-section');
            
            // Show first tab by default
            if (tabBtns.length > 0) {
                tabBtns[0].click();
            }
            
            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetTab = btn.dataset.tab;
                    
                    // Remove active class from all buttons
                    tabBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    
                    // Hide all sections
                    tabSections.forEach(sec => sec.classList.add('hidden'));
                    
                    // Show target section
                    const targetSection = document.querySelector(`[data-tab-section="${targetTab}"]`);
                    if (targetSection) {
                        targetSection.classList.remove('hidden');
                    }
                });
            });
        });
    </script>
</x-layouts.app>

