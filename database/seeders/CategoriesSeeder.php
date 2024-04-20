<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesParent = [
            [
                'name' => 'Actualités',
                'subCategories' => [
                    [
                        'name' => 'Politique'
                    ],
                    [
                        'name' => 'Économie'
                    ],
                    [
                        'name' => 'Sport'
                    ]
                ]
            ],
            [
                'name' => 'Divertissement',
                'subCategories' => [
                    [
                        'name' => 'Cinéma'
                    ],
                    [
                        'name' => 'Musique'
                    ],
                    [
                        'name' => 'Sorties'
                    ]
                ]
            ],
            [
                'name' => 'Technologie',
                'subCategories' => [
                    [
                        'name' => 'Informatique',
                        'subCategories' => [
                            [
                                'name' => 'Ordinateurs de bureau'
                            ],
                            [
                                'name' => 'PC portable'
                            ],
                            [
                                'name' => 'Connexion internet'
                            ]
                        ]
                    ],
                    [
                        'name' => 'Gadgets',
                        'subCategories' => [
                            [
                                'name' => 'Smartphones'
                            ],
                            [
                                'name' => 'Tablettes'
                            ],
                            [
                                'name' => 'Jeux vidéo'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Santé',
                'subCategories' => [
                    [
                        'name' => 'Médecine'
                    ],
                    [
                        'name' => 'Bien-être'
                    ]
                ]
            ]
        ];

        foreach ($categoriesParent as $category) {
            $parentCategory = Category::create([
                'name' => $category['name'],
            ]);

            if (isset($category['subCategories'])) {
                foreach ($category['subCategories'] as $subcategory) {
                    Category::create([
                        'name' => $subcategory['name'],
                        'parent_id' => $parentCategory->id,
                    ]);
                }
            }
        }

    }
}
