<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PartnerSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            'Partner One',
            'Partner Two',
            'Partner Three',
            'Partner Four',
        ];

        foreach ($partners as $partner) {
            Partner::create([
                'title' => $partner,
                'slug' => Str::slug($partner),
            ]);
        }
    }
}
