<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'My Application',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Site Name'
            ],
            [
                'key' => 'site_email',
                'value' => 'admin@example.com',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Site Email'
            ],
            [
                'key' => 'site_description',
                'value' => 'A powerful application built with Laravel',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Site Description'
            ],
            [
                'key' => 'license_key',
                'value' => 'DEMO-LICENSE-KEY',
                'type' => 'string',
                'group' => 'license',
                'description' => 'License Key'
            ],
            [
                'key' => 'license_status',
                'value' => 'active',
                'type' => 'string',
                'group' => 'license',
                'description' => 'License Status'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
} 