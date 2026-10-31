<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'phone' => '01700000000',
                'password' => 'password',
                'isAdmin' => true,
                'email_verified_at' => now(),
            ]
        );

        $testUser = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'phone' => '01800000000',
                'password' => 'password',
                'isAdmin' => false,
                'email_verified_at' => now(),
            ]
        );

        $sakib = User::updateOrCreate(
            ['email' => 'sakib@example.com'],
            [
                'name' => 'Nazmus Sakib',
                'phone' => '01711223344',
                'password' => 'password',
                'isAdmin' => false,
                'email_verified_at' => now(),
            ]
        );

        $tahsin = User::updateOrCreate(
            ['email' => 'tahsin@example.com'],
            [
                'name' => 'Tahsin Ahmed',
                'phone' => '01811223344',
                'password' => 'password',
                'isAdmin' => false,
                'email_verified_at' => now(),
            ]
        );

        $anika = User::updateOrCreate(
            ['email' => 'anika@example.com'],
            [
                'name' => 'Anika Tabassum',
                'phone' => '01911223344',
                'password' => 'password',
                'isAdmin' => false,
                'email_verified_at' => now(),
            ]
        );

        $corporate = User::updateOrCreate(
            ['email' => 'corporate@bankbd.com'],
            [
                'name' => 'City Bank Operations',
                'phone' => '01611223344',
                'password' => 'password',
                'isAdmin' => false,
                'email_verified_at' => now(),
            ]
        );

        $kamrul = User::updateOrCreate(
            ['email' => 'kamrul@techbd.com'],
            [
                'name' => 'Kamrul Hasan',
                'phone' => '01511223344',
                'password' => 'password',
                'isAdmin' => false,
                'email_verified_at' => now(),
            ]
        );

        // 2. Services
        $servicesData = [
            [
                'title' => 'Commercial CCTV System',
                'image_url' => '/site/img/icon/icon-6.png',
                'description' => 'Reliable CCTV setup and monitoring for offices, retail stores and commercial spaces.',
                'price' => 250.00,
                'isActive' => true,
            ],
            [
                'title' => 'Finger Print Access',
                'image_url' => '/site/img/icon/icon-8.png',
                'description' => 'Biometric access control for secure corporate entry management and door security.',
                'price' => 180.00,
                'isActive' => true,
            ],
            [
                'title' => 'Fire Detection And Safety',
                'image_url' => '/site/img/icon/icon-9.png',
                'description' => 'Early warning smoke, heat and fire detection systems with emergency alarm sirens.',
                'price' => 300.00,
                'isActive' => true,
            ],
            [
                'title' => 'Smart Home Security',
                'image_url' => '/site/img/icon/icon-3.png',
                'description' => 'Modern wireless security cameras, smart sensors and mobile app control for homes.',
                'price' => 220.00,
                'isActive' => true,
            ],
            [
                'title' => 'IP Camera & Cloud Surveillance',
                'image_url' => '/site/img/icon/icon-1.png',
                'description' => 'High definition IP cameras with night vision and 30-day cloud video retention.',
                'price' => 150.00,
                'isActive' => true,
            ],
            [
                'title' => '24/7 Central Alarm Monitoring',
                'image_url' => '/site/img/icon/icon-2.png',
                'description' => 'Continuous remote alarm monitoring with instant emergency team response.',
                'price' => 350.00,
                'isActive' => true,
            ],
            [
                'title' => 'Biometric Attendance System',
                'image_url' => '/site/img/icon/icon-7.png',
                'description' => 'Integrated employee time tracking, payroll sync and biometric attendance hardware.',
                'price' => 190.00,
                'isActive' => true,
            ],
            [
                'title' => 'Perimeter Laser Security',
                'image_url' => '/site/img/icon/icon-4.png',
                'description' => 'Outdoor laser beam perimeter detectors preventing unauthorized property intrusion.',
                'price' => 400.00,
                'isActive' => true,
            ],
        ];

        $services = [];
        foreach ($servicesData as $serviceItem) {
            $services[$serviceItem['title']] = Service::updateOrCreate(
                ['title' => $serviceItem['title']],
                $serviceItem
            );
        }

        // 3. Bookings
        $bookingsData = [
            // Pending Requests (Test Accept / Reject)
            [
                'user' => $testUser,
                'service' => $services['Commercial CCTV System'],
                'booking_date' => Carbon::now()->addDays(1)->toDateString(),
                'time_slot' => '09:00 AM',
                'status' => 'pending',
                'message' => 'Need full site inspection before installing 8 cameras in our main office.',
            ],
            [
                'user' => $sakib,
                'service' => $services['Finger Print Access'],
                'booking_date' => Carbon::now()->addDays(2)->toDateString(),
                'time_slot' => '11:00 AM',
                'status' => 'pending',
                'message' => 'Need 2 biometric door locks for executive rooms and server room.',
            ],
            [
                'user' => $tahsin,
                'service' => $services['Smart Home Security'],
                'booking_date' => Carbon::now()->addDays(3)->toDateString(),
                'time_slot' => '01:00 PM',
                'status' => 'pending',
                'message' => 'Want smart motion sensors and 4 wireless cameras installed in our apartment.',
            ],
            [
                'user' => $corporate,
                'service' => $services['24/7 Central Alarm Monitoring'],
                'booking_date' => Carbon::now()->addDays(4)->toDateString(),
                'time_slot' => '03:00 PM',
                'status' => 'pending',
                'message' => 'Bank branch ATM booth security alarm setup and central control integration.',
            ],
            // Accepted Bookings (Test Complete)
            [
                'user' => $testUser,
                'service' => $services['Fire Detection And Safety'],
                'booking_date' => Carbon::now()->addDays(5)->toDateString(),
                'time_slot' => '09:00 AM',
                'status' => 'accepted',
                'message' => 'Factory smoke sensors and fire alarm control panel setup.',
            ],
            [
                'user' => $anika,
                'service' => $services['IP Camera & Cloud Surveillance'],
                'booking_date' => Carbon::now()->addDays(6)->toDateString(),
                'time_slot' => '11:00 AM',
                'status' => 'accepted',
                'message' => 'Need outdoor night-vision IP cameras setup for duplex residence.',
            ],
            [
                'user' => $kamrul,
                'service' => $services['Biometric Attendance System'],
                'booking_date' => Carbon::now()->addDays(7)->toDateString(),
                'time_slot' => '01:00 PM',
                'status' => 'accepted',
                'message' => 'Installation for 60 staff members with exportable attendance reports.',
            ],
            // Completed Bookings (Test Invoices and completed stats)
            [
                'user' => $testUser,
                'service' => $services['Smart Home Security'],
                'booking_date' => Carbon::now()->subDays(2)->toDateString(),
                'time_slot' => '03:00 PM',
                'status' => 'completed',
                'message' => 'Installation completed, verified all camera feeds and mobile app.',
            ],
            [
                'user' => $corporate,
                'service' => $services['Commercial CCTV System'],
                'booking_date' => Carbon::now()->subDays(5)->toDateString(),
                'time_slot' => '05:00 PM',
                'status' => 'completed',
                'message' => 'Headquarters security control room monitors and 32 cameras deployed.',
            ],
            [
                'user' => $anika,
                'service' => $services['Finger Print Access'],
                'booking_date' => Carbon::now()->subDays(8)->toDateString(),
                'time_slot' => '09:00 AM',
                'status' => 'completed',
                'message' => 'Biometric locks configured with master card and fingerprint enrollment.',
            ],
            // Rejected and Canceled Bookings
            [
                'user' => $sakib,
                'service' => $services['Perimeter Laser Security'],
                'booking_date' => Carbon::now()->subDays(3)->toDateString(),
                'time_slot' => '11:00 AM',
                'status' => 'rejected',
                'message' => 'Client location outside current operational boundary.',
            ],
            [
                'user' => $testUser,
                'service' => $services['IP Camera & Cloud Surveillance'],
                'booking_date' => Carbon::now()->addDays(10)->toDateString(),
                'time_slot' => '05:00 PM',
                'status' => 'canceled',
                'message' => 'Rescheduled due to building renovation.',
            ],
        ];

        foreach ($bookingsData as $b) {
            Booking::updateOrCreate(
                [
                    'user_id' => $b['user']->id,
                    'service_id' => $b['service']->id,
                    'booking_date' => $b['booking_date'],
                    'time_slot' => $b['time_slot'],
                ],
                [
                    'name' => $b['user']->name,
                    'email' => $b['user']->email,
                    'service_price' => $b['service']->price,
                    'status' => $b['status'],
                    'message' => $b['message'],
                ]
            );
        }

        // 4. Contact Messages / Quote Inquiries
        $messagesData = [
            [
                'name' => 'Rahim Chowdhury',
                'email' => 'rahim@northwest.com',
                'phone' => '01755123456',
                'service_id' => $services['Commercial CCTV System']->id,
                'message' => 'We require 16 IP cameras for our logistics warehouse in Uttara. Please provide a formal price quotation and inspection date.',
                'is_read' => false,
            ],
            [
                'name' => 'Farhana Yasmin',
                'email' => 'farhana@schoolbd.edu',
                'phone' => '01822987654',
                'service_id' => $services['Fire Detection And Safety']->id,
                'message' => 'Urgent fire alarm inspection and certification needed for our English medium campus before school reopens.',
                'is_read' => false,
            ],
            [
                'name' => 'Kamrul Hasan',
                'email' => 'kamrul@techbd.com',
                'phone' => '01933456789',
                'service_id' => $services['Biometric Attendance System']->id,
                'message' => 'Need fingerprint attendance machine connected with our HR payroll software for 120 employees.',
                'is_read' => true,
            ],
            [
                'name' => 'Nusrat Jahan',
                'email' => 'nusrat@homebd.net',
                'phone' => '01644123987',
                'service_id' => $services['Smart Home Security']->id,
                'message' => 'Looking for smart doorbell with two-way audio and 4 outdoor cameras for our residence in Dhanmondi.',
                'is_read' => false,
            ],
            [
                'name' => 'Ashiqur Rahman',
                'email' => 'ashiq@corpfin.com',
                'phone' => '01799001122',
                'service_id' => $services['24/7 Central Alarm Monitoring']->id,
                'message' => 'We want to connect 3 corporate branch security alarms with your 24/7 central rapid response dispatch team.',
                'is_read' => true,
            ],
        ];

        foreach ($messagesData as $msg) {
            ContactMessage::updateOrCreate(
                [
                    'email' => $msg['email'],
                    'subject' => $msg['phone'],
                ],
                [
                    'name' => $msg['name'],
                    'service_id' => $msg['service_id'],
                    'message' => $msg['message'],
                    'is_read' => $msg['is_read'],
                ]
            );
        }
    }
}
