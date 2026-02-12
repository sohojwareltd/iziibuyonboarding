<?php

namespace Database\Seeders;

use App\Models\KycSection;
use Illuminate\Database\Seeder;

class KycSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'name' => 'Company Information',
                'slug' => 'company-information',
                'description' => 'Legal entity details, registration, and business information',
                'sort_order' => 1,
            ],
            [
                'name' => 'Beneficial Owners',
                'slug' => 'beneficial-owners',
                'description' => 'Details of individuals who ultimately own or control the company (>25% ownership)',
                'sort_order' => 2,
            ],
            [
                'name' => 'Board Members / GM',
                'slug' => 'board-members-gm',
                'description' => 'Information about board members and general managers',
                'sort_order' => 3,
            ],
            [
                'name' => 'Contact Person',
                'slug' => 'contact-person',
                'description' => 'Primary contact person for the onboarding process',
                'sort_order' => 4,
            ],
            [
                'name' => 'Purpose of Service',
                'slug' => 'purpose-of-service',
                'description' => 'Business purpose, intended use of payment services, and transaction details',
                'sort_order' => 5,
            ],
            [
                'name' => 'Sales Channels',
                'slug' => 'sales-channels',
                'description' => 'Distribution channels including POS, e-commerce, mobile, and other sales methods',
                'sort_order' => 6,
            ],
            [
                'name' => 'Bank Information',
                'slug' => 'bank-information',
                'description' => 'Settlement bank account details and verification documents',
                'sort_order' => 7,
            ],
            [
                'name' => 'Authorized Signatories',
                'slug' => 'authorized-signatories',
                'description' => 'Persons authorized to sign agreements and contracts on behalf of the company',
                'sort_order' => 8,
            ],
        ];

        foreach ($sections as $section) {
            KycSection::updateOrCreate(
                ['slug' => $section['slug']],
                $section
            );
        }
    }
}
