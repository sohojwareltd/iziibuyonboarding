<?php

namespace Database\Seeders;

use App\Models\AcquirerMaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcquirerMasterSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $acquirers = [
            [
                'name' => 'Elavon',
                'mode' => 'email',
                'is_active' => true,
                'description' => 'Elavon is a leading payment processor for merchants worldwide',
                'supported_countries' => json_encode(['US', 'UK', 'CA', 'AU']),
                'supported_solutions' => json_encode([1, 2, 3]),
                'email_recipient' => 'kyc@elavon.com',
                'email_subject_template' => 'KYC Application - {merchant_name}',
                'email_body_template' => 'Dear Elavon Team,

                Please find attached the KYC documents for merchant: {merchant_name}

                Merchant Details:
                - Name: {merchant_name}
                - Business Type: {business_type}
                - Registration Number: {registration_number}

                Please review and process accordingly.

                Best regards,
                2iZii Onboarding System',
                'attachment_format' => 'pdf',
                'secure_email_required' => true,
                'requires_beneficial_owner_data' => true,
                'requires_board_member_data' => false,
                'requires_signatories' => true,
            ],
            [
                'name' => 'Square',
                'mode' => 'api',
                'is_active' => true,
                'description' => 'Square offers payment processing and business management solutions',
                'supported_countries' => json_encode(['US', 'CA']),
                'supported_solutions' => json_encode([1, 3]),
                'email_recipient' => 'api@square.com',
                'email_subject_template' => 'Merchant Onboarding - {merchant_name}',
                'email_body_template' => 'Merchant Application Submitted for {merchant_name}',
                'attachment_format' => 'zip',
                'secure_email_required' => false,
                'requires_beneficial_owner_data' => false,
                'requires_board_member_data' => true,
                'requires_signatories' => true,
            ],
            [
                'name' => 'Stripe',
                'mode' => 'api',
                'is_active' => true,
                'description' => 'Stripe is a global payment infrastructure platform',
                'supported_countries' => json_encode(['US', 'UK', 'EU', 'AU', 'JP', 'SG']),
                'supported_solutions' => json_encode([2, 3]),
                'email_recipient' => 'compliance@stripe.com',
                'email_subject_template' => 'New Merchant Account - {merchant_name}',
                'email_body_template' => 'New merchant account request for: {merchant_name}',
                'attachment_format' => 'pdf',
                'secure_email_required' => true,
                'requires_beneficial_owner_data' => true,
                'requires_board_member_data' => true,
                'requires_signatories' => true,
            ],
            [
                'name' => 'PayPal',
                'mode' => 'api',
                'is_active' => false,
                'description' => 'PayPal provides global payment processing services',
                'supported_countries' => json_encode(['US', 'UK', 'EU']),
                'supported_solutions' => json_encode([1]),
                'email_recipient' => 'onboarding@paypal.com',
                'email_subject_template' => 'PayPal Account Setup - {merchant_name}',
                'email_body_template' => 'Account setup request for PayPal merchant: {merchant_name}',
                'attachment_format' => 'pdf',
                'secure_email_required' => false,
                'requires_beneficial_owner_data' => true,
                'requires_board_member_data' => false,
                'requires_signatories' => false,
            ],
            [
                'name' => 'Wise',
                'mode' => 'email',
                'is_active' => true,
                'description' => 'Wise (formerly TransferWise) provides international payment solutions',
                'supported_countries' => json_encode(['UK', 'EU', 'US', 'AU']),
                'supported_solutions' => json_encode([2]),
                'email_recipient' => 'business@wise.com',
                'email_subject_template' => 'Business Account Application - {merchant_name}',
                'email_body_template' => 'Business account application for {merchant_name}',
                'attachment_format' => 'zip',
                'secure_email_required' => true,
                'requires_beneficial_owner_data' => true,
                'requires_board_member_data' => false,
                'requires_signatories' => true,
            ],
        ];

        foreach ($acquirers as $acquirer) {
            AcquirerMaster::create($acquirer);
        }
    }
}
