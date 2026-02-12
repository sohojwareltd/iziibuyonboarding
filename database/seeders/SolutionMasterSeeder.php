<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\SolutionMaster;
use App\Models\Category;
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
                'category_slug' => 'pop',
                'status' => 'published',
                'description' => 'Card present point-of-sale solution for Netherlands',
                'tags' => ['pos', 'card-present', 'retail'],
                'acquirers' => ['elavon'],
                'payment_methods' => ['visa', 'mastercard', 'maestro'],
                'alternative_methods' => ['contactless'],
                'requirements' => 'Requires compatible POS terminal and merchant onboarding approval.',
                'pricing_plan' => 'custom',
            ],
            [
                'name' => 'E-com Global',
                'category_slug' => 'e-commerce',
                'status' => 'published',
                'description' => 'Global e-commerce payment solution with multi-currency support',
                'tags' => ['ecommerce', 'multi-currency', 'global'],
                'acquirers' => ['elavon', 'adyen'],
                'payment_methods' => ['visa', 'mastercard', 'amex'],
                'alternative_methods' => ['klarna', 'paypal'],
                'requirements' => 'Requires PCI compliance and valid business registration.',
                'pricing_plan' => 'tiered',
            ],
            [
                'name' => 'Mobile App Payment',
                'category_slug' => 'mobile-app',
                'status' => 'published',
                'description' => 'Mobile application payment integration',
                'tags' => ['mobile', 'app', 'payments'],
                'acquirers' => ['worldpay'],
                'payment_methods' => ['visa', 'mastercard'],
                'alternative_methods' => ['apple-pay', 'google-pay'],
                'requirements' => 'Requires mobile SDK integration and app store approval.',
                'pricing_plan' => 'standard',
            ],
            [
                'name' => 'Marketplace Connect',
                'category_slug' => 'marketplace',
                'status' => 'published',
                'description' => 'Marketplace payment distribution system',
                'tags' => ['marketplace', 'distribution', 'multi-vendor'],
                'acquirers' => ['stripe'],
                'payment_methods' => ['visa', 'mastercard'],
                'alternative_methods' => ['sepa-transfer'],
                'requirements' => 'Requires marketplace KYC verification for sub-merchants.',
                'pricing_plan' => 'enterprise',
            ],
        ];

        foreach ($solutions as $solution) {
            $categoryId = Category::where('slug', $solution['category_slug'])->value('id')
                ?? Category::value('id')
                ?? 1;

            $solutionModel = SolutionMaster::updateOrCreate(
                ['slug' => Str::slug($solution['name'])],
                [
                'name' => $solution['name'],
                'category_id' => $categoryId,
                'status' => $solution['status'],
                'description' => $solution['description'],
                'tags' => $solution['tags'],
                'acquirers' => $solution['acquirers'],
                'payment_methods' => $solution['payment_methods'],
                'alternative_methods' => $solution['alternative_methods'],
                'requirements' => $solution['requirements'],
                'pricing_plan' => $solution['pricing_plan'],
                ]
            );

            $legacyCountry = $solution['country'];
            $countryCodes = is_string($legacyCountry) && $legacyCountry !== '' ? [$legacyCountry] : [];
            $normalizedCodes = collect($countryCodes)
                ->filter()
                ->map(fn ($code) => strtoupper(trim($code)))
                ->map(fn ($code) => $code === 'UK' ? 'GB' : $code)
                ->unique()
                ->values();

            if ($normalizedCodes->isNotEmpty()) {
                $countryIds = $normalizedCodes
                    ->map(function (string $code) {
                        return Country::firstOrCreate(
                            ['code' => $code],
                            ['name' => $code]
                        )->id;
                    })
                    ->all();

                $solutionModel->countries()->sync($countryIds);
            } else {
                $solutionModel->countries()->sync([]);
            }
        }
    }
}
