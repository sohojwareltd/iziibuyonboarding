<?php

namespace Database\Seeders;

use App\Models\KYCFieldMaster;
use Illuminate\Database\Seeder;

class KYCFieldMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Beneficial Owners Section
        KYCFieldMaster::create([
            'field_name' => 'Beneficial Owner Name',
            'internal_key' => 'kyc_beneficial_owner_name',
            'kyc_section' => 'beneficial',
            'description' => 'Full legal name of the beneficial owner',
            'data_type' => 'text',
            'is_required' => true,
            'sensitivity_level' => 'highly-sensitive',
            'visible_to_merchant' => true,
            'visible_to_admin' => true,
            'visible_to_partner' => false,
            'sort_order' => 10,
            'status' => 'active',
        ]);

        KYCFieldMaster::create([
            'field_name' => 'Beneficial Owner Date of Birth',
            'internal_key' => 'kyc_beneficial_owner_dob',
            'kyc_section' => 'beneficial',
            'description' => 'Date of birth in DD/MM/YYYY format',
            'data_type' => 'date',
            'is_required' => true,
            'sensitivity_level' => 'highly-sensitive',
            'visible_to_merchant' => true,
            'visible_to_admin' => true,
            'visible_to_partner' => false,
            'sort_order' => 20,
            'status' => 'active',
        ]);

        KYCFieldMaster::create([
            'field_name' => 'Beneficial Owner ID Type',
            'internal_key' => 'kyc_beneficial_owner_id_type',
            'kyc_section' => 'beneficial',
            'description' => 'Type of identification document',
            'data_type' => 'dropdown',
            'is_required' => true,
            'sensitivity_level' => 'sensitive',
            'visible_to_merchant' => true,
            'visible_to_admin' => true,
            'visible_to_partner' => false,
            'sort_order' => 30,
            'status' => 'active',
        ]);

        // Company Information Section
        KYCFieldMaster::create([
            'field_name' => 'Company Registration Number',
            'internal_key' => 'kyc_company_registration_number',
            'kyc_section' => 'company',
            'description' => 'Unique company registration/incorporation number',
            'data_type' => 'text',
            'is_required' => true,
            'sensitivity_level' => 'sensitive',
            'visible_to_merchant' => true,
            'visible_to_admin' => true,
            'visible_to_partner' => true,
            'sort_order' => 40,
            'status' => 'active',
        ]);

        KYCFieldMaster::create([
            'field_name' => 'Company Incorporation Date',
            'internal_key' => 'kyc_company_incorporation_date',
            'kyc_section' => 'company',
            'description' => 'Date when the company was incorporated',
            'data_type' => 'date',
            'is_required' => true,
            'sensitivity_level' => 'normal',
            'visible_to_merchant' => true,
            'visible_to_admin' => true,
            'visible_to_partner' => true,
            'sort_order' => 50,
            'status' => 'active',
        ]);

        KYCFieldMaster::create([
            'field_name' => 'Company Tax ID',
            'internal_key' => 'kyc_company_tax_id',
            'kyc_section' => 'company',
            'description' => 'Tax identification number or VAT number',
            'data_type' => 'text',
            'is_required' => false,
            'sensitivity_level' => 'sensitive',
            'visible_to_merchant' => false,
            'visible_to_admin' => true,
            'visible_to_partner' => false,
            'sort_order' => 60,
            'status' => 'active',
        ]);

        // Board Members Section
        KYCFieldMaster::create([
            'field_name' => 'Board Member Name',
            'internal_key' => 'kyc_board_member_name',
            'kyc_section' => 'board',
            'description' => 'Full legal name of board member',
            'data_type' => 'text',
            'is_required' => true,
            'sensitivity_level' => 'sensitive',
            'visible_to_merchant' => true,
            'visible_to_admin' => true,
            'visible_to_partner' => false,
            'sort_order' => 70,
            'status' => 'active',
        ]);

        KYCFieldMaster::create([
            'field_name' => 'Board Member Designation',
            'internal_key' => 'kyc_board_member_designation',
            'kyc_section' => 'board',
            'description' => 'Position held by the board member',
            'data_type' => 'dropdown',
            'is_required' => true,
            'sensitivity_level' => 'normal',
            'visible_to_merchant' => true,
            'visible_to_admin' => true,
            'visible_to_partner' => true,
            'sort_order' => 80,
            'status' => 'active',
        ]);

        // Contact Person Section
        KYCFieldMaster::create([
            'field_name' => 'Contact Person Email',
            'internal_key' => 'kyc_contact_person_email',
            'kyc_section' => 'contact',
            'description' => 'Primary contact email address',
            'data_type' => 'email',
            'is_required' => true,
            'sensitivity_level' => 'sensitive',
            'visible_to_merchant' => true,
            'visible_to_admin' => true,
            'visible_to_partner' => false,
            'sort_order' => 90,
            'status' => 'active',
        ]);

        KYCFieldMaster::create([
            'field_name' => 'Contact Person Phone',
            'internal_key' => 'kyc_contact_person_phone',
            'kyc_section' => 'contact',
            'description' => 'Primary contact phone number with country code',
            'data_type' => 'tel',
            'is_required' => true,
            'sensitivity_level' => 'sensitive',
            'visible_to_merchant' => true,
            'visible_to_admin' => true,
            'visible_to_partner' => false,
            'sort_order' => 100,
            'status' => 'active',
        ]);

        KYCFieldMaster::create([
            'field_name' => 'Contact Person Address',
            'internal_key' => 'kyc_contact_person_address',
            'kyc_section' => 'contact',
            'description' => 'Complete residential address',
            'data_type' => 'textarea',
            'is_required' => true,
            'sensitivity_level' => 'sensitive',
            'visible_to_merchant' => true,
            'visible_to_admin' => true,
            'visible_to_partner' => false,
            'sort_order' => 110,
            'status' => 'active',
        ]);
    }
}
