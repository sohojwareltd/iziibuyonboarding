<?php

namespace Database\Seeders;

use App\Models\DocumentTypesMaster;
use Illuminate\Database\Seeder;

class DocumentTypesMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Identity Documents
        DocumentTypesMaster::create([
            'document_name' => 'Passport',
            'category' => 'identity',
            'description' => 'International travel document issued by government authority',
            'allowed_file_types' => ['pdf', 'jpg', 'jpeg', 'png'],
            'max_file_size' => 10,
            'min_pages' => 1,
            'sensitivity_level' => 'highly-sensitive',
            'visible_to_merchant' => true,
            'visible_to_admin' => true,
            'mask_metadata' => true,
            'required_acquirers' => ['elavon', 'stripe'],
            'required_countries' => ['uk', 'us', 'no'],
            'required_solutions' => ['pos', 'ecommerce'],
            'kyc_section' => 'beneficial',
            'status' => 'active',
            'internal_notes' => 'Primary identity document for international merchants',
        ]);

        // Company Registration
        DocumentTypesMaster::create([
            'document_name' => 'Business License',
            'category' => 'company',
            'description' => 'Official business license from government regulatory body',
            'allowed_file_types' => ['pdf', 'jpg', 'jpeg'],
            'max_file_size' => 15,
            'min_pages' => 1,
            'sensitivity_level' => 'sensitive',
            'visible_to_merchant' => true,
            'visible_to_admin' => true,
            'mask_metadata' => false,
            'required_acquirers' => ['surfboard', 'elavon'],
            'required_countries' => ['uk', 'us'],
            'required_solutions' => ['ecommerce'],
            'kyc_section' => 'company',
            'status' => 'active',
            'internal_notes' => 'Required for all company registrations',
        ]);

        DocumentTypesMaster::create([
            'document_name' => 'Articles of Association',
            'category' => 'company',
            'description' => 'Founding document containing company rules and regulations',
            'allowed_file_types' => ['pdf'],
            'max_file_size' => 10,
            'min_pages' => 1,
            'sensitivity_level' => 'normal',
            'visible_to_merchant' => false,
            'visible_to_admin' => true,
            'mask_metadata' => false,
            'required_acquirers' => ['stripe'],
            'required_countries' => ['uk'],
            'required_solutions' => ['pos'],
            'kyc_section' => 'company',
            'status' => 'active',
            'internal_notes' => 'Company incorporation document',
        ]);

        // Bank Verification
        DocumentTypesMaster::create([
            'document_name' => 'Bank Statement',
            'category' => 'bank',
            'description' => 'Official bank statement showing account activity and balance',
            'allowed_file_types' => ['pdf', 'jpg', 'jpeg'],
            'max_file_size' => 15,
            'min_pages' => 1,
            'sensitivity_level' => 'highly-sensitive',
            'visible_to_merchant' => false,
            'visible_to_admin' => true,
            'mask_metadata' => true,
            'required_acquirers' => ['elavon', 'surfboard', 'stripe'],
            'required_countries' => ['uk', 'us', 'no'],
            'required_solutions' => ['pos', 'ecommerce', 'mobile'],
            'kyc_section' => null,
            'status' => 'active',
            'internal_notes' => 'Recent bank statements for fund verification',
        ]);

        DocumentTypesMaster::create([
            'document_name' => 'Proof of Address',
            'category' => 'bank',
            'description' => 'Utility bill or official letter confirming residential address',
            'allowed_file_types' => ['pdf', 'jpg', 'jpeg', 'png'],
            'max_file_size' => 10,
            'min_pages' => 1,
            'sensitivity_level' => 'sensitive',
            'visible_to_merchant' => true,
            'visible_to_admin' => true,
            'mask_metadata' => false,
            'required_acquirers' => null,
            'required_countries' => ['uk', 'us'],
            'required_solutions' => null,
            'kyc_section' => 'contact',
            'status' => 'active',
            'internal_notes' => 'Address verification required for compliance',
        ]);

        DocumentTypesMaster::create([
            'document_name' => 'Director ID',
            'category' => 'identity',
            'description' => 'Government-issued photo identification for company directors',
            'allowed_file_types' => ['pdf', 'jpg', 'jpeg'],
            'max_file_size' => 10,
            'min_pages' => 1,
            'sensitivity_level' => 'highly-sensitive',
            'visible_to_merchant' => false,
            'visible_to_admin' => true,
            'mask_metadata' => true,
            'required_acquirers' => ['elavon'],
            'required_countries' => ['uk'],
            'required_solutions' => ['pos'],
            'kyc_section' => 'board',
            'status' => 'draft',
            'internal_notes' => 'For director verification in company onboarding',
        ]);
    }
}
