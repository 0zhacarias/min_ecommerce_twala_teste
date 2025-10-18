<?php

namespace App\Livewire;

use App\Models\Categoria;
use App\Models\Produto;
use Livewire\Component;
use Livewire\WithPagination;

class ListarProduto extends Component
{
    use WithPagination;


    public $search = "";
    public $categoria_id = "";
    public $precoMin = "";
    public $precoMax = "";

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
    public function render()
    {
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
       
        $pag_produtos = $produtos->paginate(6);
        $categorias = Categoria::distinct()->get();


        return view('livewire.listar-produto', [
            'produtos' => $pag_produtos,
            'categorias' => $categorias,
        ]);
    }
}
