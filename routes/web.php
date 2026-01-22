<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\OnboardingController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Merchant\KycController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');

        Route::prefix('onboarding')
            ->name('onboarding.')
            ->group(function () {
                Route::get('/', [OnboardingController::class, 'index'])->name('index');
                Route::get('/start', [OnboardingController::class, 'start'])->name('start');
                Route::get('/track', [OnboardingController::class, 'track'])->name('track');
            });

        Route::prefix('masters')
            ->name('masters.')
            ->group(function () {
                Route::get('/solution-master', [MasterController::class, 'solutionMaster'])->name('solution-master');
                Route::get('/acquirer-master', [MasterController::class, 'acquirerMaster'])->name('acquirer-master');
                Route::get('/payment-method-master', [MasterController::class, 'paymentMethodMaster'])->name('payment-method-master');
                Route::get('/document-type-master', [MasterController::class, 'documentTypeMaster'])->name('document-type-master');
                Route::get('/kyc-field-master', [MasterController::class, 'kycFieldMaster'])->name('kyc-field-master');
                Route::get('/acquirer-field-mapping', [MasterController::class, 'acquirerFieldMapping'])->name('acquirer-field-mapping');
                Route::get('/price-list-master', [MasterController::class, 'priceListMaster'])->name('price-list-master');
            });
    });

Route::prefix('merchant')
    ->name('merchant.')
    ->group(function () {
        Route::prefix('kyc')
            ->name('kyc.')
            ->group(function () {
                Route::get('/', [KycController::class, 'welcome'])->name('welcome');
                Route::get('/company', [KycController::class, 'company'])->name('company');
                Route::get('/beneficial-owners', [KycController::class, 'beneficialOwners'])->name('beneficialOwners');
                Route::get('/board-members', [KycController::class, 'boardMembers'])->name('boardMembers');
                Route::get('/contact-person', [KycController::class, 'contactPerson'])->name('contactPerson');
                Route::get('/purpose-of-service', [KycController::class, 'purposeOfService'])->name('purposeOfService');
                Route::get('/sales-channels', [KycController::class, 'salesChannels'])->name('salesChannels');
                Route::get('/bank-information', [KycController::class, 'bankInformation'])->name('bankInformation');
                Route::get('/authorized-signatories', [KycController::class, 'authorizedSignatories'])->name('authorizedSignatories');
                Route::get('/review', [KycController::class, 'review'])->name('review');
            });
    });
