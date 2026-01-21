<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::prefix('onboarding')
            ->name('onboarding.')
            ->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\OnboardingController::class, 'index'])->name('index');
                Route::get('/start', [\App\Http\Controllers\Admin\OnboardingController::class, 'start'])->name('start');
                Route::get('/track', [\App\Http\Controllers\Admin\OnboardingController::class, 'track'])->name('track');
            });
    });

Route::prefix('merchant')
    ->name('merchant.')
    ->group(function () {
        Route::prefix('kyc')
            ->name('kyc.')
            ->group(function () {
                Route::get('/', [\App\Http\Controllers\Merchant\KycController::class, 'welcome'])->name('welcome');
                Route::get('/company', [\App\Http\Controllers\Merchant\KycController::class, 'company'])->name('company');
                Route::get('/beneficial-owners', [\App\Http\Controllers\Merchant\KycController::class, 'beneficialOwners'])->name('beneficialOwners');
                Route::get('/board-members', [\App\Http\Controllers\Merchant\KycController::class, 'boardMembers'])->name('boardMembers');
                Route::get('/contact-person', [\App\Http\Controllers\Merchant\KycController::class, 'contactPerson'])->name('contactPerson');
                Route::get('/purpose-of-service', [\App\Http\Controllers\Merchant\KycController::class, 'purposeOfService'])->name('purposeOfService');
                Route::get('/sales-channels', [\App\Http\Controllers\Merchant\KycController::class, 'salesChannels'])->name('salesChannels');
                Route::get('/bank-information', [\App\Http\Controllers\Merchant\KycController::class, 'bankInformation'])->name('bankInformation');
                Route::get('/authorized-signatories', [\App\Http\Controllers\Merchant\KycController::class, 'authorizedSignatories'])->name('authorizedSignatories');
                Route::get('/review', [\App\Http\Controllers\Merchant\KycController::class, 'review'])->name('review');
            });
    });
