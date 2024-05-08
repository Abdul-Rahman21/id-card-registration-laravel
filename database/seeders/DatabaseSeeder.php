<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $json_data = File::get('database/json/standards.json');
        $data = collect(json_decode($json_data));

        foreach($data as $value)
        {
            // print_r($value);
            DB::table('standards')->insert([
                'standard' => $value->standard,
                'organisation_type' => $value->organisation_type,
            ]);

        }

        $json_data = File::get('database/json/sections.json');
        $data = collect(json_decode($json_data));

        foreach($data as $value)
        {
            DB::table('sections')->insert([
                'sections' => $value->sections,
                'organisation_type' => $value->organisation_type,
            ]);

        }
    }
}
