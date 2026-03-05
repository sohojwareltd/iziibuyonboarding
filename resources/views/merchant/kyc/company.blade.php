<x-merchant.kyc>
    @push('css')
        <style>
            ::-webkit-scrollbar {
                display: none;
            }
    
            body {
                font-family: 'Inter', sans-serif;
            }
    
            .step-active {
                background: rgba(45, 58, 116, 0.08);
                border-left: 4px solid #FF7C00;
            }
    
            .upload-zone {
                border: 2px dashed #D1D5DB;
                transition: all 0.2s;
            }
    
            .upload-zone:hover {
                border-color: #4055A8;
                background: rgba(64, 85, 168, 0.02);
            }
    
            input:focus,
            select:focus,
            textarea:focus {
                outline: none;
                border-color: #4055A8;
                box-shadow: 0 0 0 3px rgba(64, 85, 168, 0.1);
            }
    
            .error-field {
                border-color: #E74C3C;
            }
    
            .toast {
                animation: slideIn 0.3s ease-out;
            }
    
            @keyframes slideIn {
                from {
                    transform: translateY(-100%);
                    opacity: 0;
                }
    
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
        </style>
    @endpush
    
    <div id="page-header" class="mb-8">
        <h1 class="text-xl sm:text-2xl md:text-[28px] font-bold text-brand-dark mb-2">{{ $section->name }}</h1>
        <p class="text-sm sm:text-[15px] text-[#6A6A6A]">{{ $section->description }}</p>
    </div>

    <form id="kyc-form" method="POST" action="{{ route('merchant.kyc.section.fields.save', ['kyc_link' => $kyc_link, 'section' => $section->slug]) }}">
        @csrf
        <input type="hidden" name="onboarding_id" value="{{ $onboarding_id }}">

        @if($fields->isNotEmpty())
            <section class="mb-10">
                <h2 class="text-xl font-semibold text-brand-dark mb-6">{{ $section->name }}</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    @foreach($fields as $field)
                   
                        @php
                            // Determine column span based on field type
                            $colSpan = in_array($field->data_type, ['textarea', 'address', 'file']) ? 'col-span-2' : '';
                        @endphp
                        <div class="{{ $colSpan }}">
                            <x-kyc-field :field="$field" :value="$savedValues[$field->id] ?? null" />
                        </div>
                    @endforeach
                </div>
            </section>
        @else
            <section class="mb-10">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                    <i class="fa-solid fa-exclamation-triangle text-yellow-600 text-3xl mb-3"></i>
                    <p class="text-yellow-800 font-medium">No fields configured for this section</p>
                    <p class="text-yellow-600 text-sm mt-1">Please contact the administrator to configure KYC fields.</p>
                </div>
            </section>
        @endif

        <footer id="footer"
            class="fixed bottom-0 right-0 w-full md:w-[calc(100%-260px)] bg-white border-t border-brand-border px-4 sm:px-6 md:px-12 py-3 sm:py-4 z-30">
            <div class="max-w-[900px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <a href="{{ route('merchant.kyc.company', ['kyc_link' => $kyc_link]) }}"
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
            async function submitCompanySection(redirectAfterSave = false) {
                const form = document.getElementById('kyc-form');
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

                    showToast('Company information saved.', 'success');

                    if (redirectAfterSave) {
                        window.location.href = '{{ route('merchant.kyc.beneficialOwners', ['kyc_link' => $kyc_link]) }}';
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
