<?php

namespace Database\Seeders;

use App\Models\Listing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 3; $i++)
        {
            Listing::create([
                'title' => "Listing#" . $i,
                'location' => 'Bud ' . $i,
                'price' => 2000 * $i,
                'published' => false,
                'accepted' => false
            ]);
        }
    }
}
