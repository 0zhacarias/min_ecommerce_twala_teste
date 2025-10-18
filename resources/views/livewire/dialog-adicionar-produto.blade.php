<div>
 {{--    <button wire:click="abrirDialogProduto"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
        Adicionar Produto
    </button> --}}

    @if ($isOpenDialogProduto)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 transition-opacity" wire:click="fecharDialogProduto"></div>
    @endif

    <!-- Dialog -->
    <div class="fixed inset-0 z-50 overflow-y-auto {{ $isOpenDialogProduto ? 'block' : 'hidden' }}">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all" wire:click.stop>
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">
                        Adicionar Novo Produto
                    </h2>
                    <button wire:click="fecharDialogProduto" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form wire:submit.prevent="adicionarProduto" class="p-6 space-y-6">
                    <!-- Imagem -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Imagem do Produto
                        </label>
                        @if ($imagem)
                            <div class="mb-4">
                                <img src="{{ $imagem->temporaryUrl() }}" alt="Preview"
                                    class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                            </div>
                        @endif
                        <input type="file" wire:model="imagem" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('imagem')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nome -->
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">
                            Nome do Produto
                        </label>
                        <input type="text" id="nome" wire:model="nome"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Digite o nome do produto">
                        @error('nome')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                 <div>
                        <select wire:model.live="categoria_id"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
{{--                             <option value="">Todas categorias</option>
 --}}                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                            @endforeach
                        </select>
                    </div> 
                    <!-- Descrição -->
                    <div>
                        <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">
                            Descrição
                        </label>
                        <textarea id="descricao" wire:model="descricao" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Descreva o produto..."></textarea>
                        @error('descricao')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantidade em Estoque -->
                    <div>
                        <label for="quantidade" class="block text-sm font-medium text-gray-700 mb-2">
                            Quantidade em Estoque
                        </label>
                        <input type="number" id="quantidade" wire:model="quantidade" min="1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="1">
                        @error('quantidade')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Preço -->
                    <div>
                        <label for="preco" class="block text-sm font-medium text-gray-700 mb-2">
                            Preço (Kz)
                        </label>
                        <input type="text" id="preco" wire:model="preco"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ex: 99.90">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4">
                        <button type="button" wire:click="fecharDialogProduto"
                            class="flex-1 px-4 py-2 border border-gray-300 text-red-700 rounded-md hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" wire:loading.attr="disabled"
                class="px-4 py-2 text-md text-gray-600 hover:text-white hover:bg-gray-900 border border-gray-200 rounded-md transition-all duration-200 flex items-center gap-2"
                            
                            >
                            <span wire:loading.remove>Salvar Produto</span>
                            <span wire:loading>Salvando...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50">
            {{ session('error') }}
        </div>
    @endif
</div>
