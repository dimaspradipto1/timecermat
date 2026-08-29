<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Sample Schools matching the contest
        \App\Models\Schools::truncate();
        \App\Models\Schools::create([
            'name' => 'SMA NEGERI 1 BATAM',
            'regu' => 'Regu A',
            'score' => 10,
            'slot' => 1,
            'is_active' => true,
        ]);

        \App\Models\Schools::create([
            'name' => 'SMA NEGERI 3 BATAM',
            'regu' => 'Regu B',
            'score' => 0,
            'slot' => 2,
            'is_active' => true,
        ]);

        \App\Models\Schools::create([
            'name' => 'SMK NEGERI 1 BATAM',
            'regu' => 'Regu C',
            'score' => 0,
            'slot' => 3,
            'is_active' => true,
        ]);

        \App\Models\Schools::create([
            'name' => 'SMA KARTINI BATAM',
            'regu' => 'Regu D',
            'score' => 0,
            'slot' => null,
            'is_active' => true,
        ]);

        \App\Models\Schools::create([
            'name' => 'MAN 1 BATAM',
            'regu' => 'Regu E',
            'score' => 0,
            'slot' => null,
            'is_active' => true,
        ]);

        // Default Game Settings
        \App\Models\GameSetting::set('timer_duration', '15');
        \App\Models\GameSetting::set('timer_remaining', '15');
        \App\Models\GameSetting::set('timer_status', 'stopped');
        \App\Models\GameSetting::set('timer_end_timestamp', '0');
    }
}
