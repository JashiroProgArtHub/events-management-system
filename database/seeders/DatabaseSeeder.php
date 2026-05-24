<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = Admin::create([
            'username' => 'admin',
            'email' => 'admin@saoevents.com',
            'password' => Hash::make('password123'),
            'full_name' => 'SAO Administrator',
        ]);

        // Create sample events
        $upcomingEvent = Event::create([
            'admin_id' => $admin->admin_id,
            'title' => 'Annual School Gathering',
            'description' => 'This is the annual gathering of all students and faculty. Join us for a day filled with activities, games, and community bonding.',
            'venue' => 'School Auditorium',
            'event_date' => Carbon::now()->addDays(7)->setTime(10, 0),
        ]);

        $ongoingEvent = Event::create([
            'admin_id' => $admin->admin_id,
            'title' => 'Science Fair 2024',
            'description' => 'Showcase of student research projects, experiments, and scientific innovations. Parents and community members welcome.',
            'venue' => 'School Gymnasium',
            'event_date' => Carbon::now()->setTime(9, 0),
        ]);

        $completedEvent = Event::create([
            'admin_id' => $admin->admin_id,
            'title' => 'Sports Day Finals',
            'description' => 'Competitive sporting events featuring various disciplines. Teams compete for the championship trophy.',
            'venue' => 'School Sports Field',
            'event_date' => Carbon::now()->subDays(5)->setTime(14, 0),
        ]);

        $futureEvent = Event::create([
            'admin_id' => $admin->admin_id,
            'title' => 'Cultural Night Extravaganza',
            'description' => 'Celebrate diverse cultures through music, dance, and traditional performances. Food from different countries will be served.',
            'venue' => 'School Auditorium',
            'event_date' => Carbon::now()->addDays(30)->setTime(18, 0),
        ]);

        // Add participants to upcoming event
        $participantNames = [
            'Maria Santos', 'Juan Dela Cruz', 'Ana Garcia', 'Carlos Rodriguez',
            'Sofia Martinez', 'Miguel Torres', 'Isabella Lopez', 'Diego Ramirez'
        ];

        $courses = ['BS Information Technology', 'BS Business Administration', 'BS Education', 'BS Engineering'];
        $yearLevels = ['1st Year', '2nd Year', '3rd Year', '4th Year'];

        foreach ($participantNames as $index => $name) {
            Participant::create([
                'event_id' => $upcomingEvent->event_id,
                'full_name' => $name,
                'course' => $courses[$index % count($courses)],
                'year_level' => $yearLevels[$index % count($yearLevels)],
                'email' => strtolower(str_replace(' ', '.', $name)) . '@student.sao.edu.ph',
                'contact_number' => '09' . rand(100000000, 999999999),
            ]);
        }

        // Add participants to science fair event
        $scienceParticipants = [
            'Kevin Ong', 'Patricia Cruz', 'Robert Santos', 'Lisa Wong',
            'Nathan Morales', 'Michelle Reyes', 'Andrew Castro', 'Jennifer Gomez'
        ];

        foreach ($scienceParticipants as $index => $name) {
            Participant::create([
                'event_id' => $ongoingEvent->event_id,
                'full_name' => $name,
                'course' => $courses[$index % count($courses)],
                'year_level' => $yearLevels[$index % count($yearLevels)],
                'email' => strtolower(str_replace(' ', '.', $name)) . '@student.sao.edu.ph',
                'contact_number' => '09' . rand(100000000, 999999999),
            ]);
        }

        // Add participants to completed event
        $sportsParticipants = [
            'James Foster', 'Elena Diaz', 'Mark Johnson', 'Victoria Sanchez',
            'Lucas Garcia', 'Amanda Lopez', 'Ryan Martinez', 'Sophia Perez'
        ];

        foreach ($sportsParticipants as $index => $name) {
            Participant::create([
                'event_id' => $completedEvent->event_id,
                'full_name' => $name,
                'course' => $courses[$index % count($courses)],
                'year_level' => $yearLevels[$index % count($yearLevels)],
                'email' => strtolower(str_replace(' ', '.', $name)) . '@student.sao.edu.ph',
                'contact_number' => '09' . rand(100000000, 999999999),
            ]);
        }
    }
}
