<?php

namespace Database\Factories;

use App\Models\Publisher;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublisherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Publisher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker = FakerFactory::create('ja_JP');
        return [
            'name' => $this->faker->company . '出版',
            'address' => $this->faker->address,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
