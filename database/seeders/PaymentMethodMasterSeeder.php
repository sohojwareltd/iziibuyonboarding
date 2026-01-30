<?php

namespace Database\Seeders;

use App\Models\PaymentMethodMaster;
use Illuminate\Database\Seeder;

class PaymentMethodMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'Visa',
                'display_label' => 'Visa Card Payments',
                'category' => 'card',
                'description' => 'Accept Visa credit and debit card payments globally',
                'supported_countries' => json_encode(['United Kingdom', 'United States', 'Canada', 'Australia', 'Germany', 'France']),
                'supported_acquirers' => json_encode([
                    ['id' => 1, 'name' => 'Elavon', 'types' => ['online', 'pos', 'recurring']],
                    ['id' => 2, 'name' => 'Square', 'types' => ['online', 'pos']],
                ]),
                'supported_solutions' => json_encode([1, 2, 3, 5]), // POS, E-commerce, Marketplace, Recurring Billing
                'scheme' => 'visa',
                'supports_3ds' => true,
                'allows_tokenization' => true,
                'is_active' => true,
                'notes' => 'Most widely accepted card network globally',
                'requires_additional_documents' => false,
                'requires_acquirer_configuration' => true,
            ],
            [
                'name' => 'Mastercard',
                'display_label' => 'Mastercard Payments',
                'category' => 'card',
                'description' => 'Accept Mastercard credit and debit card payments',
                'supported_countries' => json_encode(['United Kingdom', 'United States', 'Canada', 'Australia', 'Germany', 'France', 'Italy']),
                'supported_acquirers' => json_encode([
                    ['id' => 1, 'name' => 'Elavon', 'types' => ['online', 'pos', 'recurring']],
                    ['id' => 3, 'name' => 'Stripe', 'types' => ['online', 'recurring']],
                ]),
                'supported_solutions' => json_encode([1, 2, 3, 5]),
                'scheme' => 'mastercard',
                'supports_3ds' => true,
                'allows_tokenization' => true,
                'is_active' => true,
                'notes' => 'Second largest card network worldwide',
                'requires_additional_documents' => false,
                'requires_acquirer_configuration' => true,
            ],
            [
                'name' => 'American Express',
                'display_label' => 'Amex Card Payments',
                'category' => 'card',
                'description' => 'Accept American Express card payments',
                'supported_countries' => json_encode(['United States', 'Canada', 'United Kingdom', 'Australia']),
                'supported_acquirers' => json_encode([
                    ['id' => 1, 'name' => 'Elavon', 'types' => ['online', 'pos']],
                ]),
                'supported_solutions' => json_encode([1, 2, 3]),
                'scheme' => 'amex',
                'supports_3ds' => true,
                'allows_tokenization' => true,
                'is_active' => true,
                'notes' => 'Premium card network with higher processing fees',
                'requires_additional_documents' => true,
                'requires_acquirer_configuration' => true,
            ],
            [
                'name' => 'PayPal',
                'display_label' => 'PayPal Digital Wallet',
                'category' => 'wallet',
                'description' => 'Accept payments via PayPal digital wallet',
                'supported_countries' => json_encode(['United States', 'United Kingdom', 'Canada', 'Australia', 'Germany', 'France', 'Spain', 'Italy']),
                'supported_acquirers' => json_encode([
                    ['id' => 4, 'name' => 'PayPal', 'types' => ['online', 'recurring']],
                ]),
                'supported_solutions' => json_encode([2, 3, 4, 5]), // E-commerce, Marketplace, Mobile App, Recurring
                'scheme' => null,
                'supports_3ds' => false,
                'allows_tokenization' => true,
                'is_active' => true,
                'notes' => 'Popular digital wallet with buyer protection',
                'requires_additional_documents' => false,
                'requires_acquirer_configuration' => true,
            ],
            [
                'name' => 'Apple Pay',
                'display_label' => 'Apple Pay Mobile Wallet',
                'category' => 'wallet',
                'description' => 'Accept contactless payments via Apple Pay',
                'supported_countries' => json_encode(['United States', 'United Kingdom', 'Canada', 'Australia', 'France', 'Germany', 'Japan']),
                'supported_acquirers' => json_encode([
                    ['id' => 3, 'name' => 'Stripe', 'types' => ['online', 'pos']],
                    ['id' => 2, 'name' => 'Square', 'types' => ['online', 'pos']],
                ]),
                'supported_solutions' => json_encode([1, 2, 4]), // POS, E-commerce, Mobile App
                'scheme' => null,
                'supports_3ds' => true,
                'allows_tokenization' => true,
                'is_active' => true,
                'notes' => 'Seamless mobile and contactless payments for iOS users',
                'requires_additional_documents' => false,
                'requires_acquirer_configuration' => true,
            ],
            [
                'name' => 'Google Pay',
                'display_label' => 'Google Pay Mobile Wallet',
                'category' => 'wallet',
                'description' => 'Accept contactless payments via Google Pay',
                'supported_countries' => json_encode(['United States', 'United Kingdom', 'Canada', 'Australia', 'India', 'Singapore']),
                'supported_acquirers' => json_encode([
                    ['id' => 3, 'name' => 'Stripe', 'types' => ['online', 'pos']],
                    ['id' => 2, 'name' => 'Square', 'types' => ['online', 'pos']],
                ]),
                'supported_solutions' => json_encode([1, 2, 4]),
                'scheme' => null,
                'supports_3ds' => true,
                'allows_tokenization' => true,
                'is_active' => true,
                'notes' => 'Seamless mobile and contactless payments for Android users',
                'requires_additional_documents' => false,
                'requires_acquirer_configuration' => true,
            ],
            [
                'name' => 'Bank Transfer',
                'display_label' => 'Direct Bank Transfer (ACH/SEPA)',
                'category' => 'bank',
                'description' => 'Accept direct bank transfers via ACH or SEPA',
                'supported_countries' => json_encode(['United States', 'United Kingdom', 'Germany', 'France', 'Netherlands', 'Belgium']),
                'supported_acquirers' => json_encode([
                    ['id' => 5, 'name' => 'Wise', 'types' => ['online']],
                    ['id' => 3, 'name' => 'Stripe', 'types' => ['online']],
                ]),
                'supported_solutions' => json_encode([2, 5]), // E-commerce, Recurring Billing
                'scheme' => null,
                'supports_3ds' => false,
                'allows_tokenization' => false,
                'is_active' => true,
                'notes' => 'Low-cost payment method for high-value transactions',
                'requires_additional_documents' => true,
                'requires_acquirer_configuration' => true,
            ],
            [
                'name' => 'SEPA Direct Debit',
                'display_label' => 'SEPA Direct Debit',
                'category' => 'bank',
                'description' => 'Accept recurring payments via SEPA Direct Debit mandate',
                'supported_countries' => json_encode(['Germany', 'France', 'Netherlands', 'Belgium', 'Spain', 'Italy', 'Austria']),
                'supported_acquirers' => json_encode([
                    ['id' => 3, 'name' => 'Stripe', 'types' => ['recurring']],
                ]),
                'supported_solutions' => json_encode([5]), // Recurring Billing only
                'scheme' => null,
                'supports_3ds' => false,
                'allows_tokenization' => true,
                'is_active' => true,
                'notes' => 'Ideal for subscription-based businesses in Europe',
                'requires_additional_documents' => true,
                'requires_acquirer_configuration' => true,
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethodMaster::create($method);
        }
    }
}
