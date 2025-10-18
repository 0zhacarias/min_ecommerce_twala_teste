<?php

namespace App\Livewire;

use App\Services\EncomendaService;
use Livewire\Attributes\On;
use Livewire\Component;

class DialogEncomenda extends Component
{
    
    public $isOpenDialogEncomenda = false;
    public $endereco = '';
    public $metodo_pagamento = '';
    public $observacoes = '';

    #[On('abrir-dialog-encomenda')]
    public function abrirDialogEncomenda()
    {
        //dd(3);
        $this->isOpenDialogEncomenda = true;
    }

    public function fecharDialogEncomenda()
    {
        $this->isOpenDialogEncomenda = false;
        $this->reset(['endereco', 'metodo_pagamento', 'observacoes']);
    }

    public function confirmarEncomenda(EncomendaService $encomendaService)
    {
        $carrinho=session()->get('carrinho', []);
        //dd($carrinho);
        // Validação básica
        $this->validate([
            'endereco' => 'required|min:10',
            'metodo_pagamento' => 'required',
        ], [
            'endereco.required' => 'O endereço é obrigatório.',
            'endereco.min' => 'O endereço deve ter pelo menos 10 caracteres.',
            'metodo_pagamento.required' => 'Selecione um método de pagamento.',
        ]);

        $dados=[
            "items"=>$carrinho,
            "endereco"=>$this->endereco,
            "metodo_pagamento"=>$this->metodo_pagamento,
            "observacoes"=>$this->observacoes
        ];
        // Aqui você pode processar a encomenda
        // Salvar no banco de dados, enviar email, etc.
        $encomendaService->processarEncomenda($dados);
        // Simular processamento
        sleep(2);

        // Limpar carrinho após confirmação
        session()->forget('carrinho');
        
        // Fechar dialog
        
        // Atualizar contagem do carrinho
        
        // Fechar carrinho
        session()->flash('success', 'Encomenda realizada com sucesso! Entraremos em contato em breve.');
        $this->fecharDialogEncomenda();
        $this->dispatch('contar-carrinho');
        $this->dispatch('fechar-carrinho');
        
        // Mensagem de sucesso
    }

    public function render()
    {
        return view('livewire.dialog-encomenda');
    }
}
