<x-merchant.kyc>
    <div id="page-header" class="mb-8">
        <h1 class="text-xl sm:text-2xl md:text-[28px] font-bold text-brand-dark mb-2">{{ $section->name }}</h1>
        <p class="text-sm sm:text-[15px] text-[#6A6A6A]">{{ $section->description }}</p>
    </div>

    <form id="kyc-form" method="POST" action="{{ route('merchant.kyc.company.save', ['kyc_link' => $kyc_link]) }}">
        @csrf
        <input type="hidden" name="onboarding_id" value="{{ $onboarding_id }}">

        @if($onboarding)
            <!-- Company Information Section -->
            <section class="mb-10">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Company Legal Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Company Legal Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="legal_business_name"
                            value="{{ old('legal_business_name', $onboarding->legal_business_name ?? '') }}"
                            class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                            placeholder="e.g. Acme Trading Ltd" required>
                    </div>

                    <!-- Company Registration Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Company Registration Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="registration_number"
                            value="{{ old('registration_number', $onboarding->registration_number ?? '') }}"
                            class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                            placeholder="e.g. 12345678" required>
                    </div>

                    <!-- Company Tax ID (VAT) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Company Tax ID (VAT) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tax_id_vat"
                            value="{{ old('tax_id_vat', $onboarding->tax_id_vat ?? '') }}"
                            class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                            placeholder="e.g. GB123456789" required>
                    </div>

                    <!-- Company Name (DBA) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Company Name (DBA - Doing Business As) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="trading_name"
                            value="{{ old('trading_name', $onboarding->trading_name ?? '') }}"
                            class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                            placeholder="e.g. Acme Coffee" required>
                    </div>

                    <!-- Company Address (DBA) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Company Address (DBA) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="dba_address"
                            value="{{ old('dba_address', $onboarding->dba_address ?? '') }}"
                            class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                            placeholder="e.g. 123 Main Street" required>
                    </div>

                    <!-- Company ZIP Code (DBA) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Company ZIP Code (DBA)
                        </label>
                        <input type="text" name="dba_zip_code"
                            value="{{ old('dba_zip_code', $onboarding->dba_zip_code ?? '') }}"
                            class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                            placeholder="e.g. SW1A 1AA">
                    </div>

                    <!-- Company City (DBA) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Company City (DBA)
                        </label>
                        <input type="text" name="dba_city"
                            value="{{ old('dba_city', $onboarding->dba_city ?? '') }}"
                            class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                            placeholder="e.g. London">
                    </div>

                    <!-- Business Website -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Business Website
                        </label>
                        <div class="flex">
                            <div class="bg-gray-50 border border-r-0 border-gray-300 rounded-l-md px-3 flex items-center text-sm text-gray-600">
                                https://
                            </div>
                            <input type="text" name="business_website"
                                value="{{ old('business_website', $onboarding->business_website ?? '') }}"
                                class="flex-1 h-[39px] px-4 border border-gray-300 rounded-r-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                                placeholder="www.example.com">
                        </div>
                    </div>
                 

                    <!-- Company Contact Email (Readonly) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Company Contact Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="email"
                                value="{{ $onboarding->merchant_contact_email ?? '' }}"
                                class="w-full h-[39px] pl-10 pr-4 bg-gray-100 border border-gray-300 rounded-md text-sm text-gray-700 cursor-not-allowed"
                                readonly>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">This email cannot be changed</p>
                    </div>

                    <!-- Company Phone Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Company Phone Number
                        </label>
                        <input type="tel" name="merchant_phone_number"
                            value="{{ old('merchant_phone_number', $onboarding->merchant_phone_number ?? '') }}"
                            class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                            placeholder="+44 7700 900000">
                    </div>
                </div>
            </section>
        @endif

        {{-- @if($fields->isNotEmpty())
            <section class="mb-10">
                <h2 class="text-xl font-semibold text-brand-dark mb-6">Additional Company Details</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    @foreach($fields as $field)
                        @php
                            $colSpan = in_array($field->data_type, ['textarea', 'address', 'file']) ? 'col-span-2' : '';
                        @endphp
                        <div class="{{ $colSpan }}">
                            <x-kyc-field :field="$field" :value="$savedValues[$field->id] ?? null" />
                        </div>
                    @endforeach
                </div>
            </section>
        @endif --}}

        <footer
            class="fixed bottom-0 right-0 w-full md:w-[calc(100%-260px)] bg-white border-t border-brand-border px-4 sm:px-6 md:px-12 py-3 sm:py-4 z-30">
            <div class="max-w-[900px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <a href="{{ route('merchant.kyc.start', ['kyc_link' => $kyc_link]) }}"
                    class="w-full sm:w-auto px-4 sm:px-6 py-2.5 border border-brand-dark text-brand-dark bg-white hover:bg-gray-50 font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                    <span>Back</span>
                </a>

                <div class="flex items-center gap-2 sm:gap-4 w-full sm:w-auto">
                    <button type="button" onclick="saveDraft()"
                        class="flex-1 sm:flex-none px-3 sm:px-6 py-2.5 border border-brand-orange text-brand-orange bg-white hover:bg-orange-50 font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-xs sm:text-sm">
                        <i class="fa-regular fa-floppy-disk text-sm hidden sm:inline"></i>
                        <span>Draft</span>
                    </button>

                    <button type="button" onclick="saveAndContinue()"
                        class="flex-1 sm:flex-none px-4 sm:px-8 py-2.5 bg-brand-orange hover:bg-brand-orangeHover text-white font-semibold rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-xs sm:text-base">
                        <span>Continue</span>
                        <i class="fa-solid fa-arrow-right text-sm hidden sm:inline"></i>
                    </button>
                </div>
            </div>
        </footer>
    </form>

    @push('js')
        <script>
            function validateVisibleFields(form) {
                const controls = Array.from(form.querySelectorAll('input, select, textarea'));
                const isNativeValid = form.reportValidity();

                if (!isNativeValid) {
                    return false;
                }

                return true;
            }

            async function submitCompanySection(redirectAfterSave = false) {
                const form = document.getElementById('kyc-form');

                // Enforce native HTML required validation before continue.
                if (redirectAfterSave && !validateVisibleFields(form)) {
                    return;
                }

                const formData = new FormData(form);

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        showToast(data.message || 'Unable to save company information.', 'error');
                        return;
                    }

                    if (redirectAfterSave) {
                        @if($nextSection)
                            window.location.href = '{{ route('merchant.kyc.section', ['kyc_link' => $kyc_link, 'section' => $nextSection->slug]) }}';
                        @else
                            window.location.href = '{{ route('merchant.kyc.beneficialOwners', ['kyc_link' => $kyc_link]) }}';
                        @endif
                    }
                } catch (error) {
                    showToast('Something went wrong while saving.', 'error');
                }
            }

            function saveDraft() {
                submitCompanySection(false);
            }

            function saveAndContinue() {
                submitCompanySection(true);
            }
        </script>
    @endpush
</x-merchant.kyc>
