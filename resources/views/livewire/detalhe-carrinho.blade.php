<div>
    <!-- Overlay -->
    @if ($isCartOpen)
        <div class="fixed inset-0 bg-black/50 z-40 transition-opacity" wire:click="fecharCarrinho"></div>
    @endif

    <!-- Sidebar -->
    <div
        class="fixed right-0 top-0 h-full w-full max-w-md bg-white z-50 shadow-2xl flex flex-col transition-transform duration-300 {{ $isCartOpen ? 'translate-x-0' : 'translate-x-full' }}">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h2 class="text-xl font-medium">Carrinho</h2>
            <button wire:click="fecharCarrinho" class="p-2 hover:bg-gray-100 rounded">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-6">
            @if (empty($items))
                <div class="flex flex-col items-center justify-center h-full text-center">
                    <p class="text-gray-500 mb-4">Seu carrinho está vazio</p>
                    <button wire:click="closeCart" class="bg-black text-white px-4 py-2 rounded">
                        Continuar Comprando
                    </button>
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($items as $id => $item)
                        <div class="flex gap-4">
                            <div class="relative w-24 h-24 flex-shrink-0 bg-gray-100 rounded overflow-hidden">
                                <img src="{{ 'storage/'.$item['imagem'] ?: '/placeholder.svg' }}" alt="{{ $item['nome'] }}"
                                    class="object-cover w-full h-full" />
                            </div>

                            <div class="flex-1 flex flex-col justify-between">
                                <div class="flex items-center justify-between">
                                   
                                    <div>
                                        <h3 class="font-medium">{{ $item['nome'] }}</h3>
                                        <p class="text-sm text-gray-600">{{ number_format($item['preco'], 2, ',', '.') }} Kz</p>
                                    </div>
                                     <div>
                                        <h3 class="font-medium">Subtotal</h3>
                                        <p class="text-sm text-gray-600">{{ number_format($item['subtotal'], 2, ',', '.') }} Kz</p>
                                    </div>
                                </div>


                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <button
                                            class="h-8 w-8 border border-gray-300 rounded flex items-center justify-center hover:bg-gray-100"
                                            wire:click="updateQuantidade({{ $id }}, {{ $item['quantidade'] - 1 }})">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <span class="w-8 text-center">{{ $item['quantidade'] }}</span>
                                        <button
                                            class="h-8 w-8 border border-gray-300 rounded flex items-center justify-center hover:bg-gray-100"
                                            wire:click="updateQuantidade({{ $id }}, {{ $item['quantidade'] + 1 }})">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>

                                    <button
                                        class="h-8 w-8 text-red-600 hover:text-red-700 hover:bg-red-50 rounded flex items-center justify-center"
                                        wire:click="removeAoCarrinho({{ $id }})">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Footer -->
        @if (!empty($items))
            <div class="border-t border-gray-200 p-6 space-y-4">
                <div class="flex items-center justify-between text-lg font-medium">
                    <span>Total</span>
                    <span> {{ number_format($totalPreco, 2, ',', '.') }} Kz</span>
                </div>
                <button class="w-full bg-black text-white py-3 rounded font-medium disabled:bg-gray-400"
                    wire:click="checkout" wire:loading.attr="disabled">
                    <span wire:loading.remove>Finalizar Compra</span>
                    <span wire:loading>Processando...</span>
                </button>
            </div>
        @endif
    </div>
    @if (session()->has('error'))
        <div class="fixed top-4 right-4 bg-orange-100 border border-orange-400 text-orange-700 px-4 py-3 rounded z-50">
            {{ session('error') }}
        </div>
    @endif
    @if (session()->has('success'))
        <div class="fixed top-4 left-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50" 
>
            {{ session('success') }}
        </div>
    @endif
</div>
