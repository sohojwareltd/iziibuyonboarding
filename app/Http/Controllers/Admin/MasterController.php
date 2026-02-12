<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcquirerMaster;
use App\Models\Country;
use App\Models\KycSection;
use Illuminate\View\View;

class MasterController extends Controller
{
    public function solutionMaster(): View
    {
        return view('admin.masters.solution-master');
    }

    public function acquirerMaster(): View
    {
        return view('admin.masters.acquirer-master');
    }

    public function paymentMethodMaster(): View
    {
        return view('admin.masters.payment-method-master');
    }

    public function documentTypeMaster(): View
    {
        return view('admin.masters.document-type-master');
    }

    public function kycFieldMaster(): View
    {
        return view('admin.masters.kyc-field-master');
    }

    public function acquirerFieldMapping(): View
    {
        $kycSections = KycSection::active()
            ->ordered()
            ->with(['kycFields' => fn ($q) => $q->where('status', 'active')->orderBy('sort_order')])
            ->get();

        $acquirers = AcquirerMaster::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();

        return view('admin.masters.acquirer-field-mapping', compact('kycSections', 'acquirers', 'countries'));
    }

    public function priceListMaster(): View
    {
        return view('admin.masters.price-list-master');
    }
}
