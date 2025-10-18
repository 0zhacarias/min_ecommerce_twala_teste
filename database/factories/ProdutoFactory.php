<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => 'Item '.$this->faker->randomNumber(1,20),
            'descricao' => $this->faker->sentence(),
            'preco' => $this->faker->randomFloat(2, 1, 1000),
            'quantidade' => $this->faker->numberBetween(0, 100),
            'imagem' => $this->faker->randomElement([
               'imagens/produtos/produto'.$this->faker->numberBetween(1,5).'.jpg',
                null,
            ]),
            'categoria_id' => Categoria::factory()->count(5),
        ];
    }
}
