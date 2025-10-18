<div>
    <!-- Overlay -->
    @if($isOpenDetalheProduto)
        <div 
            class="fixed inset-0 bg-black bg-opacity-50 z-50 transition-opacity"
            wire:click="fecharDialogDetalheProduto"
        ></div>
    @endif

    <!-- Dialog -->
    <div class="fixed inset-0 z-50 overflow-y-auto {{ $isOpenDetalheProduto ? 'block' : 'hidden' }}">
        <div class="flex min-h-full items-center justify-center p-4">
            <div 
                class="relative bg-white rounded-lg shadow-xl w-full max-w-4xl transform transition-all"
                wire:click.stop
            >
                @if($produto)
                    <!-- Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <h2 class="text-2xl font-semibold text-gray-900">
                            Detalhes do Produto
                        </h2>
                        <button 
                            wire:click="fecharDialogDetalheProduto"
                            class="text-gray-400 hover:text-gray-600 transition-colors p-2"
                        >
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                                    <img 
                                        src="{{ $produto->imagem }}" 
                                        alt="{{ $produto->nome }}"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Disponibilidade:</span>
                                    @if($produto->quantidade > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Em Stock ({{ $produto->quantidade }} unidades)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Fora de Stock
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div>
                                    <h1 class="text-3xl font-bold text-gray-900">{{ $produto->nome }}</h1>
                                    <p class="text-2xl font-semibold text-blue-600 mt-2">
                                        {{ number_format($produto->preco, 2, ',', '.') }} Kz
                                    </p>
                                </div>

                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Descrição</h3>
                                    <p class="text-gray-600 leading-relaxed">{{ $produto->descricao }}</p>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Categoria</h3>
                                    <p class="text-gray-600 leading-relaxed">{{ $produto->categoria->nome }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                @else
                    <!-- Loading ou erro -->
                    <div class="p-8 text-center">
                        <p class="text-gray-500">Carregando...</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>