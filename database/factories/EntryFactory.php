<?php

namespace Database\Factories;

use App\Models\Entry;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntryFactory extends Factory
{
    protected $model = Entry::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'body' => $this->faker->paragraph(3),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }

    
}
