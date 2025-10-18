<?php

namespace App\Livewire;

use App\Models\Produto;
use Livewire\Component;

class DetalheProduto extends Component
{

    public $isOpenDetalheProduto = false;
    public $produto;
    protected $listeners = ['abrirDialogDetalheProduto' => 'abrirDetalheProduto'];
    public function abrirDetalheProduto($id_produto)
    {

        $this->isOpenDetalheProduto = true;
        $this->produto = Produto::with('categoria')->find($id_produto);
    }

    public function fecharDialogDetalheProduto()
    {
        $this->isOpenDetalheProduto = false;
    }
    public function render()
    {
        return view('livewire.detalhe-produto');
    }
}
