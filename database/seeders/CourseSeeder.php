<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Pengenalan Komposting dari Limbah Pertanian',
                'slug' => 'pengenalan-komposting-dari-limbah-pertanian',
                'description' => 'Pelajari cara membuat kompos berkualitas dari limbah pertanian untuk meningkatkan kesuburan tanah.',
                'thumbnail' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=600&h=400&fit=crop',
                'level' => 'pemula',
                'duration_minutes' => 240,
                'display_order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Produksi Biogas dari Limbah Organik',
                'slug' => 'produksi-biogas-dari-limbah-organik',
                'description' => 'Panduan lengkap membuat biogas dari limbah organik untuk energi terbarukan.',
                'thumbnail' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=600&h=400&fit=crop',
                'level' => 'menengah',
                'duration_minutes' => 360,
                'display_order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Budidaya Black Soldier Fly (BSF)',
                'slug' => 'budidaya-black-soldier-fly-bsf',
                'description' => 'Teknik budidaya BSF untuk mengolah limbah organik menjadi pakan ternak dan pupuk.',
                'thumbnail' => 'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=600&h=400&fit=crop',
                'level' => 'menengah',
                'duration_minutes' => 300,
                'display_order' => 3,
                'is_published' => true,
            ],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(
                ['slug' => $course['slug']],
                $course
            );
        }
    }
}
