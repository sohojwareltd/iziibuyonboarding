<?php

namespace Database\Seeders;

use App\Models\Onboarding;
use App\Models\Partner;
use App\Models\PriceListMaster;
use App\Models\Role;
use App\Models\SolutionMaster;
use App\Models\User;
use Illuminate\Database\Seeder;

class OnboardingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $solutions = SolutionMaster::all();
        $priceLists = PriceListMaster::all();
        $users = User::all();
        $partners = Partner::all();

        // Create test users if they don't exist
        if ($users->isEmpty()) {
            $this->command->info('Creating test users...');
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@2izii.com',
                'password' => bcrypt('password'),
            ]);
            User::create([
                'name' => 'Partner User',
                'email' => 'partner@2izii.com',
                'password' => bcrypt('password'),
            ]);
            $users = User::all();
        }

        // Create partners if missing
        if ($partners->isEmpty()) {
            $this->command->info('Creating sample partners...');
            $partners = collect([
                ['title' => 'Partner One', 'slug' => 'partner-one'],
                ['title' => 'Partner Two', 'slug' => 'partner-two'],
                ['title' => 'Partner Three', 'slug' => 'partner-three'],
            ])->map(fn ($data) => Partner::create($data));
        }

        if ($solutions->isEmpty()) {
            $this->command->warn('Skipping OnboardingSeeder: No solution masters found. Please run SolutionMasterSeeder first.');
            return;
        }

        $merchantNames = [
            'Acme Trading Ltd',
            'Tech Retail Solutions',
            'Fashion Forward Ltd',
            'Coffee Corner UK',
            'Digital Goods Ltd',
            'Premium Services Inc',
            'Global Imports Ltd',
            'Local Market Store',
            'Online Ventures Ltd',
            'Professional Services Ltd',
        ];

        $countries = ['GB', 'NO', 'SE'];
        $paymentMethods = [
            ['visa', 'mastercard'],
            ['visa', 'mastercard', 'apple-pay'],
            ['visa', 'mastercard', 'google-pay'],
            ['visa', 'mastercard', 'apple-pay', 'google-pay'],
            ['visa', 'mastercard'],
        ];

        $acquirerOptions = [
            ['elavon'],
            ['surfboard'],
            ['elavon', 'surfboard'],
        ];

        $internalTags = [
            ['High-Risk'],
            ['Fast-Track'],
            ['High-Risk', 'Fast-Track'],
            ['VIP-Client'],
            ['Testing'],
            [],
        ];

        $statuses = ['draft', 'sent', 'in-review', 'approved', 'active'];
        $adminUser = $users->first();
        $merchantRole = Role::firstOrCreate(
            ['name' => 'Merchant'],
            ['description' => 'Merchant user']
        );
        $partner = $partners->first();
        $priceList = $priceLists->first();

        foreach ($merchantNames as $index => $name) {
            $requestId = Onboarding::generateRequestId();
            $status = $statuses[$index % count($statuses)];
            $isApproved = in_array($status, ['approved', 'active']);
            $merchantEmail = strtolower(str_replace(' ', '.', $name)) . '@merchant.com';
            $merchantUser = User::firstOrCreate(
                ['email' => $merchantEmail],
                [
                    'name' => $name,
                    'role_id' => $merchantRole->id,
                    'password' => bcrypt('password'),
                ]
            );

            $onboarding = Onboarding::create([
                'solution_id' => $solutions->random()->id,
                'partner_id' => $partners->random()->id ?? $partner?->id,
                'merchant_user_id' => $merchantUser->id,
                'legal_business_name' => $name,
                'trading_name' => $this->generateTradingName($name),
                'registration_number' => strtoupper(chr(rand(65, 90)) . rand(100000000, 999999999)),
                'business_website' => 'www.' . strtolower(str_replace(' ', '', $name)) . '.com',
                'merchant_contact_email' => $merchantEmail,
                'merchant_phone_number' => '+44 ' . rand(7000, 7999) . ' ' . rand(100000, 999999),
                'country_of_operation' => $countries[rand(0, count($countries) - 1)],
                'payment_methods' => $paymentMethods[$index % count($paymentMethods)],
                'acquirers' => $acquirerOptions[$index % count($acquirerOptions)],
                'price_list_id' => $priceList->id ?? null,
                'custom_pricing' => null,
                'internal_tags' => $internalTags[$index % count($internalTags)],
                'internal_notes' => 'Onboarding for ' . $name . ' created on ' . now()->format('Y-m-d'),
                'request_id' => $requestId,
                'status' => $status,
                'created_by' => $adminUser->id,
                'approved_by' => $isApproved ? $adminUser->id : null,
                'sent_at' => $status !== 'draft' ? now()->subDays(rand(1, 30)) : null,
                'approved_at' => $isApproved ? now()->subDays(rand(0, 20)) : null,
                'kyc_link' => $status !== 'draft' ? Onboarding::generateKycLink() : null,
                'kyc_completed_at' => $status === 'active' ? now()->subDays(rand(0, 15)) : null,
                'rejection_reason' => null,
                'revision_count' => rand(0, 3),
            ]);

            $this->command->info("Created onboarding for: {$name} (Status: {$status})");
        }

        $this->command->info('Onboarding seeder completed successfully!');
    }

    /**
     * Generate a trading name from legal name.
     */
    private function generateTradingName(string $legalName): string
    {
        $parts = explode(' ', $legalName);
        if (count($parts) > 1) {
            return implode(' ', array_slice($parts, 0, -1));
        }
        return $legalName . ' Trade';
    }
}
