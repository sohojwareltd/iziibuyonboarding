<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Onboarding;
use Illuminate\View\View;

class KycController extends Controller
{
    public function welcome($kyc_link = null): View
    {
        $onboarding = null;
        if ($kyc_link) {
            $onboarding = Onboarding::where('kyc_link', $kyc_link)->with('solution')->firstOrFail();
        }
        return view('merchant.kyc.welcome', ['onboarding' => $onboarding, 'kyc_link' => $kyc_link]);
    }

    public function company($kyc_link = null): View
    {
        return view('merchant.kyc.company', ['kyc_link' => $kyc_link]);
    }

    public function beneficialOwners($kyc_link = null): View
    {
        return view('merchant.kyc.beneficial-owners', ['kyc_link' => $kyc_link]);
    }

    public function boardMembers($kyc_link = null): View
    {
        return view('merchant.kyc.board-members', ['kyc_link' => $kyc_link]);
    }

    public function contactPerson($kyc_link = null): View
    {
        return view('merchant.kyc.contact-person', ['kyc_link' => $kyc_link]);
    }

    public function purposeOfService($kyc_link = null): View
    {
        return view('merchant.kyc.purpose-of-service', ['kyc_link' => $kyc_link]);
    }

    public function salesChannels($kyc_link = null): View
    {
        return view('merchant.kyc.sales-channels', ['kyc_link' => $kyc_link]);
    }

    public function bankInformation($kyc_link = null): View
    {
        return view('merchant.kyc.bank-information', ['kyc_link' => $kyc_link]);
    }

    public function authorizedSignatories($kyc_link = null): View
    {
        return view('merchant.kyc.authorized-signatories', ['kyc_link' => $kyc_link]);
    }

    public function review($kyc_link = null): View
    {
        return view('merchant.kyc.review', ['kyc_link' => $kyc_link]);
    }
}
