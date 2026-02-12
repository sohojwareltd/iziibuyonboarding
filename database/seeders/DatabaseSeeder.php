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
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            CountrySeeder::class,
            AcquirerMasterSeeder::class,
            PaymentMethodMasterSeeder::class,
            SolutionMasterSeeder::class,
            PriceListMasterSeeder::class,
            KYCFieldMasterSeeder::class,
            DocumentTypesMasterSeeder::class,
            PartnerSeeder::class,
            OnboardingSeeder::class,
            
        ]);
    }
}
