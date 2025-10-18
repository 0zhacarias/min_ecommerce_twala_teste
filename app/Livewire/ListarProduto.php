<?php

namespace App\Livewire;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class ListarProduto extends Component
{
    use WithPagination;


    public $search = "";
    public $categoria_id = "";
    public $precoMin = "";
    public $precoMax = "";
    public $totalItems = 0;

    protected $listeners = ['contar-carrinho' => 'updateContagem', /*  'produto_adicionado' => 'adicionarProduto' */ 'produto_adicionado' => '$refresh' ];

    public function atualizar($propriadade)
    {
        if (in_array($propriadade, ['search', 'categoria_id', 'precoMin', 'precoMax'])) {
            $this->resetPage();
        }
    }
    public function limpar()
    {
        // $this->reset(['search', 'categoria', 'precoMin', 'precoMax']);
        $this->search = "";
        $this->categoria_id = "";
        $this->precoMin = "";
        $this->precoMax = "";
        
    }
    public function adicionarAoCarrinho($produto)
    {
         $carrinho = Session::get('carrinho', []);
        $produtoId = $produto['id'];
        
        if (isset($carrinho[$produtoId])) {
            $carrinho[$produtoId]['quantidade']++;
        } else {
            $carrinho[$produtoId] = [
                'id' => $produto['id'],
                'nome' => $produto['nome'],
                'preco' => $produto['preco'],
                'imagem' => $produto['imagem'],
                'quantidade' => 1
            ];
        }

        // Calcular subtotal para o item
        $preco = (float)  $carrinho[$produtoId]['preco'];
        $carrinho[$produtoId]['subtotal'] = ($preco * $carrinho[$produtoId]['quantidade']);

        Session::put('carrinho', $carrinho);
        $this->dispatch('contar-carrinho');
        $this->dispatch('abrir-carrinho');
       // $this->emit('produtoAdicionadoAoCarrinho', $produtoId);
    }

/*     public function mount()
    {
        $this->updateContagem();
    }
 */
    public function updateContagem()
    {
        $carrinho = Session::get('carrinho', []);
        $this->totalItems = array_sum(array_column($carrinho, 'quantidade'));
    }
    public function abrirDialogProduto(){
        $this->dispatch('abrir-dialog-produto');
    }

    public function abrirCarrinho()
    {
       
        $this->dispatch('abrir-carrinho');
        //$this->emit('abrirCarrinho');
    }
    public function getProdutosProperty()
    {
       // dd($produto);
        /* return Produto::latest()->get()->map(function ($produto) {
            return [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'descricao' => $produto->descricao,
                'quantidade' => $produto->quantidade,
                'categoria_id' => $produto->categoria_id,
                'imagem' => $produto->imagem,
                'preco' => $produto->preco,
            ];
        }); */
        // Lógica para adicionar o produto
      //  $this->adicionarAoCarrinho($produto);
      return Produto::with('categoria')->latest()->paginate(8);
    }
    public function render()
    {
            //  Session::forget('carrinho');

        $produtos = Produto::query();
        if ($this->search) {
            $produtos->where('nome', 'like', '%' . $this->search . '%');
        }
        if ($this->categoria_id) {
            //   dd($produtos->get(),$this->categoria_id);
            $produtos->where('categoria_id', 'like', '%' . $this->categoria_id . '%');
        }
        if ($this->precoMin) {
            $produtos->where('preco', 'like', '%' . $this->precoMin . '%');
        }
        if ($this->precoMax) {
            $produtos->where('preco', 'like', '%' . $this->precoMax . '%');
        }

        $pag_produtos = $produtos->paginate(10);
        $categorias = Categoria::distinct()->get();


        return view('livewire.listar-produto', [
            'produtos' => $pag_produtos,
            'categorias' => $categorias,
        ]);
    }
}
