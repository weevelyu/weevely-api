<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->seedUsers(DB::table('users'));
        // $this->seedCalendars(DB::table('calendars'));
        // $this->seedEvents(DB::table('events'));
    }

    protected function seedUsers($users)
    {
        $users->insert([
            'name' => "PAXANDDOS",
            'email' => "pashalitovka" . '@gmail.com',
            'role' => "admin",
            'password' => Hash::make("paxanddos"),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $users->insert([
            'name' => "VeyronRaze",
            'email' => "veyronraze" . '@gmail.com',
            'password' => Hash::make("paxanddos"),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $users->insert([
            'name' => "Gazaris",
            'email' => "afterlife.limbo" . '@gmail.com',
            'password' => Hash::make("paxanddos"),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $users->insert([
            'rname' => "Naztar",
            'email' => "nazar.taran.id" . '@gmail.com',
            'password' => Hash::make("paxanddos"),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $users->insert([
            'name' => "Overwolf94",
            'email' => "ytisnewlife" . '@gmail.com',
            'password' => Hash::make("paxanddos"),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    protected function seedCalendars($calendars)
    {
        $calendars->insert([
            'user_id' => 2,
            'post_id' => 3,
            'content' => "Nice post"
        ]);
    }

    protected function seedEvents($events)
    {
        $events->insert([
            'user_id' => 2,
            'post_id' => 3,
            'content' => "Nice post"
        ]);
    }
}
