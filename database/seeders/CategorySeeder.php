<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(Storage::get('categories.json'));

        foreach ($data as $item) {
            Category::create(
                [
                    'name' => $item->name,
                    'description' => $item->description,
                ]
            );
        }

        //
    }
}
