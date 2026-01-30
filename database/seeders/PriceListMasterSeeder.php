<?php

namespace Database\Seeders;

use App\Models\PriceListMaster;
use Illuminate\Database\Seeder;

class PriceListMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priceLists = [
            [
                'name' => 'Standard EU Retail',
                'type' => 'merchant-selling',
                'currency' => 'EUR',
                'status' => 'active',
                'assignment_level' => 'global',
                'assignment_rules' => [
                    'scope' => 'global',
                ],
                'price_lines' => [
                    [
                        'payment_method' => 'Visa Credit',
                        'line_type' => 'Card Not Present',
                        'percent_fee' => 2.50,
                        'fixed_fee' => 0.25,
                    ],
                    [
                        'payment_method' => 'Mastercard',
                        'line_type' => 'Card Not Present',
                        'percent_fee' => 2.60,
                        'fixed_fee' => 0.25,
                    ],
                ],
                'version' => '1.0',
                'effective_from' => '2024-01-01',
                'effective_to' => null,
            ],
            [
                'name' => 'Acquirer Cost - Chase US',
                'type' => 'acquirer-cost',
                'currency' => 'USD',
                'status' => 'draft',
                'assignment_level' => 'acquirer',
                'assignment_rules' => [
                    'acquirer' => 'Chase',
                    'country' => 'US',
                ],
                'price_lines' => [
                    [
                        'payment_method' => 'Visa Credit',
                        'line_type' => 'Card Present',
                        'percent_fee' => 1.75,
                        'fixed_fee' => 0.10,
                    ],
                    [
                        'payment_method' => 'Mastercard',
                        'line_type' => 'Card Present',
                        'percent_fee' => 1.80,
                        'fixed_fee' => 0.10,
                    ],
                ],
                'version' => '1.0',
                'effective_from' => '2024-02-01',
                'effective_to' => '2024-12-31',
            ],
            [
                'name' => 'Partner Kickback - TechReseller',
                'type' => 'partner-kickback',
                'currency' => 'GBP',
                'status' => 'inactive',
                'assignment_level' => 'merchant',
                'assignment_rules' => [
                    'partner' => 'TechReseller',
                ],
                'price_lines' => [
                    [
                        'payment_method' => 'Visa Credit',
                        'line_type' => 'Card Not Present',
                        'percent_fee' => 0.50,
                        'fixed_fee' => 0.05,
                    ],
                ],
                'version' => '1.0',
                'effective_from' => '2023-03-15',
                'effective_to' => null,
            ],
        ];

        foreach ($priceLists as $priceList) {
            PriceListMaster::create($priceList);
        }
    }
}
