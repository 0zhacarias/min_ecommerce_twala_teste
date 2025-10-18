<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class DialogAdicionarProduto extends Component
{
    use WithFileUploads;
    public $isOpenDialogProduto = false;
    public $imagem;
    public $nome = '';
    public $descricao = '';
    public $quantidade = 0;
    public $categoria_id = '';

    protected function rules()
    {
        return [
            'nome' => 'required|min:5',
            'descricao' => 'required|min:5',
            'quantidade' => 'required|integer|min:1',
            'categoria_id' => 'required|exists:categorias,id',
            'imagem' => 'required|image|max:2048',
            'preco' => 'required|numeric|min:0',
        ];
    }
    protected function messages()
    {
        return [
            'nome.required' => 'O nome do produto é obrigatório.',
            'descricao.required' => 'A descrição do produto é obrigatória.',
            'quantidade.required' => 'A quantidade do produto é obrigatória.',
            'quantidade.integer' => 'A quantidade do produto deve ser um número inteiro.',
            'quantidade.min' => 'A quantidade do produto deve ser pelo menos 1.',
            'categoria_id.required' => 'A categoria do produto é obrigatória.',
            'imagem.required' => 'A imagem do produto é obrigatória.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.max' => 'A imagem não pode ser maior que 2MB.',
            'preco.required' => 'O preço do produto é obrigatório.',
            'preco.numeric' => 'O preço do produto deve ser um número.',
            'preco.min' => 'O preço do produto não pode ser negativo.',

        ];
    }
    public function abrirDialogProduto()
    {
        $this->isOpenDialogProduto = true;
    }
    public function fecharDialogProduto()
    {
        $this->isOpenDialogProduto = false;
    }
    public function adicionarProduto()
    {
        try {
            $this->validate();
            $produto = [
                'nome' => $this->nome,
                'descricao' => $this->descricao,
                'quantidade' => $this->quantidade,
                'categoria_id' => $this->categoria_id,
                'imagem' => $this->imagem->store('produtos', 'public'),
                'preco' => $this->preco,
            ];
            // Lógica para adicionar o produto
            $this->dispatch('produto_adicionado', produto: $produto);
            $this->fecharDialogProduto();
            session()->flash('success', 'Produto adicionado com sucesso!');
        } catch (\Throwable $th) {
            session()->flash('error', 'Erro ao adicionar o produto: ' . $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.dialog-adicionar-produto');
    }
}
