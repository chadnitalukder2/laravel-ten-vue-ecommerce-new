<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $client = new Client();
        $response = $client->request('GET', 'https://api.unsplash.com/photos/random', [
            'query' => [
                'query' => 'product',
                'client_id' => 'C-2uwpLuPXX4sI1FHEuV2HPN4PzLQr-TiSYh4juntJM', // Replace with your Unsplash access key
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        $productImage = $data['urls']['regular'];


        $colors = $this->faker->randomElements(['Red', 'Blue', 'Green', 'Yellow', 'Black', 'White'], $this->faker->numberBetween(1, 3));
        $sizes = $this->faker->randomElements(['Small', 'Medium', 'Large', 'XL'], $this->faker->numberBetween(1, 4));
        
        $colorsString = json_encode($colors);
        $sizesString = json_encode($sizes);
    
        return [
            'product_name' => $this->faker->word,
            'product_price' => $this->faker->randomFloat(100, 2000),
            'product_quantity' => $this->faker->numberBetween(1, 100),
            'brand_id' =>Brand::factory(),
            'category_id' => Category::factory(), 
            'product_img' => $productImage,
            'product_colors' => $colorsString,
            'product_sizes' => $sizesString,
            'short_description' => $this->faker->paragraph,
            'product_details' => $this->faker->paragraph,
        ];
    }
}
