{{-- <header class="border-b border-gray-200 bg-white">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <a href="/" class="text-xl font-medium tracking-tight">
                MINIMAL
            </a>

            <nav class="hidden md:flex items-center gap-8">
                <a href="/shop" class="text-sm hover:text-gray-600 transition-colors">
                    Shop
                </a>
                <a href="/about" class="text-sm hover:text-gray-600 transition-colors">
                    About
                </a>
                <a href="/contact" class="text-sm hover:text-gray-600 transition-colors">
                    Contact
                </a>
            </nav>

            <div class="flex items-center gap-4">
                <button wire:click="openCart" class="p-2 hover:bg-gray-100 rounded relative">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5.5M7 13l2.5 5.5m0 0L17 21m-7.5-2.5h9"/>
                    </svg>
                    @if($totalItems > 0)
                        <span class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-black text-white text-xs flex items-center justify-center">
                            {{ $totalItems }}
                        </span>
                    @endif
                </button>
                <button class="p-2 hover:bg-gray-100 rounded md:hidden">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header> --}}


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
                wire:click="abrirDialogProduto"
                class="px-4 py-2 text-md text-gray-600 hover:text-white hover:bg-gray-900 border border-red-200 rounded-md transition-all duration-200 flex items-center gap-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
               Produto
            </button>
            <!-- Botão limpar -->
            <button 
                wire:click="limpar"
                class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 border border-red-200 rounded-md transition-all duration-200 flex items-center gap-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Limpar Filtros
            </button>
            <!-- Carrinho -->
            <div class="relative" wire:click="abrirCarrinho()">

                <button class="p-2 text-gray-600 hover:text-gray-900 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H17M9 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM20.5 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                    </svg>
                </button>
                <!-- Badge do carrinho -->
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $totalItems }}
                </span>
            </div>
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
                        {{ number_format($produto->preco, 2, ',', '.') }} Kz
                    </p>
                    
                    @if($produto->quantidade > 0)
                        <button 
                            wire:click="adicionarAoCarrinho({{ $produto }})"
                            class="w-full mt-2 py-2 text-sm bg-gray-900 text-white hover:bg-gray-800 hover:shadow-xl hover:border-white-100 transition-colors flex items-center justify-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H17M9 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM20.5 19.5a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"/>
                            </svg>
                            Adicionar ao carrinho
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
