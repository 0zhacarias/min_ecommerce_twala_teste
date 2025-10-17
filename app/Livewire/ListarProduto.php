<?php

namespace App\Livewire;

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
        $produtos=Produto::query();
        if($this->search){
            $produtos->where('nome','like','%'.$this->search.'%');
        }
        if($this->categoria){
            $produtos->where('categoria_id','like','%'.$this->categoria_id.'%');
        }
        if($this->precoMin){
            $produtos->where('preco','like','%'.$this->precoMin.'%');
        }
        if($this->precoMax){
            $produtos->where('preco','like','%'.$this->precoMax.'%');
        }



        return view('livewire.listar-produto');
    }
}
