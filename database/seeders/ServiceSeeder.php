<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'General Physiotherapy',
                'description' => 'Assessment and treatment for common muscle, joint and movement problems.',
            ],
            [
                'name' => 'Orthopedic Physiotherapy',
                'description' => 'Physiotherapy for bone, joint, muscle and ligament conditions.',
            ],
            [
                'name' => 'Neurological Physiotherapy',
                'description' => 'Rehabilitation to improve movement, balance and daily functioning.',
            ],
            [
                'name' => 'Sports Injury Rehabilitation',
                'description' => 'Treatment and rehabilitation for sports-related injuries.',
            ],
            [
                'name' => 'Post-Surgical Rehabilitation',
                'description' => 'Guided rehabilitation following surgery and orthopedic procedures.',
            ],
            [
                'name' => 'Pediatric Physiotherapy',
                'description' => 'Physiotherapy support for children with movement and developmental needs.',
            ],
            [
                'name' => 'Geriatric Physiotherapy',
                'description' => 'Movement, strength and balance support for older adults.',
            ],
            [
                'name' => 'Pain Management',
                'description' => 'Physiotherapy approaches to help manage pain and improve mobility.',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => Str::slug($service['name'])],
                [
                    'name' => $service['name'],
                    'description' => $service['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
