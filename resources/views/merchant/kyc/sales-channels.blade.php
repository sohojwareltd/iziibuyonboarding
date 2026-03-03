<x-merchant.kyc>
    @push('css')
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #F7F8FA;
            }

            ::-webkit-scrollbar {
                width: 6px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
            }

            ::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            .step-item {
                display: flex;
                align-items: center;
                padding: 12px 24px;
                position: relative;
                font-size: 14px;
                color: #6B7280;
            }

            .step-item.completed {
                color: #2D3A74;
            }

            .step-item.active {
                background-color: #FFF8F0;
                color: #111827;
                font-weight: 600;
            }

            .step-item.active::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                width: 4px;
                background-color: #FFA439;
            }

            .step-icon {
                width: 24px;
                text-align: center;
                margin-right: 12px;
                font-size: 16px;
            }

            .completed .step-icon {
                color: #28A745;
            }

            .active .step-icon {
                color: #FFA439;
                font-size: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 20px;
                width: 20px;
                border: 2px solid #FFA439;
                border-radius: 50%;
                background: #FFA439;
                color: white;
            }

            .pending .step-icon {
                color: #BFC4CC;
                font-size: 18px;
            }

            .form-checkbox {
                width: 18px;
                height: 18px;
                border-radius: 4px;
                border: 1px solid #D1D5DB;
                color: #2D3A74;
            }

            .form-input {
                width: 100%;
                border: 1px solid #D1D5DB;
                border-radius: 6px;
                padding: 10px 12px;
                font-size: 14px;
                transition: all 0.2s;
                outline: none;
            }

            .form-input:focus {
                border-color: #4055A8;
                box-shadow: 0 0 0 3px rgba(64, 85, 168, 0.1);
            }

            .form-label {
                display: block;
                font-size: 14px;
                font-weight: 500;
                color: #374151;
                margin-bottom: 6px;
            }

            .form-helper {
                font-size: 12px;
                color: #6B7280;
                margin-top: 4px;
            }

            .toggle-checkbox:checked {
                right: 0;
                border-color: #2D3A74;
            }

            .toggle-checkbox:checked+.toggle-label {
                background-color: #2D3A74;
            }
        </style>
    @endpush

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-[24px] font-semibold text-primary mb-2">{{ $section->name }}</h1>
        <p class="text-gray-500">{{ $section->description }}</p>
    </div>
    <form id="sc-form">

        <!-- SALES CHANNELS CARD -->
        <div id="sales-channels-card" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">

            @if ($fields->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($fields as $field)
                        @php
                            $colSpan = in_array($field->data_type, ['textarea', 'address', 'file'])
                                ? 'md:col-span-2'
                                : '';
                        @endphp
                        <div class="{{ $colSpan }}">
                            <x-kyc-field :field="$field" :value="old($field->internal_key)" />
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                    <i class="fa-solid fa-exclamation-triangle text-yellow-600 text-3xl mb-3"></i>
                    <p class="text-yellow-800 font-medium">No fields configured for this section</p>
                    <p class="text-yellow-600 text-sm mt-1">Please contact the administrator to configure KYC fields.
                    </p>
                </div>
            @endif

        </div>

        <footer id="footer"
            class="fixed bottom-0 right-0 w-full md:w-[calc(100%-260px)] bg-white border-t border-brand-border px-4 sm:px-6 md:px-12 py-3 sm:py-4 z-30">
            <div class="max-w-[900px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <a href="{{ route('merchant.kyc.purposeOfService', ['kyc_link' => $kyc_link]) }}"
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

                    <a href="{{ route('merchant.kyc.bankInformation', ['kyc_link' => $kyc_link]) }}"
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
            let locationCounter = 1;

            function toggleSection(sectionId, show) {
                const section = document.getElementById(sectionId);
                const container = document.getElementById('conditional-fields-container');

                if (show) {
                    section.classList.remove('hidden');
                    container.classList.remove('hidden');
                } else {
                    section.classList.add('hidden');

                    const visibleSections = container.querySelectorAll('[id$="-details"]:not(.hidden)');
                    if (visibleSections.length === 0) {
                        container.classList.add('hidden');
                    }
                }
            }

            function addPhysicalLocation() {
                locationCounter++;
                const container = document.getElementById('physical-locations-container');
                const newLocation = document.createElement('div');
                newLocation.className = 'bg-gray-50 rounded-lg p-5 border border-gray-200 mb-4 location-item';
                newLocation.setAttribute('data-location', locationCounter);
                newLocation.innerHTML = `
                    <div class="flex justify-between items-start mb-4">
                        <h4 class="font-medium text-gray-700">Location #${locationCounter}</h4>
                        <button type="button" class="text-gray-400 hover:text-red-500" onclick="removeLocation(this)">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <textarea name="physical_locations[${locationCounter - 1}][address]" class="form-input h-24 resize-none" placeholder="Enter full address..." required></textarea>
                    </div>
                `;
                container.appendChild(newLocation);
                updateDeleteButtons();
            }

            function removeLocation(button) {
                const locationItem = button.closest('.location-item');
                locationItem.remove();
                reindexLocations();
                updateDeleteButtons();
            }

            function reindexLocations() {
                const locations = document.querySelectorAll('.location-item');
                locations.forEach((location, index) => {
                    const heading = location.querySelector('h4');
                    heading.textContent = `Location #${index + 1}`;
                    const textarea = location.querySelector('textarea');
                    textarea.name = `physical_locations[${index}][address]`;
                    location.setAttribute('data-location', index + 1);
                });
                locationCounter = locations.length;
            }

            function updateDeleteButtons() {
                const locations = document.querySelectorAll('.location-item');
                locations.forEach((location, index) => {
                    const deleteBtn = location.querySelector('button[onclick*="removeLocation"]');
                    if (deleteBtn) {
                        deleteBtn.style.display = locations.length > 1 ? 'block' : 'none';
                    }
                });
            }

            function updatePhysicalLocations(count) {
                const currentCount = document.querySelectorAll('.location-item').length;
                const targetCount = parseInt(count) || 1;

                if (targetCount > currentCount) {
                    for (let i = currentCount; i < targetCount; i++) {
                        addPhysicalLocation();
                    }
                } else if (targetCount < currentCount) {
                    const locations = document.querySelectorAll('.location-item');
                    for (let i = currentCount - 1; i >= targetCount; i--) {
                        locations[i].remove();
                    }
                    reindexLocations();
                }
                updateDeleteButtons();
            }

            function validatePercentages() {
                const instore = parseFloat(document.querySelector('input[name="sales_instore_percent"]').value) || 0;
                const online = parseFloat(document.querySelector('input[name="sales_online_percent"]').value) || 0;
                const other = parseFloat(document.querySelector('input[name="sales_other_percent"]').value) || 0;
                const total = instore + online + other;

                const inputs = document.querySelectorAll('input[name*="sales_"][name*="_percent"]');
                if (total !== 100 && total > 0) {
                    inputs.forEach(input => {
                        input.setCustomValidity(`Total must equal 100% (currently ${total}%)`);
                    });
                } else {
                    inputs.forEach(input => {
                        input.setCustomValidity('');
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('input[name="channels"]').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const anyChecked = Array.from(document.querySelectorAll(
                            'input[name="channels"]')).some(
                            cb => cb.checked);
                        const continueBtn = document.getElementById('continue-btn');
                        if (continueBtn) {
                            continueBtn.classList.toggle('opacity-50', !anyChecked);
                            continueBtn.classList.toggle('cursor-not-allowed', !anyChecked);
                            if (!anyChecked) {
                                continueBtn.style.pointerEvents = 'none';
                            } else {
                                continueBtn.style.pointerEvents = 'auto';
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
</x-merchant.kyc>
