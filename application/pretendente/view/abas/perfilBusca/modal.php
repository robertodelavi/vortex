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
                    <p>Mauris mi tellus, pharetra vel mattis sed, tempus ultrices eros. Phasellus
                        egestas sit amet velit sed luctus. Orci varius natoque penatibus et magnis dis
                        parturient montes, nascetur ridiculus mus. Suspendisse potenti. Vivamus ultrices
                        sed urna ac pulvinar. Ut sit amet ullamcorper mi.</p>

                    <!-- Dados retornados do ajax -->
                    <div class="mt-5" id="resultAjaxPerfil">
                        <div class="flex flex-col sm:flex-row">

                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-6">
                                <div>
                                    <label for="perfilBuscaNome">Nome do Perfil</label>
                                    <input name="nome" id="perfilBuscaNome" type="text" placeholder="Jimmy Turner"
                                        class="form-input" />
                                </div>
                                <div>
                                    <label for="perfilBuscaTipoImovel">Tipo de Imóvel</label>
                                    <input name="nome" id="perfilBuscaTipoImovel" type="text" placeholder="Apartamento"
                                        class="form-input" />
                                </div>
                                <div>
                                    <label for="perfilBuscaTipoImovel">Empreendimento</label>
                                    <input name="nome" id="perfilBuscaEmpreendimento" type="text"
                                        placeholder="Empreendimento..." class="form-input" />
                                </div>

                                <!-- Dormitórios -->
                                <div>
                                    <label for="perfilBuscaFaixaValor">Dormitórios</label>
                                    <div class="flex w-full">
                                        <div class="flex items-center w-full">
                                            <div class="w-full">
                                                <input id="xxxx" type="text" placeholder="0" class="form-input" />
                                            </div>
                                            <div class="px-3">até</div>
                                            <div class="w-full">
                                                <input id="xxxx" type="text" placeholder="0" class="form-input" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sendo Suítes -->
                                <div>
                                    <label for="perfilBuscaFaixaValor">Sendo Suítes</label>
                                    <div class="flex w-full">
                                        <div class="flex items-center w-full">
                                            <div class="w-full">
                                                <input id="xxxx" type="text" placeholder="0" class="form-input" />
                                            </div>
                                            <div class="px-3">até</div>
                                            <div class="w-full">
                                                <input id="xxxx" type="text" placeholder="0" class="form-input" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Garagem -->
                                <div>
                                    <label for="perfilBuscaTipoImovel">Garagem</label>
                                    <input name="nome" type="text" placeholder="0" class="form-input" />
                                </div>

                                <!-- Faixa de valor -->
                                <div>
                                    <label for="perfilBuscaFaixaValor">Faixa de Valor</label>
                                    <div class="flex w-full">
                                        <div class="flex items-center w-full">
                                            <div class="w-full">
                                                <input id="currencyMask1" type="text" onkeyup="formatCurrency(this)"
                                                    placeholder="R$ 0,00" class="form-input" />
                                            </div>
                                            <div class="px-3">até</div>
                                            <div class="w-full">
                                                <input id="currencyMask2" type="text" onkeyup="formatCurrency(this)"
                                                    placeholder="R$ 0,00" class="form-input" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Área Terreno m² -->
                                <div>
                                    <label for="perfilBuscaFaixaValor">Área Terreno (m²)</label>
                                    <div class="flex w-full">
                                        <div class="flex items-center w-full">
                                            <div class="w-full">
                                                <input id="xxxx" type="text" placeholder="0,00" class="form-input" />
                                            </div>
                                            <div class="px-3">até</div>
                                            <div class="w-full">
                                                <input id="xxxx" type="text" placeholder="0,00" class="form-input" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Área Construída m² -->
                                <div>
                                    <label for="perfilBuscaFaixaValor">Área Construída (m²)</label>
                                    <div class="flex w-full">
                                        <div class="flex items-center w-full">
                                            <div class="w-full">
                                                <input id="xxxx" type="text" placeholder="0,00" class="form-input" />
                                            </div>
                                            <div class="px-3">até</div>
                                            <div class="w-full">
                                                <input id="xxxx" type="text" placeholder="0,00" class="form-input" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end items-center mt-8">
                    <button type="button" class="btn btn-outline-danger" @click="toggle">Discard</button>
                    <button type="button" class="btn btn-primary ltr:ml-4 rtl:mr-4" @click="toggle">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fim modal -->