<div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'">
    <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
        <div x-show="open" x-transition x-transition.duration.300
            class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-10">
            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                <h5 class="font-bold text-lg">Perfil de Busca</h5>
                <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="w-6 h-6">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="p-5">
                <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">                    
                    <!-- Perfil vindo do ajax -->
                    <div id="resulAjaxPerfilBusca"></div>                    
                </div>
            </div>
        </div>
    </div>
</div>