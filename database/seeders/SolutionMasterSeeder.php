<?php

namespace Database\Seeders;

use App\Models\AcquirerMaster;
use App\Models\Country;
use App\Models\PaymentMethodMaster;
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
                'countries' => ['NL'],
                'tags' => ['pos', 'card-present', 'retail'],
                'acquirers' => ['Elavon'],
                'payment_methods' => ['Visa', 'Mastercard'],
                'alternative_methods' => ['contactless'],
                'requirements' => 'Requires compatible POS terminal and merchant onboarding approval.',
                'pricing_plan' => 'custom',
            ],
            [
                'name' => 'E-com Global',
                'category_slug' => 'e-commerce',
                'status' => 'published',
                'description' => 'Global e-commerce payment solution with multi-currency support',
                'countries' => [],
                'tags' => ['ecommerce', 'multi-currency', 'global'],
                'acquirers' => ['Elavon', 'Stripe'],
                'payment_methods' => ['Visa', 'Mastercard', 'American Express'],
                'alternative_methods' => ['klarna', 'paypal'],
                'requirements' => 'Requires PCI compliance and valid business registration.',
                'pricing_plan' => 'tiered',
            ],
            [
                'name' => 'Mobile App Payment',
                'category_slug' => 'mobile-app',
                'status' => 'published',
                'description' => 'Mobile application payment integration',
                'countries' => ['GB'],
                'tags' => ['mobile', 'app', 'payments'],
                'acquirers' => ['Square', 'Stripe'],
                'payment_methods' => ['Visa', 'Mastercard', 'Apple Pay', 'Google Pay'],
                'alternative_methods' => ['apple-pay', 'google-pay'],
                'requirements' => 'Requires mobile SDK integration and app store approval.',
                'pricing_plan' => 'standard',
            ],
            [
                'name' => 'Marketplace Connect',
                'category_slug' => 'marketplace',
                'status' => 'published',
                'description' => 'Marketplace payment distribution system',
                'countries' => [],
                'tags' => ['marketplace', 'distribution', 'multi-vendor'],
                'acquirers' => ['Stripe'],
                'payment_methods' => ['Visa', 'Mastercard', 'PayPal', 'Bank Transfer'],
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
                'alternative_methods' => $solution['alternative_methods'],
                'requirements' => $solution['requirements'],
                'pricing_plan' => $solution['pricing_plan'],
                ]
            );

            $countryCodes = collect($solution['countries'] ?? [])
                ->filter()
                ->map(fn ($code) => strtoupper(trim($code)))
                ->map(fn ($code) => $code === 'UK' ? 'GB' : $code)
                ->unique()
                ->values();

            if ($countryCodes->isNotEmpty()) {
                $countryIds = $countryCodes
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

            // Sync payment methods via pivot
            $pmNames = collect($solution['payment_methods'] ?? [])->filter()->unique()->values();
            if ($pmNames->isNotEmpty()) {
                $pmIds = PaymentMethodMaster::whereIn('name', $pmNames)->pluck('id')->all();
                $solutionModel->paymentMethodMasters()->sync($pmIds);
            } else {
                $solutionModel->paymentMethodMasters()->sync([]);
            }

            // Sync acquirers via pivot
            $acqNames = collect($solution['acquirers'] ?? [])->filter()->unique()->values();
            if ($acqNames->isNotEmpty()) {
                $acqIds = AcquirerMaster::whereIn('name', $acqNames)->pluck('id')->all();
                $solutionModel->acquirerMasters()->sync($acqIds);
            } else {
                $solutionModel->acquirerMasters()->sync([]);
            }
        }
    }
}
