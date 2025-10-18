<div>
    @if ($isOpenDialogEncomenda)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 transition-opacity" wire:click="fecharDialogEncomenda">
        </div>
    @endif

    <!-- Dialog -->
    <div class="fixed inset-0 z-50 overflow-y-auto {{ $isOpenDialogEncomenda ? 'block' : 'hidden' }}">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all" wire:click.stop>
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">
                        Finalizar Encomenda
                    </h2>
                    <button wire:click="fecharDialogEncomenda"
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Informações de entrega -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Endereço de Entrega
                            </label>
                            <textarea wire:model="endereco"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('endereco') border-red-500 @enderror"
                                rows="3" placeholder="Digite seu endereço completo..."></textarea>
                            @error('endereco')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Método de pagamento -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Método de Pagamento
                            </label>
                            <select wire:model="metodo_pagamento"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('metodoPagamento') border-red-500 @enderror">
                                <option value="">Selecione...</option>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="transferencia">Transferência Bancária</option>
                                <option value="multicaixa">Multicaixa Express</option>
                            </select>
                            @error('metodo_pagamento')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Observações -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Observações (opcional)
                            </label>
                            <textarea wire:model="observacoes"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                rows="2" placeholder="Alguma observação especial..."></textarea>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-1 pt-3">
                        <button type="button" wire:click="fecharDialogEncomenda"
                            class="flex-1 p-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="button" wire:click="confirmarEncomenda" wire:loading.attr="disabled"
                            class="flex-1 p-1 bg-gray-900 text-white rounded-md hover:bg-gray-700 transition-colors disabled:opacity-50">
                            <span wire:loading.remove wire:target="confirmarEncomenda">Confirmar</span>
                            <span wire:loading wire:target="confirmarEncomenda">Processando...</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @if (session()->has('success'))
        <div class="fixed top-4 left-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50">
            {{ session('success') }}
        </div>
    @endif
</div>
