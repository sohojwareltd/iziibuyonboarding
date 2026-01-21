@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Information - 2iZii Admin Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        window.FontAwesomeConfig = { autoReplaceSvg: 'nest' };
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2D3A74',
                        secondary: '#FFA439',
                        success: '#28A745',
                        pending: '#BFC4CC',
                        bg: '#F7F8FA',
                        border: '#D1D5DB',
                        focus: '#4055A8',
                    }
                }
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        ::-webkit-scrollbar { display: none; }
        body { font-family: 'Inter', sans-serif; background-color: #F7F8FA; }
        .step-active { background-color: rgba(255, 164, 57, 0.1); border-left: 4px solid #FFA439; }
        .step-inactive { border-left: 4px solid transparent; }
        .toggle-checkbox:checked { right: 0; border-color: #2D3A74; }
        .toggle-checkbox:checked + .toggle-label { background-color: #2D3A74; }
    </style>
@endsection

@section('body')
<body class="text-primary h-screen flex overflow-hidden antialiased">

    <x-merchant.kyc-stepper :active="7" />

    <!-- MAIN CONTENT AREA -->
    <main id="main-content" class="flex-1 h-full overflow-y-auto bg-[#F7F8FA] relative">
        <div class="max-w-5xl mx-auto px-12 py-10 pb-24">
            
            <!-- Page Header -->
            <div id="page-header" class="mb-8">
                <h1 class="text-2xl font-semibold text-primary mb-2">Bank Information</h1>
                <p class="text-gray-500 text-sm">Provide the bank account details where settlement funds should be deposited.</p>
            </div>

            <!-- Alert Banner (Conditional) -->
            <div id="alert-banner" class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-md shadow-sm flex items-start gap-3">
                <i class="fa-solid fa-triangle-exclamation text-yellow-500 mt-0.5"></i>
                <div>
                    <p class="text-sm text-yellow-800 font-medium">Attention Needed</p>
                    <p class="text-sm text-yellow-700 mt-1">Your bank account country differs from your business registration country. Certain acquirers may require additional documentation.</p>
                </div>
            </div>

            <!-- Main Form Card -->
            <div id="bank-info-card" class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
                
                <!-- SECTION A: ACCOUNT DETAILS -->
                <div id="section-account-details" class="mb-8">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6 border-b pb-2">A. Account Details</h3>
                    
                    <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Bank Name <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors" placeholder="e.g. Chase Bank">
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Account Holder Name <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors" placeholder="Full legal name of account holder">
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">IBAN / Account Number <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors font-mono" placeholder="CH93 0000 0000 0000 0000 0">
                        </div>

                        <div class="col-span-1">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-1.5">
                                BIC / SWIFT Code <span class="text-red-500">*</span>
                                <i class="fa-regular fa-circle-question text-gray-400 cursor-help" title="Required by acquirers for settlement transfers."></i>
                            </label>
                            <input type="text" class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors uppercase font-mono" placeholder="SWIFT123">
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Country of Bank Account <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 bg-white appearance-none cursor-pointer">
                                    <option value="" disabled>Select Country</option>
                                    <option value="US">United States</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="DE">Germany</option>
                                    <option value="FR">France</option>
                                    <option value="CH" selected>Switzerland</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Currency of Settlement <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 bg-white appearance-none cursor-pointer">
                                    <option value="USD">USD - US Dollar</option>
                                    <option value="EUR">EUR - Euro</option>
                                    <option value="GBP">GBP - British Pound</option>
                                    <option value="CHF" selected>CHF - Swiss Franc</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION B: BANK ADDRESS -->
                <div id="section-bank-address" class="mb-8">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6 border-b pb-2">B. Bank Address</h3>
                    
                    <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Bank Address Line 1 <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors">
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Bank Address Line 2 <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <input type="text" class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors">
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">City <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors">
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Postal Code <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 transition-colors">
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Country <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select class="w-full h-11 px-3 rounded border border-gray-300 focus:border-focus focus:ring-1 focus:ring-focus outline-none text-sm text-gray-900 bg-gray-50 appearance-none cursor-pointer">
                                    <option value="CH" selected>Switzerland</option>
                                    <option value="other">Other...</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION C: AUTHORIZATION -->
                <div id="section-authorization" class="mb-8">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6 border-b pb-2">C. Authorization</h3>
                    
                    <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Proof of Bank Account Ownership <span class="text-gray-400 font-normal">(Optional)</span></label>
                            
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer group">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-blue-200 transition-colors">
                                    <i class="fa-solid fa-cloud-arrow-up text-primary text-lg"></i>
                                </div>
                                <p class="text-sm text-gray-700 font-medium">Click to upload or drag and drop</p>
                                <p class="text-xs text-gray-500 mt-1">PDF, PNG, or JPG (max. 5MB)</p>
                            </div>

                            <div class="mt-3 flex items-center justify-between p-3 bg-white border border-gray-200 rounded-md shadow-sm">
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
                                    <label class="block text-sm font-medium text-gray-700">Is this account owned by the same legal entity?</label>
                                    <p class="text-xs text-gray-500 mt-1">If the account holder name differs from the registered company name.</p>
                                </div>
                                <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input type="checkbox" name="toggle" id="toggle-entity" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300 checked:right-0 checked:border-primary transition-all duration-300" checked/>
                                    <label for="toggle-entity" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer checked:bg-primary transition-colors duration-300"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION D: VALIDATION -->
                <div id="section-validation" class="mb-2">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6 border-b pb-2">D. Validation</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between py-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Does this account support international transfers?</label>
                            </div>
                            <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle-intl" id="toggle-intl" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300 checked:right-0 checked:border-primary transition-all duration-300" checked/>
                                <label for="toggle-intl" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer checked:bg-primary transition-colors duration-300"></label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between py-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Is this account used exclusively for business operations?</label>
                            </div>
                            <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle-biz" id="toggle-biz" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300 checked:right-0 checked:border-primary transition-all duration-300" checked/>
                                <label for="toggle-biz" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer checked:bg-primary transition-colors duration-300"></label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOOTER ACTIONS -->
        <footer id="footer" class="fixed bottom-0 right-0 w-[calc(100%-260px)] bg-white border-t border-gray-200 px-12 py-4 z-30">
            <div class="max-w-5xl mx-auto flex items-center justify-between">
                <a href="{{ route('merchant.kyc.salesChannels') }}" class="group flex items-center text-primary text-sm font-medium hover:underline">
                    <i class="fa-solid fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                    Back
                </a>

                <div class="flex items-center gap-4">
                    <button class="px-6 py-2.5 border-2 border-secondary text-secondary bg-white rounded-md font-medium text-sm hover:bg-orange-50 transition-colors">
                        Save Draft
                    </button>

                    <a href="{{ route('merchant.kyc.authorizedSignatories') }}" class="px-6 py-2.5 bg-secondary text-white rounded-md font-medium text-sm hover:bg-orange-500 transition-colors flex items-center gap-2 group">
                        Continue to Authorized Signatories
                        <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>
        </footer>

    </main>

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

</body>
@endsection
