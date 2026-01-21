<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class KycController extends Controller
{
    public function welcome(): View
    {
        return view('merchant.kyc.welcome');
    }

    public function company(): View
    {
        return view('merchant.kyc.company');
    }

    public function beneficialOwners(): View
    {
        return view('merchant.kyc.beneficial-owners');
    }

    public function boardMembers(): View
    {
        return view('merchant.kyc.board-members');
    }

    public function contactPerson(): View
    {
        return view('merchant.kyc.contact-person');
    }

    public function purposeOfService(): View
    {
        return view('merchant.kyc.purpose-of-service');
    }

    public function salesChannels(): View
    {
        return view('merchant.kyc.sales-channels');
    }

    public function bankInformation(): View
    {
        return view('merchant.kyc.bank-information');
    }

    public function authorizedSignatories(): View
    {
        return view('merchant.kyc.authorized-signatories');
    }

    public function review(): View
    {
        return view('merchant.kyc.review');
    }
}

