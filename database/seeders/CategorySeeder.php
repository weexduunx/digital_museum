<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Peinture Traditionnelle',
                'description' => 'Œuvres de peinture traditionnelle sénégalaise et africaine',
                'color' => '#ef4444',
            ],
            [
                'name' => 'Sculpture',
                'description' => 'Sculptures en bois, bronze et autres matériaux',
                'color' => '#3b82f6',
            ],
            [
                'name' => 'Art Contemporain',
                'description' => 'Créations artistiques contemporaines',
                'color' => '#10b981',
            ],
            [
                'name' => 'Photographie',
                'description' => 'Photographies artistiques et documentaires',
                'color' => '#f59e0b',
            ],
            [
                'name' => 'Artisanat',
                'description' => 'Objets d\'artisanat traditionnel et moderne',
                'color' => '#8b5cf6',
            ],
            [
                'name' => 'Textile',
                'description' => 'Tissus, vêtements et créations textiles',
                'color' => '#ec4899',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
