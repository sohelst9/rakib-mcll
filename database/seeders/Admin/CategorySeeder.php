<?php

namespace Database\Seeders\Admin;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create game categories --
        $categories = [
            [
                'name' => 'Action',
                'description' => 'Fast-paced and exciting games.'
            ],
            [
                'name' => 'Adventure',
                'description' => 'Explore new worlds and discover hidden secrets.'
            ],
            [
                'name' => 'Puzzle',
                'description' => 'Challenge your brain and solve complex problems.'
            ],
            [
                'name' => 'Strategy',
                'description' => 'Plan and execute your moves to achieve victory.'
            ],
            [
                'name' => 'Sports',
                'description' => 'Compete in various sports and tournaments.'
            ],
            [
                'name' => 'Racing',
                'description' => 'Speed and adrenaline, get ready to race'
            ],
            [
                'name' => 'Arcade',
                'description' => 'Classic games with simple yet addictive gameplay.'
            ],
            [
                'name' => 'Simulation',
                'description' => 'Realistic simulations of real-life activities.'
            ],
            [
                'name' => 'Multiplayer',
                'description' => 'Play with friends and other players online'
            ]
        ];

        //-- add slug field to each category using array map

        $categories = array_map(function($category){
            $category['slug'] = Str::slug($category['name']);
            $category['created_at'] = Carbon::now();
            $category['updated_at'] = Carbon::now();
            return $category;
        }, $categories);

        DB::table('categories')->insert($categories);
    }
}
