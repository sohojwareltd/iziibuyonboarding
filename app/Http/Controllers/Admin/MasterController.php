<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('admin.masters.acquirer-field-mapping');
    }

    public function priceListMaster(): View
    {
        return view('admin.masters.price-list-master');
    }
}
