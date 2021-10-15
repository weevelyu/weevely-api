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
        $this->seedCalendars(DB::table('calendars'));
        $this->attachUsers();
        // $this->seedEvents(DB::table('events'));
    }

    protected function seedUsers($users)
    {
        $users->insert([
            'name' => "PAXANDDOS",
            'email' => "pashalitovka" . '@gmail.com',
            'role' => "admin",
            'password' => Hash::make("paxanddos"),
            'image' => "https://d3djy7pad2souj.cloudfront.net/weevely/avatar1_weevely_H265P.png",
            'shareId' => 'moonlight0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $users->insert([
            'name' => "VeyronRaze",
            'email' => "veyronraze" . '@gmail.com',
            'password' => Hash::make("paxanddos"),
            'image' => "https://d3djy7pad2souj.cloudfront.net/weevely/avatar3_weevely_H265P.png",
            'shareId' => 'moonlight1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $users->insert([
            'name' => "Gazaris",
            'email' => "afterlife.limbo" . '@gmail.com',
            'password' => Hash::make("paxanddos"),
            'image' => "https://d3djy7pad2souj.cloudfront.net/weevely/avatar5_weevely_H265P.png",
            'shareId' => 'deltarune0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $users->insert([
            'name' => "Naztar",
            'email' => "nazar.taran.id" . '@gmail.com',
            'password' => Hash::make("paxanddos"),
            'image' => "https://d3djy7pad2souj.cloudfront.net/weevely/avatar4_weevely_H265P.png",
            'shareId' => 'teenspirit',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $users->insert([
            'name' => "Overwolf94",
            'email' => "ytisnewlife" . '@gmail.com',
            'password' => Hash::make("paxanddos"),
            'image' => "https://d3djy7pad2souj.cloudfront.net/weevely/avatar2_weevely_H265P.png",
            'shareId' => 'awoowers94',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    protected function seedCalendars($calendars)
    {
        $calendars->insert([
            'title' => "My calendar",
            'main' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $calendars->insert([
            'title' => "My calendar",
            'main' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $calendars->insert([
            'title' => "My calendar",
            'main' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $calendars->insert([
            'title' => "My calendar",
            'main' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $calendars->insert([
            'title' => "My calendar",
            'main' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $calendars->insert([
            'title' => "PXDD calendar",
            'shared' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    protected function attachUsers()
    {
        \App\Models\Calendar::find(1)->users()->attach(1, ['is_owner' => true]);
        \App\Models\Calendar::find(2)->users()->attach(2, ['is_owner' => true]);
        \App\Models\Calendar::find(3)->users()->attach(3, ['is_owner' => true]);
        \App\Models\Calendar::find(4)->users()->attach(4, ['is_owner' => true]);
        \App\Models\Calendar::find(5)->users()->attach(5, ['is_owner' => true]);

        \App\Models\Calendar::find(6)->users()->attach(1, ['is_owner' => true]);
        \App\Models\Calendar::find(6)->users()->attach(2);
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
