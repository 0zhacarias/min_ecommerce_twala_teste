<?php

namespace App\Services;

use App\Enums\EstadoEncomendaEnum;
use App\Models\Encomenda;
use App\Models\ItemEncomenda;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;

class EncomendaService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function processarEncomenda($dados)
    {

        try {
            DB::beginTransaction();

            $id_produtos = array_keys($dados['items']);
            //$produtos = Produto::whereIn('id', $id_produtos)->get()->keyBy('id');
           //  dd($dados);
            $total = 0;
            foreach ($dados['items'] as $produtoId => $item) {
                //$produto = $produtos[$produtoId];

                $total += $item['preco'] * $item['quantidade'];
            }
            $encomenda = Encomenda::create([
                'estado' => EstadoEncomendaEnum::PENDENTE->value,
                'total_preco' => $total,
                'endereco_entrega' => $dados['endereco'],
                'metodo_pagamento' => $dados['metodo_pagamento'],
                'observacoes' => $dados['observacoes'],
                'data_encomenda' => now(),
                'created_by' => auth()->id(),
            ]);

            $itens = [];
            foreach ($dados['items'] as $produtoId => $item) {
                //    $produto = $produtos[$produtoId];

                $itens[] = [
                    'encomenda_id' => $encomenda->id,
                    'produto_id' => $item['id'],
                    'nome' => $item['nome'],
                    'preco' => $item['preco'],
                    'quantidade' => $item['quantidade'],
                    'created_at' => now(),
                    'subtotal' => $item['preco'] * $item['quantidade'],
                ];
            }
            DB::table('item_encomendas')->insert($itens);
            DB::commit();
            return $encomenda;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
