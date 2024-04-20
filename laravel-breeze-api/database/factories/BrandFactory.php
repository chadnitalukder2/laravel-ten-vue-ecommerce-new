<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use GuzzleHttp\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
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
                'query' => 'electronics',
                'client_id' => 'C-2uwpLuPXX4sI1FHEuV2HPN4PzLQr-TiSYh4juntJM', // Replace with your Unsplash access key
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        $productImage = $data['urls']['regular'];

        return [
            'brand_name' => fake()->name(),
            'brand_img' => $productImage,
        ];
    }
}