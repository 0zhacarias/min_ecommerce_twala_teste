<?php

namespace Database\Factories;

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
            'nome' => $this->faker->word(),
            'descricao' => $this->faker->sentence(),
            'preco' => $this->faker->randomFloat(2, 1, 1000),
            'estoque' => $this->faker->numberBetween(0, 100),
            'imagem' => $this->faker->randomElement([
               'imagens/produto'.$this->faker->numberBetween(1,20).'.jpg',
                null,
            ]),
            'categoria_id' => Categoria::factory(),
        ];
    }
}
