<x-merchant.kyc>
    @push('css')
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #F7F8FA;
            }

            ::-webkit-scrollbar {
                display: none;
            }

            .form-input {
                width: 100%;
                border: 1px solid #D1D5DB;
                border-radius: 0.375rem;
                padding: 0.75rem 1rem;
                color: #2D3A74;
                outline: none;
                transition: all 0.2s;
            }

            .form-input:focus {
                border-color: #2D3A74;
                box-shadow: 0 0 0 1px #2D3A74;
            }

            .step-line {
                position: absolute;
                left: 15px;
                top: 30px;
                bottom: -10px;
                width: 2px;
                background-color: #E5E7EB;
                z-index: 0;
            }

            .last-step .step-line {
                display: none;
            }
        </style>
    @endpush


    <!-- Page Header -->
    <div id="page-header" class="mb-8">
        <h1 class="text-2xl font-semibold text-primary mb-2">Bank Information</h1>
        <p class="text-gray-500 text-sm">Provide the bank account details where settlement funds should be
            deposited.</p>
    </div>

    <!-- Alert Banner (Conditional) -->
    <div id="alert-banner"
        class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-md shadow-sm flex items-start gap-3">
        <i class="fa-solid fa-triangle-exclamation text-yellow-500 mt-0.5"></i>
        <div>
            <p class="text-sm text-yellow-800 font-medium">Attention Needed</p>
            <p class="text-sm text-yellow-700 mt-1">Your bank account country differs from your business
                registration country. Certain acquirers may require additional documentation.</p>
        </div>
    </div>

    <form id="cp-form" action="#" method="POST">

        <div id="bank-info-card" class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">

            <!-- SECTION A: ACCOUNT DETAILS -->
            <div id="section-account-details" class="mb-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6 border-b pb-2">A. Account
                    Details</h3>

                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <div class="col-span-1">
                        <x-input.text label="Bank Name" id="bank_name" name="bank_name" required
                            class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors"
                            placeholder="e.g. Chase Bank" />
                    </div>

                    <div class="col-span-1">
                        <x-input.text label="Account Holder Name" id="account_holder_name" name="account_holder_name"
                            required
                            class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors"
                            placeholder="Full legal name of account holder" />
                    </div>

                    <div class="col-span-1">
                        <x-input.text label="IBAN / Account Number" id="iban" name="iban" required
                            class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors font-mono"
                            placeholder="CH93 0000 0000 0000 0000 0" />
                    </div>

                    <div class="col-span-1">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-1.5">
                            BIC / SWIFT Code <span class="text-red-500">*</span>
                            <i class="fa-regular fa-circle-question text-gray-400 cursor-help"
                                title="Required by acquirers for settlement transfers."></i>
                        </label>

                        <x-input.text id="bic_swift_code" name="bic_swift_code" required
                            class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors"
                            placeholder="SWIFT123" />
                    </div>

                    <div class="col-span-1">
                        <x-input.select label="Country of Bank Account" id="bank_country" name="bank_country" required
                            class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 bg-white appearance-none cursor-pointer pr-10">
                            <option value="US">United States</option>
                            <option value="GB">United Kingdom</option>
                            <option value="DE">Germany</option>
                            <option value="FR">France</option>
                            <option value="CH" selected>Switzerland</option>
                        </x-input.select>
                        <div
                            class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500 -mt-9">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>

                    <div class="col-span-1">
                        <x-input.select label="Currency of Settlement" id="settlement_currency"
                            name="settlement_currency" :placeholder="false" required
                            class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 bg-white appearance-none cursor-pointer pr-10">
                            <option value="USD">USD - US Dollar</option>
                            <option value="EUR">EUR - Euro</option>
                            <option value="GBP">GBP - British Pound</option>
                            <option value="CHF" selected>CHF - Swiss Franc</option>
                        </x-input.select>
                        <div
                            class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500 -mt-9">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION B: BANK ADDRESS -->
            <div id="section-bank-address" class="mb-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6 border-b pb-2">B. Bank
                    Address</h3>

                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <div class="col-span-1">
                        <x-input.text label="Bank Address Line 1" id="bank_address_line1" name="bank_address_line1"
                            required
                            class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors" />
                    </div>

                    <div class="col-span-1">
                        <x-input.text label="Bank Address Line 2" id="bank_address_line2" name="bank_address_line2"
                            class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors" />
                    </div>

                    <div class="col-span-1">
                        <x-input.text label="City" id="bank_city" name="bank_city" required
                            class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors" />
                    </div>

                    <div class="col-span-1">
                        <x-input.text label="Postal Code" id="bank_postal_code" name="bank_postal_code" required
                            class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors" />
                    </div>

                    <div class="col-span-1">
                        <x-input.select label="Country" id="bank_country_address" name="bank_country_address"
                            :placeholder="false" required
                            class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 bg-gray-50 appearance-none cursor-pointer pr-10">
                            <option value="CH" selected>Switzerland</option>
                            <option value="other">Other...</option>
                        </x-input.select>
                        <div
                            class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500 -mt-9">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION C: AUTHORIZATION -->
            <div id="section-authorization" class="mb-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6 border-b pb-2">C.
                    Authorization</h3>

                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Proof of Bank Account Ownership
                            <span class="text-gray-400 font-normal">(Optional)</span></label>

                        <div
                            class="upload-zone border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer group">
                            <div
                                class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-blue-200 transition-colors">
                                <i class="fa-solid fa-cloud-arrow-up text-primary text-lg"></i>
                            </div>
                            <p class="text-sm text-gray-700 font-medium">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-500 mt-1">PDF, PNG, or JPG (max. 5MB)</p>
                            <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                        </div>

                        <div
                            class="mt-3 flex items-center justify-between p-3 bg-white border border-gray-200 rounded-md shadow-sm">
                            <div class="flex items-center gap-3">
                                <i class="fa-regular fa-file-pdf text-red-500 text-xl"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Bank_Statement_Oct2023.pdf</p>
                                    <p class="text-xs text-gray-500">1.2 MB</p>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-red-500 transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-span-2 mt-2">
                        <div class="flex items-start justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Is this account owned by the
                                    same legal entity?</label>
                                <p class="text-xs text-gray-500 mt-1">If the account holder name differs from the
                                    registered company name.</p>
                            </div>
                            <div
                                class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle" id="toggle-entity"
                                    class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300 checked:right-0 checked:border-primary transition-all duration-300"
                                    checked />
                                <label for="toggle-entity"
                                    class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer checked:bg-primary transition-colors duration-300"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION D: VALIDATION -->
            <div id="section-validation" class="mb-2">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6 border-b pb-2">D.
                    Validation</h3>

                <div class="space-y-6">
                    <div class="flex items-center justify-between py-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Does this account support
                                international transfers?</label>
                        </div>
                        <div
                            class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input type="checkbox" name="supports_international" id="toggle-intl" value="1"
                                class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300 checked:right-0 checked:border-primary transition-all duration-300"
                                checked />
                            <label for="toggle-intl"
                                class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer checked:bg-primary transition-colors duration-300"></label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Is this account used exclusively
                                for business operations?</label>
                        </div>
                        <div
                            class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input type="checkbox" name="business_operations_only" id="toggle-biz" value="1"
                                class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300 checked:right-0 checked:border-primary transition-all duration-300"
                                checked />
                            <label for="toggle-biz"
                                class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer checked:bg-primary transition-colors duration-300"></label>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <footer id="footer"
            class="fixed bottom-0 right-0 w-[calc(100%-260px)] bg-white border-t border-brand-border px-12 py-4 z-30">
            <div class="max-w-[900px] mx-auto flex items-center justify-between">
                <a href="{{ route('merchant.kyc.salesChannels') }}"
                    class="px-6 py-2.5 border border-brand-dark text-brand-dark bg-white hover:bg-gray-50 font-medium rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                    <span>Back</span>
                </a>

                <div class="flex items-center gap-4">
                    <button onclick="saveDraft()"
                        class="px-6 py-2.5 border border-brand-orange text-brand-orange bg-white hover:bg-orange-50 font-medium rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <i class="fa-regular fa-floppy-disk text-sm"></i>
                        <span>Save as Draft</span>
                    </button>

                    <a href="{{ route('merchant.kyc.authorizedSignatories') }}"
                        class="px-8 py-2.5 bg-brand-orange hover:bg-brand-orangeHover text-white font-semibold rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <span>Continue to Authorized Signatories</span>
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                </div>
            </div>
        </footer>
    </form>

    @push('js')
        <script>
            document.addEventListener('click', function(e) {
                const zone = e.target.closest('.upload-zone');
                if (zone) {
                    const input = zone.querySelector('input[type="file"]');
                    if (input) input.click();
                }
            });
        </script>

        <script>
            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.id === 'toggle-entity' && !this.checked) {
                        console.log('Show explanation field');
                    }
                    if (this.id === 'toggle-biz' && !this.checked) {
                        console.log('Show business explanation field');
                    }
                });
            });

            const requiredFields = document.querySelectorAll('input[type="text"]:required, select:required');
            const continueBtn = document.querySelector('#footer-actions a:last-child');

            function validateForm() {
                let allFilled = true;
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        allFilled = false;
                    }
                });
                continueBtn.classList.toggle('opacity-50', !allFilled);
                continueBtn.classList.toggle('cursor-not-allowed', !allFilled);
            }

            requiredFields.forEach(field => {
                field.addEventListener('input', validateForm);
                field.addEventListener('change', validateForm);
            });

            validateForm();
        </script>
    @endpush
</x-merchant.kyc>
