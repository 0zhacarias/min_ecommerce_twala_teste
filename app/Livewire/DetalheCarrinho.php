<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class DetalheCarrinho extends Component
{


    public $isCartOpen = false;
    public $isCheckingOut = false;
    public $items = [];
    public $totalPreco = 0;
    //protected $listeners = ['dialog-encomenda' => 'updateContagem' ];

    #[On('abrir-carrinho')]
    public function abrirCarrinho()
    {
        $this->isCartOpen = true;
    }

    #[On('fechar-carrinho')]
    public function fecharCarrinho()
    {
        $this->isCartOpen = false;
    }

    public function mount()
    {
        $this->updateDadoCarrinho();
    }

    #[On('contar-carrinho')]
    public function updateDadoCarrinho()
    {
        $carrinho = Session::get('carrinho', []);
        foreach ($carrinho as $id => $item) {
            $preco = (float)  $item['preco'];
            //$carrinho[$id]['subtotal'] = 'Kz ' . number_format($preco * $item['quantidade'], 2, ',', '.');
            $carrinho[$id]['subtotal'] = ($preco * $item['quantidade']);
        }

        $this->items = $carrinho;
        $this->calculateTotal();
    }

    public function updateQuantidade($productId, $quantidade)
    {
        $carrinho = Session::get('carrinho', []);

        if ($quantidade <= 0) {
            unset($carrinho[$productId]);
        } else {
            $carrinho[$productId]['quantidade'] = $quantidade;
            $preco = (float)  $carrinho[$productId]['preco'];
            $carrinho[$productId]['subtotal'] =  ($preco * $quantidade);
        }

        Session::put('carrinho', $carrinho);
        $this->updateDadoCarrinho();
        $this->dispatch('contar-carrinho');
    }

    public function removeAoCarrinho($productId)
    {
        $carrinho = Session::get('carrinho', []);
        unset($carrinho[$productId]);
        Session::put('carrinho', $carrinho);
        $this->updateDadoCarrinho();
        $this->dispatch('contar-carrinho');
    }

    public function limparCarrinho()
    {
        Session::forget('carrinho');
        $this->updateDadoCarrinho();
        $this->dispatch('contar-carrinho');
    }


public function checkout()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Você precisa estar logado para finalizar a compra.');
            $this->isCheckingOut = false;
            return;
        }

        if (empty($this->items)) {
            session()->flash('error', 'Seu carrinho está vazio.');
            return;
        }

        $this->dispatch('abrir-dialog-encomenda');

        
    }

    private function calculateTotal()
    {
        $this->totalPreco = 0;
        foreach ($this->items as $item) {
            $preco = (float)  $item['preco'];
            $this->totalPreco += $preco * $item['quantidade'];
        }
    }


    public function render()
    {
        return view('livewire.detalhe-carrinho');
    }
}
