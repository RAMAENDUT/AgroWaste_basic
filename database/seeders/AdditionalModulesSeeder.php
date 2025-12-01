<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdditionalModulesSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            [
                'title' => 'Biogas dari Limbah Organik',
                'slug' => 'biogas-limbah-organik',
                'description' => 'Membuat biogas untuk kebutuhan energi rumah tangga',
                'content' => 'Panduan lengkap pembuatan biogas dari limbah organik.',
                'order' => 4,
                'duration_minutes' => 75,
                'level' => 'lanjutan',
                'thumbnail' => 'https://images.unsplash.com/photo-1497436072909-60f360e1d4b1?w=600&h=400&fit=crop',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pupuk Cair Organik',
                'slug' => 'pupuk-cair-organik',
                'description' => 'Fermentasi limbah untuk pupuk cair berkualitas',
                'content' => 'Proses pembuatan pupuk cair organik dari limbah pertanian.',
                'order' => 5,
                'duration_minutes' => 55,
                'level' => 'menengah',
                'thumbnail' => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=600&h=400&fit=crop',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Manajemen Limbah Terintegrasi',
                'slug' => 'manajemen-limbah-terintegrasi',
                'description' => 'Sistem pengelolaan limbah pertanian secara menyeluruh',
                'content' => 'Strategi pengelolaan limbah terintegrasi untuk efisiensi maksimal.',
                'order' => 6,
                'duration_minutes' => 90,
                'level' => 'lanjutan',
                'thumbnail' => 'https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=600&h=400&fit=crop',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Check if modules already exist
        foreach ($modules as $module) {
            if (!DB::table('modules')->where('slug', $module['slug'])->exists()) {
                DB::table('modules')->insert($module);
            }
        }
    }
}
