<?php

namespace Database\Seeders;

use App\Models\SolutionMaster;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SolutionMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $solutions = [
            [
                'name' => 'Elavon Card Present POS - NL',
                'category_id' => Category::where('slug', 'pop')->first()->id ?? 1,
                'status' => 'published',
                'description' => 'Card present point-of-sale solution for Netherlands',
                'country' => 'nl',
                'tags' => ['pos', 'card-present', 'retail'],
                'acquirers' => ['elavon'],
                'payment_methods' => ['visa', 'mastercard', 'maestro'],
                'alternative_methods' => ['contactless'],
                'requirements' => 'Requires compatible POS terminal and merchant onboarding approval.',
                'pricing_plan' => 'custom',
            ],
            [
                'name' => 'E-com Global',
                'category_id' => Category::where('slug', 'e-commerce')->first()->id ?? 2,
                'status' => 'published',
                'description' => 'Global e-commerce payment solution with multi-currency support',
                'country' => null,
                'tags' => ['ecommerce', 'multi-currency', 'global'],
                'acquirers' => ['elavon', 'adyen'],
                'payment_methods' => ['visa', 'mastercard', 'amex'],
                'alternative_methods' => ['klarna', 'paypal'],
                'requirements' => 'Requires PCI compliance and valid business registration.',
                'pricing_plan' => 'tiered',
            ],
            [
                'name' => 'Mobile App Payment',
                'category_id' => Category::where('slug', 'mobile-app')->first()->id ?? 3,
                'status' => 'published',
                'description' => 'Mobile application payment integration',
                'country' => 'uk',
                'tags' => ['mobile', 'app', 'payments'],
                'acquirers' => ['worldpay'],
                'payment_methods' => ['visa', 'mastercard'],
                'alternative_methods' => ['apple-pay', 'google-pay'],
                'requirements' => 'Requires mobile SDK integration and app store approval.',
                'pricing_plan' => 'standard',
            ],
            [
                'name' => 'Marketplace Connect',
                'category_id' => Category::where('slug', 'marketplace')->first()->id ?? 4,
                'status' => 'published',
                'description' => 'Marketplace payment distribution system',
                'country' => null,
                'tags' => ['marketplace', 'distribution', 'multi-vendor'],
                'acquirers' => ['stripe'],
                'payment_methods' => ['visa', 'mastercard'],
                'alternative_methods' => ['sepa-transfer'],
                'requirements' => 'Requires marketplace KYC verification for sub-merchants.',
                'pricing_plan' => 'enterprise',
            ],
        ];

        foreach ($solutions as $solution) {
            SolutionMaster::create([
                'name' => $solution['name'],
                'slug' => Str::slug($solution['name']),
                'category_id' => $solution['category_id'],
                'status' => $solution['status'],
                'description' => $solution['description'],
                'country' => $solution['country'],
                'tags' => $solution['tags'],
                'acquirers' => $solution['acquirers'],
                'payment_methods' => $solution['payment_methods'],
                'alternative_methods' => $solution['alternative_methods'],
                'requirements' => $solution['requirements'],
                'pricing_plan' => $solution['pricing_plan'],
            ]);
        }
    }
}
