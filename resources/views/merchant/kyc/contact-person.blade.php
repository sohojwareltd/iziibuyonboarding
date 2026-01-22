
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


    <!-- Header Section -->
    <div id="page-header" class="mb-8">
        <h1 class="text-xl sm:text-2xl font-semibold text-primary mb-2">Contact Person</h1>
        <p class="text-gray-500 text-sm">Provide the details of the person who will be the primary contact for
            this agreement.</p>
    </div>

    <form id="cp-form" action="#" method="POST">

        <!-- Contact Person Card -->
        <div id="contact-person-card" class="bg-white rounded-lg shadow-sm border border-gray-200/60 p-4 sm:p-6">

            <!-- Section A: Personal Information -->
            <section id="section-personal-info" class="mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">Personal
                        Information</h3>
                    <div class="h-px bg-gray-200 w-full"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Full Name -->
                    <div class="col-span-1">
                        <label for="cp-full-name" class="block text-sm font-medium text-primary mb-1.5">Full Name <span
                                class="text-red-500">*</span></label>
                        <x-input.text id="cp-full-name" required placeholder="e.g. John Doe" class="form-input" />
                    </div>

                    <!-- Position -->
                    <div class="col-span-1">
                        <label for="cp-position" class="block text-sm font-medium text-primary mb-1.5">Position <span
                                class="text-red-500">*</span></label>
                        <x-input.text id="cp-position" required placeholder="e.g. Finance Manager" class="form-input" />
                    </div>

                    <!-- Email Address -->
                    <div class="col-span-1">
                        <label for="cp-email" class="block text-sm font-medium text-primary mb-1.5">Email Address <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400"><i class="fa-regular fa-envelope"></i></span>
                            <x-input.email id="cp-email" required placeholder="john.doe@company.com" icon="" class="form-input pl-10" />
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="col-span-1">
                        <label for="cp-phone" class="block text-sm font-medium text-primary mb-1.5">Phone Number <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400"><i class="fa-solid fa-phone"></i></span>
                            <x-input.tel id="cp-phone" required placeholder="+1 (555) 000-0000" icon="" class="form-input pl-10" />
                        </div>
                    </div>

                    <!-- Preferred Contact Method -->
                    <div class="col-span-1">
                        <label for="cp-preferred-method" class="block text-sm font-medium text-primary mb-1.5">Preferred Contact Method <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <x-input.select id="cp-preferred-method" required placeholder="Select method" class="form-input appearance-none cursor-pointer bg-white">
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="both">Both</option>
                            </x-input.select>
                            <span class="absolute right-4 top-3.5 text-gray-400 pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Secondary Phone -->
                    <div class="col-span-1">
                        <label for="cp-secondary-phone" class="block text-sm font-medium text-primary mb-1.5">Secondary Phone <span
                                class="text-gray-400 font-normal">(Optional)</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400"><i class="fa-solid fa-phone"></i></span>
                            <x-input.tel id="cp-secondary-phone" placeholder="+1 (555) 000-0000" icon="" class="form-input pl-10" />
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section B: Address Details -->
            <section id="section-address-details" class="mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">Address
                        Details</h3>
                    <div class="h-px bg-gray-200 w-full"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Address Line 1 -->
                    <div class="col-span-1">
                        <label for="cp-address-line1" class="block text-sm font-medium text-primary mb-1.5">Address Line 1 <span
                                class="text-red-500">*</span></label>
                        <x-input.text id="cp-address-line1" required placeholder="Street address, P.O. box" class="form-input" />
                    </div>

                    <!-- Address Line 2 -->
                    <div class="col-span-1">
                        <label for="cp-address-line2" class="block text-sm font-medium text-primary mb-1.5">Address Line 2 <span
                                class="text-gray-400 font-normal">(Optional)</span></label>
                        <x-input.text id="cp-address-line2" placeholder="Apartment, suite, unit, etc." class="form-input" />
                    </div>

                    <!-- City -->
                    <div class="col-span-1">
                        <label for="cp-city" class="block text-sm font-medium text-primary mb-1.5">City <span
                                class="text-red-500">*</span></label>
                        <x-input.text id="cp-city" required placeholder="City" class="form-input" />
                    </div>

                    <!-- Postal Code -->
                    <div class="col-span-1">
                        <label for="cp-postal" class="block text-sm font-medium text-primary mb-1.5">Postal Code <span
                                class="text-red-500">*</span></label>
                        <x-input.text id="cp-postal" required placeholder="ZIP / Postal Code" class="form-input" />
                    </div>

                    <!-- Country -->
                    <div class="col-span-2">
                        <label for="cp-country" class="block text-sm font-medium text-primary mb-1.5">Country <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <x-input.select id="cp-country" required placeholder="Select Country" class="form-input appearance-none cursor-pointer bg-white">
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="UK">United Kingdom</option>
                                <option value="DE">Germany</option>
                                <option value="FR">France</option>
                            </x-input.select>
                            <span class="absolute right-4 top-3.5 text-gray-400 pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section C: Documents -->
            <section id="section-documents">
                <div class="flex items-center gap-4 mb-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">
                        Documents</h3>
                    <div class="h-px bg-gray-200 w-full"></div>
                </div>

                <div
                    class="upload-zone border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:bg-gray-50 transition-colors cursor-pointer group">
                    <div class="mb-3">
                        <div
                            class="w-12 h-12 rounded-full bg-blue-50 text-primary mx-auto flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                        </div>
                    </div>
                    <h4 class="text-sm font-medium text-primary mb-1">Upload ID Document</h4>
                    <p class="text-xs text-gray-500 mb-4">Drag & drop or click to upload</p>
                    <p class="text-[10px] text-gray-400">Supported formats: PDF, JPG, PNG (Max 5MB)</p>
                    <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </section>

        </div>

        <footer id="footer"
            class="fixed bottom-0 right-0 w-full md:w-[calc(100%-260px)] bg-white border-t border-brand-border px-4 sm:px-6 md:px-12 py-3 sm:py-4 z-30">
            <div class="max-w-[900px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <a href="{{ route('merchant.kyc.boardMembers') }}"
                    class="w-full sm:w-auto px-4 sm:px-6 py-2.5 border border-brand-dark text-brand-dark bg-white hover:bg-gray-50 font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                    <span>Back</span>
                </a>

                <div class="flex items-center gap-2 sm:gap-4 w-full sm:w-auto">
                    <button onclick="saveDraft()"
                        class="flex-1 sm:flex-none px-3 sm:px-6 py-2.5 border border-brand-orange text-brand-orange bg-white hover:bg-orange-50 font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-xs sm:text-sm">
                        <i class="fa-regular fa-floppy-disk text-sm hidden sm:inline"></i>
                        <span>Draft</span>
                    </button>

                    <a href="{{ route('merchant.kyc.purposeOfService') }}"
                        class="flex-1 sm:flex-none px-4 sm:px-8 py-2.5 bg-brand-orange hover:bg-brand-orangeHover text-white font-semibold rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-xs sm:text-base">
                        <span>Continue</span>
                        <i class="fa-solid fa-arrow-right text-sm hidden sm:inline"></i>
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
    @endpush
</x-merchant.kyc>
