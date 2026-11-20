<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use App\Models\Student;
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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $sekolah = School::factory(7)->create();
        
        // Student::factory(75)->state(fn () => ['sekolah_id' => $sekolah->random()->id])->create();
    }
}
