<?php

namespace Database\Seeders;

use App\Models\KYCFieldMaster;
use App\Models\KycSection;
use Illuminate\Database\Seeder;

class KYCFieldMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectionId = fn (string $slug) => KycSection::where('slug', $slug)->value('id');

        // Beneficial Owners Section
        KYCFieldMaster::updateOrCreate(
            ['internal_key' => 'kyc_beneficial_owner_name'],
            [
                'field_name' => 'Beneficial Owner Name',
                'kyc_section_id' => $sectionId('beneficial-owners'),
                'description' => 'Full legal name of the beneficial owner',
                'data_type' => 'text',
                'is_required' => true,
                'sensitivity_level' => 'highly-sensitive',
                'visible_to_merchant' => true,
                'visible_to_admin' => true,
                'visible_to_partner' => false,
                'sort_order' => 10,
                'status' => 'active',
            ]
        );

        KYCFieldMaster::updateOrCreate(
            ['internal_key' => 'kyc_beneficial_owner_dob'],
            [
                'field_name' => 'Beneficial Owner Date of Birth',
                'kyc_section_id' => $sectionId('beneficial-owners'),
                'description' => 'Date of birth in DD/MM/YYYY format',
                'data_type' => 'date',
                'is_required' => true,
                'sensitivity_level' => 'highly-sensitive',
                'visible_to_merchant' => true,
                'visible_to_admin' => true,
                'visible_to_partner' => false,
                'sort_order' => 20,
                'status' => 'active',
            ]
        );

        KYCFieldMaster::updateOrCreate(
            ['internal_key' => 'kyc_beneficial_owner_id_type'],
            [
                'field_name' => 'Beneficial Owner ID Type',
                'kyc_section_id' => $sectionId('beneficial-owners'),
                'description' => 'Type of identification document',
                'data_type' => 'dropdown',
                'is_required' => true,
                'sensitivity_level' => 'sensitive',
                'visible_to_merchant' => true,
                'visible_to_admin' => true,
                'visible_to_partner' => false,
                'sort_order' => 30,
                'status' => 'active',
            ]
        );

        // Company Information Section
        KYCFieldMaster::updateOrCreate(
            ['internal_key' => 'kyc_company_registration_number'],
            [
                'field_name' => 'Company Registration Number',
                'kyc_section_id' => $sectionId('company-information'),
                'description' => 'Unique company registration/incorporation number',
                'data_type' => 'text',
                'is_required' => true,
                'sensitivity_level' => 'sensitive',
                'visible_to_merchant' => true,
                'visible_to_admin' => true,
                'visible_to_partner' => true,
                'sort_order' => 40,
                'status' => 'active',
            ]
        );

        KYCFieldMaster::updateOrCreate(
            ['internal_key' => 'kyc_company_incorporation_date'],
            [
                'field_name' => 'Company Incorporation Date',
                'kyc_section_id' => $sectionId('company-information'),
                'description' => 'Date when the company was incorporated',
                'data_type' => 'date',
                'is_required' => true,
                'sensitivity_level' => 'normal',
                'visible_to_merchant' => true,
                'visible_to_admin' => true,
                'visible_to_partner' => true,
                'sort_order' => 50,
                'status' => 'active',
            ]
        );

        KYCFieldMaster::updateOrCreate(
            ['internal_key' => 'kyc_company_tax_id'],
            [
                'field_name' => 'Company Tax ID',
                'kyc_section_id' => $sectionId('company-information'),
                'description' => 'Tax identification number or VAT number',
                'data_type' => 'text',
                'is_required' => false,
                'sensitivity_level' => 'sensitive',
                'visible_to_merchant' => false,
                'visible_to_admin' => true,
                'visible_to_partner' => false,
                'sort_order' => 60,
                'status' => 'active',
            ]
        );

        // Board Members Section
        KYCFieldMaster::updateOrCreate(
            ['internal_key' => 'kyc_board_member_name'],
            [
                'field_name' => 'Board Member Name',
                'kyc_section_id' => $sectionId('board-members-gm'),
                'description' => 'Full legal name of board member',
                'data_type' => 'text',
                'is_required' => true,
                'sensitivity_level' => 'sensitive',
                'visible_to_merchant' => true,
                'visible_to_admin' => true,
                'visible_to_partner' => false,
                'sort_order' => 70,
                'status' => 'active',
            ]
        );

        KYCFieldMaster::updateOrCreate(
            ['internal_key' => 'kyc_board_member_designation'],
            [
                'field_name' => 'Board Member Designation',
                'kyc_section_id' => $sectionId('board-members-gm'),
                'description' => 'Position held by the board member',
                'data_type' => 'dropdown',
                'is_required' => true,
                'sensitivity_level' => 'normal',
                'visible_to_merchant' => true,
                'visible_to_admin' => true,
                'visible_to_partner' => true,
                'sort_order' => 80,
                'status' => 'active',
            ]
        );

        // Contact Person Section
        KYCFieldMaster::updateOrCreate(
            ['internal_key' => 'kyc_contact_person_email'],
            [
                'field_name' => 'Contact Person Email',
                'kyc_section_id' => $sectionId('contact-person'),
                'description' => 'Primary contact email address',
                'data_type' => 'email',
                'is_required' => true,
                'sensitivity_level' => 'sensitive',
                'visible_to_merchant' => true,
                'visible_to_admin' => true,
                'visible_to_partner' => false,
                'sort_order' => 90,
                'status' => 'active',
            ]
        );

        KYCFieldMaster::updateOrCreate(
            ['internal_key' => 'kyc_contact_person_phone'],
            [
                'field_name' => 'Contact Person Phone',
                'kyc_section_id' => $sectionId('contact-person'),
                'description' => 'Primary contact phone number with country code',
                'data_type' => 'tel',
                'is_required' => true,
                'sensitivity_level' => 'sensitive',
                'visible_to_merchant' => true,
                'visible_to_admin' => true,
                'visible_to_partner' => false,
                'sort_order' => 100,
                'status' => 'active',
            ]
        );

        KYCFieldMaster::updateOrCreate(
            ['internal_key' => 'kyc_contact_person_address'],
            [
                'field_name' => 'Contact Person Address',
                'kyc_section_id' => $sectionId('contact-person'),
                'description' => 'Complete residential address',
                'data_type' => 'textarea',
                'is_required' => true,
                'sensitivity_level' => 'sensitive',
                'visible_to_merchant' => true,
                'visible_to_admin' => true,
                'visible_to_partner' => false,
                'sort_order' => 110,
                'status' => 'active',
            ]
        );
    }
}
