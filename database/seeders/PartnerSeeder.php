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
            ['title' => 'Partner One', 'commission_plan' => 'Standard', 'status' => 'active', 'referral_id' => 'REF001'],
            ['title' => 'Partner Two', 'commission_plan' => 'Premium', 'status' => 'active', 'referral_id' => 'REF002'],
            ['title' => 'Partner Three', 'commission_plan' => 'Enterprise', 'status' => 'inactive', 'referral_id' => 'REF003'],
            ['title' => 'Partner Four', 'commission_plan' => 'Standard', 'status' => 'active', 'referral_id' => 'REF004'],
        ];

        foreach ($partners as $partner) {
            Partner::create([
                'title' => $partner['title'],
                'slug' => Str::slug($partner['title']),
                'commission_plan' => $partner['commission_plan'],
                'status' => $partner['status'],
                'referral_id' => $partner['referral_id'],
            ]);
        }
    }
}
