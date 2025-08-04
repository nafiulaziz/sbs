<?php
// database/seeders/ServiceSeeder.php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        Service::create([
            'name' => 'Website Development',
            'description' => 'Complete website development service including design and implementation.',
            'price' => 1500.00,
            'status' => 'active',
            'duration_minutes' => 120,
        ]);

        Service::create([
            'name' => 'Mobile App Development',
            'description' => 'Native and cross-platform mobile application development.',
            'price' => 2500.00,
            'status' => 'active',
            'duration_minutes' => 180,
        ]);

        Service::create([
            'name' => 'UI/UX Design',
            'description' => 'User interface and user experience design consultation.',
            'price' => 800.00,
            'status' => 'active',
            'duration_minutes' => 90,
        ]);

        Service::create([
            'name' => 'SEO Optimization',
            'description' => 'Search engine optimization for better online visibility.',
            'price' => 500.00,
            'status' => 'active',
            'duration_minutes' => 60,
        ]);

        Service::create([
            'name' => 'Digital Marketing',
            'description' => 'Comprehensive digital marketing strategy and implementation.',
            'price' => 1200.00,
            'status' => 'inactive',
            'duration_minutes' => 120,
        ]);
    }
}