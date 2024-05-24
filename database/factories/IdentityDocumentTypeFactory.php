<?php

namespace Database\Factories;

use App\Models\IdentityDocumentType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IdendityDocumentType>
 */
class IdentityDocumentTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = IdentityDocumentType::class;
    public function definition()
    {
        return [
            //
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'slug' => Str::uuid()
        ];
    }
}
