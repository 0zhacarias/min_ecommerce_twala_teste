<div class="max-w-screen mx-auto px-4 py-6">
    <!-- Filtros -->
    <div class="mb-8">
        <div class="flex flex-wrap gap-8 items-end">
            <!-- Pesquisa por nome -->
            <div class="flex-1 min-w-64">
                <input 
                    type="text" 
                    wire:model.live="search"
                    placeholder="Buscar produto..."
                    class="w-full px-4 py-2 border-0 border-b-2 border-gray-200 focus:border-gray-900 focus:outline-none bg-transparent"
                >
            </div>

            <!-- Filtro por categoria -->
            <div>
                <select 
                    wire:model.live="categoria_id"
                    class="px-4 py-2 border-0 border-b-2 border-gray-200 focus:border-gray-900 focus:outline-none bg-transparent"
                >
                    <option value="">Todas categorias</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtros de preço -->
            <div class="flex gap-2">
                <input 
                    type="number" 
                    wire:model.live="precoMin"
                    placeholder="Min"
                    class="w-20 px-3 py-2 border-0 border-b-2 border-gray-200 focus:border-gray-900 focus:outline-none bg-transparent text-sm"
                >
                <span class="py-2 text-gray-400">-</span>
                <input 
                    type="number" 
                    wire:model.live="precoMax"
                    placeholder="Max"
                    class="w-20 px-3 py-2 border-0 border-b-2 border-gray-200 focus:border-gray-900 focus:outline-none bg-transparent text-sm"
                >
            </div>

            <!-- Botão limpar -->
            <button 
                wire:click="limpar"
                class="text-sm text-gray-500 hover:text-gray-900 underline"
            >
                Limpar
            </button>
        </div>
    </div>

    <!-- Grid de Produtos -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach($produtos as $produto)
            <div class="group">
                <!-- Imagem -->
                <div class="aspect-square bg-gray-50 mb-3 overflow-hidden">
                    @if($produto->imagem)
                        <img 
                            src="{{ $produto->imagem }}" 
                            alt="{{ $produto->nome }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                        >
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <div class="w-12 h-12 text-gray-300">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Informações -->
                <div class="space-y-1">
                    <h3 class="font-medium text-gray-900 text-sm">{{ $produto->nome }}</h3>
                    <p class="text-xs text-gray-500">{{ $produto->categoria }}</p>
                    <p class="font-semibold text-gray-900">
                        R$ {{ number_format($produto->preco, 2, ',', '.') }}
                    </p>
                    
                    @if($produto->estoque > 0)
                        <button 
                            wire:click="addToCart({{ $produto->id }})"
                            class="w-full mt-2 py-2 text-sm bg-gray-900 text-white hover:bg-gray-800 transition-colors"
                        >
                            Comprar
                        </button>
                    @else
                        <div class="w-full mt-2 py-2 text-sm bg-gray-100 text-gray-400 text-center">
                            Esgotado
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Paginação -->
    <div class="mt-12">
        {{ $produtos->links() }}
    </div>
</div>
