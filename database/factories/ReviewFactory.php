<?php

namespace Database\Factories\Dealskoo\Review\Models;

use Dealskoo\Country\Models\Country;
use Dealskoo\Review\Models\Review;
use Dealskoo\Seller\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->unique()->slug,
            'title' => $this->faker->title,
            'cover' => $this->faker->imageUrl,
            'content' => $this->faker->text,
            'published_at' => null,
            'approved' => $this->faker->boolean,
            'can_comment' => $this->faker->boolean,
            'views' => $this->faker->numberBetween(0, 1000),
            'country_id' => Country::factory()->create(),
            'seller_id' => Seller::factory()->create(),
        ];
    }

    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => $this->faker->dateTime,
            ];
        });
    }

    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'approved' => true,
            ];
        });
    }
}
