<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'phone' => '01700000000',
                'password' => 'password',
                'isAdmin' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'phone' => '01800000000',
                'password' => 'password',
                'isAdmin' => false,
            ]
        );

        $services = [
            [
                'title' => 'Commercial CCTV System',
                'image_url' => '/site/img/icon/icon-6.png',
                'description' => 'Reliable CCTV setup and monitoring for offices and commercial spaces.',
            ],
            [
                'title' => 'Finger Print Access',
                'image_url' => '/site/img/icon/icon-8.png',
                'description' => 'Biometric access control for secure entry management.',
            ],
            [
                'title' => 'Fire Detection And Safety',
                'image_url' => '/site/img/icon/icon-9.png',
                'description' => 'Early warning systems for fire detection and emergency safety.',
            ],
            [
                'title' => 'Smart Home Security',
                'image_url' => '/site/img/icon/icon-3.png',
                'description' => 'Modern smart security solutions for homes and apartments.',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['title' => $service['title']],
                $service + ['isActive' => true]
            );
        }
    }
}
