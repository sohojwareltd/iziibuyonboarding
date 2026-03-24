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

            .step-completed {
                border-left: 4px solid #27AE60;
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

            .modal {
                animation: fadeIn 0.2s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }
        </style>
    @endpush

    <div id="page-header" class="mb-8">
        <h1 class="text-xl sm:text-2xl font-bold text-brand-dark mb-2">{{ $section->name }}</h1>
        <p class="text-[15px] text-[#6A6A6A]">{{ $section->description }}</p>
    </div>

    <div id="info-banner" class="bg-[#FFF6E8] border-l-4 border-brand-orange p-4 rounded-lg mb-8">
        <p class="text-[13px] font-medium text-[#8A6C1A]">
            <i class="fa-solid fa-info-circle mr-2"></i>
            According to EU AML regulations, you must declare all individuals with 25% or more ownership.
        </p>
    </div>

    @php
        $ownerGroups = !empty($savedGroups) ? $savedGroups : [0 => []];
    @endphp

    <form id="bo-form" method="POST" action="{{ route('merchant.kyc.section.fields.save', ['kyc_link' => $kyc_link, 'section' => $section->slug]) }}">
        @csrf
        <input type="hidden" name="onboarding_id" value="{{ $onboarding_id }}">
        <div id="beneficial-owners-container">

            @foreach ($ownerGroups as $groupIndex => $groupValues)
            <div class="beneficial-owner-card bg-white border border-[#E0E0E0] rounded-xl p-4 sm:p-6 mb-6"
                data-bo-index="{{ $loop->iteration }}">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-brand-dark">Beneficial Owner #{{ $loop->iteration }}</h3>
                    <button type="button"
                        class="remove-bo-btn text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200 {{ count($ownerGroups) > 1 ? '' : 'hidden' }}">
                        <i class="fa-solid fa-trash text-sm"></i>
                    </button>
                </div>

                @if ($fields->isNotEmpty())
                    <div class="space-y-8">
                        <div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                @foreach ($fields as $field)
                                    @php
                                        $colSpan = in_array($field->data_type, ['textarea', 'address', 'file'])
                                            ? 'col-span-2'
                                            : '';
                                    @endphp
                                    <div class="{{ $colSpan }}" data-field-id="{{ $field->id }}" data-field-key="{{ $field->internal_key }}">
                                        <input type="hidden" name="bo_fields[{{ $groupIndex }}][{{ $field->id }}][field_id]" value="{{ $field->id }}">
                                        <input type="hidden" name="bo_fields[{{ $groupIndex }}][{{ $field->id }}][key]" value="{{ $field->internal_key }}">
                                        <x-kyc-field :field="$field" :value="$groupValues[$field->id] ?? null" :nameOverride="'bo_fields[' . $groupIndex . '][' . $field->id . '][value]'" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="space-y-8">

                        <div class="personal-info">
                            <h4 class="text-base font-medium text-brand-dark mb-4">Personal Information</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <x-input.text label="First Name" placeholder="Enter first name"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                        required />
                                </div>
                                <div>
                                    <x-input.text label="Last Name" placeholder="Enter last name"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                        required />
                                </div>
                                <div>
                                    <x-input.date label="Date of Birth"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                        required />
                                </div>
                                <div>
                                    <x-input.select label="Nationality"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                        required placeholder="Select nationality">
                                        <option>Norwegian</option>
                                        <option>Danish</option>
                                        <option>Swedish</option>
                                        <option>Finnish</option>
                                        <option>German</option>
                                        <option>Other</option>
                                    </x-input.select>
                                </div>
                                <div>
                                    <x-input.email placeholder="name@example.com"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm">
                                        <x-slot:label>
                                            Email Address <span class="text-gray-400 text-xs">(Optional)</span>
                                        </x-slot:label>
                                    </x-input.email>
                                </div>
                                <div>
                                    <x-input.tel placeholder="+47 ..."
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm">
                                        <x-slot:label>
                                            Phone Number <span class="text-gray-400 text-xs">(Optional)</span>
                                        </x-slot:label>
                                    </x-input.tel>
                                </div>
                            </div>
                        </div>

                        <div class="identification-info">
                            <h4 class="text-base font-medium text-brand-dark mb-4">Identification Details</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <x-input.select label="Identification Type"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                        required placeholder="Select ID type">
                                        <option>Passport</option>
                                        <option>National ID</option>
                                        <option>Driver's License</option>
                                    </x-input.select>
                                </div>
                                <div>
                                    <x-input.text label="Identification Number" placeholder="Enter ID number"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                        required />
                                </div>
                                <div>
                                    <x-input.date label="ID Expiry Date"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                        required />
                                </div>
                                <div>
                                    <x-input.select label="Country of Issue"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                        required placeholder="Select country">
                                        <option>Norway</option>
                                        <option>Denmark</option>
                                        <option>Sweden</option>
                                        <option>Finland</option>
                                        <option>Germany</option>
                                        <option>Other</option>
                                    </x-input.select>
                                </div>
                            </div>
                        </div>

                        <div class="ownership-info">
                            <h4 class="text-base font-medium text-brand-dark mb-4">Ownership Details</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <x-input.number label="Ownership Percentage" placeholder="25" suffix="%"
                                        min="1" max="100"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm ownership-percentage"
                                        required />
                                </div>
                                <div></div>
                                <div class="col-span-2">
                                    <x-input.text label="Address Line 1" placeholder="Street address"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                        required />
                                </div>
                                <div class="col-span-2">
                                    <x-input.text placeholder="Apartment, suite, unit, etc."
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm">
                                        <x-slot:label>
                                            Address Line 2 <span class="text-gray-400 text-xs">(Optional)</span>
                                        </x-slot:label>
                                    </x-input.text>
                                </div>
                                <div>
                                    <x-input.text label="City" placeholder="City name"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                        required />
                                </div>
                                <div>
                                    <x-input.text label="Postal Code" placeholder="Postal code"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                        required />
                                </div>
                                <div>
                                    <x-input.select label="Country"
                                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                        required placeholder="Select country">
                                        <option>Norway</option>
                                        <option>Denmark</option>
                                        <option>Sweden</option>
                                        <option>Finland</option>
                                        <option>Germany</option>
                                        <option>Other</option>
                                    </x-input.select>
                                </div>
                            </div>
                        </div>

                        <div class="documents-section">
                            <h4 class="text-base font-medium text-brand-dark mb-4">Document Uploads</h4>
                            <div class="space-y-4">
                                <x-input.file-upload label="Proof of Identity" accept=".pdf,.jpg,.jpeg,.png"
                                    maxSize="5MB" required />

                                <x-input.file-upload label="Proof of Address" accept=".pdf,.jpg,.jpeg,.png"
                                    maxSize="5MB" required />
                            </div>
                        </div>

                    </div>
                @endif
            </div>
            @endforeach

        </div>

        <div class="text-center mb-8">
            <button type="button" id="add-bo-btn"
                class="inline-flex items-center gap-2 px-8 py-2.5 border border-brand-accent text-brand-accent bg-white hover:bg-blue-50 font-medium rounded-lg transition-colors duration-200">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>Add Another Beneficial Owner</span>
            </button>
        </div>

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

    <div id="toast-container" class="fixed top-6 right-6 z-50"></div>

    <div id="confirmation-modal"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="modal bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="text-center">
                <i class="fa-solid fa-triangle-exclamation text-4xl text-yellow-500 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Remove Beneficial Owner</h3>
                <p class="text-sm text-gray-600 mb-6">Are you sure you want to remove this beneficial owner? This
                    action cannot be undone.</p>
                <div class="flex gap-3 justify-center">
                    <button onclick="cancelRemove()"
                        class="px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg font-medium">
                        Cancel
                    </button>
                    <button onclick="confirmRemove()"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium">
                        Remove
                    </button>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            let boCount = document.querySelectorAll('.beneficial-owner-card').length || 1;
            let boToRemove = null;
            let uploadZoneEventsBound = false;

            window.addEventListener('load', function() {
                setupUploadZones();
                updateRemoveButtons();
                setupOwnershipValidation();
                syncBeneficialOwnerFieldMeta();
            });

            function syncBeneficialOwnerFieldMeta() {
                document.querySelectorAll('.beneficial-owner-card').forEach((card, index) => {
                    card.querySelectorAll('[data-field-id][data-field-key]').forEach(wrapper => {
                        const fieldId = wrapper.dataset.fieldId;
                        const fieldKey = wrapper.dataset.fieldKey;

                        if (!fieldId || !fieldKey) {
                            return;
                        }

                        const expectedFieldIdName = `bo_fields[${index}][${fieldId}][field_id]`;
                        const expectedKeyName = `bo_fields[${index}][${fieldId}][key]`;

                        let fieldIdInput = wrapper.querySelector('input[type="hidden"][name$="[field_id]"]');
                        if (!fieldIdInput) {
                            fieldIdInput = document.createElement('input');
                            fieldIdInput.type = 'hidden';
                            wrapper.prepend(fieldIdInput);
                        }
                        fieldIdInput.name = expectedFieldIdName;
                        fieldIdInput.value = fieldId;

                        let keyInput = wrapper.querySelector('input[type="hidden"][name$="[key]"]');
                        if (!keyInput) {
                            keyInput = document.createElement('input');
                            keyInput.type = 'hidden';
                            fieldIdInput.insertAdjacentElement('afterend', keyInput);
                        }
                        keyInput.name = expectedKeyName;
                        keyInput.value = fieldKey;
                    });
                });
            }

            function escapeHtml(value) {
                return String(value || '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/\"/g, '&quot;')
                    .replace(/'/g, '&#39;');
            }

            function ensureZoneTemplate(zone) {
                if (!zone || zone.dataset.originalTemplate) {
                    return;
                }

                zone.dataset.originalTemplate = zone.innerHTML;
            }

            function restoreUploadZone(zone) {
                if (!zone) {
                    return;
                }

                if (zone.dataset.originalTemplate) {
                    zone.innerHTML = zone.dataset.originalTemplate;
                }

                zone.classList.remove('bg-green-50', 'border-green-300');
            }

            function setupUploadZones() {
                document.querySelectorAll('.upload-zone').forEach(zone => ensureZoneTemplate(zone));

                if (uploadZoneEventsBound) {
                    return;
                }

                uploadZoneEventsBound = true;

                document.addEventListener('click', function(e) {
                    if (e.target.closest('[data-remove-file]')) {
                        return;
                    }

                    if (e.target.closest('.upload-zone')) {
                        const zone = e.target.closest('.upload-zone');
                        ensureZoneTemplate(zone);
                        const input = zone.querySelector('input[type="file"]');
                        if (input) {
                            input.click();
                        }
                    }
                });

                document.addEventListener('change', function(e) {
                    if (e.target.type === 'file' && e.target.files.length > 0) {
                        const input = e.target;
                        const zone = input.closest('.upload-zone');
                        ensureZoneTemplate(zone);

                        const fileName = input.files[0].name;
                        const inputName = input.getAttribute('name') || '';
                        const accept = input.getAttribute('accept') || '';
                        const isRequired = input.hasAttribute('required');

                        zone.innerHTML = `
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-file-pdf text-2xl text-brand-orange"></i>
                                    <div class="text-left">
                                        <p class="text-sm font-medium text-gray-900">${escapeHtml(fileName)}</p>
                                        <p class="text-xs text-gray-500">Uploaded successfully</p>
                                    </div>
                                </div>
                                <button type="button" data-remove-file="1" onclick="removeFile(this)" class="text-red-500 hover:text-red-700">
                                    <i class="fa-solid fa-trash text-sm"></i>
                                </button>
                            </div>
                            <input type="file" class="hidden" name="${escapeHtml(inputName)}" accept="${escapeHtml(accept)}" ${isRequired ? 'required' : ''}>
                        `;
                        zone.classList.add('bg-green-50', 'border-green-300');

                        const refreshedInput = zone.querySelector('input[type="file"]');
                        if (refreshedInput && input.files.length > 0) {
                            const transfer = new DataTransfer();
                            transfer.items.add(input.files[0]);
                            refreshedInput.files = transfer.files;
                        }
                    }
                });
            }

            function setupOwnershipValidation() {
                document.addEventListener('input', function(e) {
                    if (e.target.classList.contains('ownership-percentage')) {
                        validateOwnershipTotal();
                    }
                });
            }

            function validateOwnershipTotal() {
                const percentageInputs = document.querySelectorAll('.ownership-percentage');
                let total = 0;

                percentageInputs.forEach(input => {
                    const value = parseFloat(input.value) || 0;
                    total += value;
                });

                percentageInputs.forEach(input => {
                    if (total > 100) {
                        input.classList.add('error-field');
                    } else {
                        input.classList.remove('error-field');
                    }
                });
            }

            document.getElementById('add-bo-btn').addEventListener('click', function() {
                boCount++;
                const container = document.getElementById('beneficial-owners-container');
                const newBOCard = createBOCard(boCount);
                container.appendChild(newBOCard);
                updateRemoveButtons();
                setupUploadZones();
                newBOCard.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });

            function createBOCard(index) {
                // Clone the first beneficial owner card
                const firstCard = document.querySelector('.beneficial-owner-card');
                const newCard = firstCard.cloneNode(true);

                // Update the card index and title
                newCard.setAttribute('data-bo-index', index);
                newCard.querySelector('h3').textContent = `Beneficial Owner #${index}`;

                // Show the remove button
                newCard.querySelector('.remove-bo-btn').classList.remove('hidden');

                // Clear all input values
                newCard.querySelectorAll('input').forEach(input => {
                    if (input.type === 'hidden') {
                        return;
                    }

                    if (input.type === 'file') {
                        input.value = '';
                    } else if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });

                // Reset all select elements to first option
                newCard.querySelectorAll('select').forEach(select => {
                    select.selectedIndex = 0;
                });

                // Clear all textarea values
                newCard.querySelectorAll('textarea').forEach(textarea => {
                    textarea.value = '';
                });

                // Reset any file upload zones
                newCard.querySelectorAll('.upload-zone').forEach(zone => {
                    restoreUploadZone(zone);
                });

                // Update field names to include array index for better form handling
                newCard.querySelectorAll('[name]').forEach(field => {
                    const fieldName = field.getAttribute('name');
                    // Update name to include index (e.g., field_name[0] becomes field_name[1])
                    const updatedName = fieldName.replace(/\[\d+\]/, `[${index - 1}]`) || `${fieldName}[${index - 1}]`;
                    field.setAttribute('name', updatedName);
                });

                return newCard;
            }

            function updateRemoveButtons() {
                const cards = document.querySelectorAll('.beneficial-owner-card');
                const removeButtons = document.querySelectorAll('.remove-bo-btn');

                removeButtons.forEach((btn) => {
                    if (cards.length > 1) {
                        btn.classList.remove('hidden');
                        btn.onclick = function() {
                            boToRemove = btn.closest('.beneficial-owner-card');
                            document.getElementById('confirmation-modal').classList.remove('hidden');
                        };
                    } else {
                        btn.classList.add('hidden');
                    }
                });
            }

            function confirmRemove() {
                if (boToRemove) {
                    boToRemove.remove();
                    boToRemove = null;
                    document.getElementById('confirmation-modal').classList.add('hidden');
                    updateRemoveButtons();
                    renumberBOCards();
                    validateOwnershipTotal();
                }
            }

            function cancelRemove() {
                boToRemove = null;
                document.getElementById('confirmation-modal').classList.add('hidden');
            }

            function renumberBOCards() {
                const cards = document.querySelectorAll('.beneficial-owner-card');
                cards.forEach((card, index) => {
                    card.querySelector('h3').textContent = `Beneficial Owner #${index + 1}`;
                    card.setAttribute('data-bo-index', index + 1);

                    card.querySelectorAll('[name]').forEach(field => {
                        const name = field.getAttribute('name');
                        if (!name) {
                            return;
                        }
                        field.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                    });
                });

                boCount = cards.length;
                syncBeneficialOwnerFieldMeta();
            }

            function removeFile(btn) {
                const zone = btn.closest('.upload-zone');
                restoreUploadZone(zone);
            }

            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className =
                    `toast bg-white border-l-4 ${type === 'success' ? 'border-green-500' : 'border-red-500'} rounded-lg shadow-lg p-4 mb-3`;
                toast.innerHTML = `
                    <div class="flex items-center gap-3">
                        <i class="fa-solid ${type === 'success' ? 'fa-check-circle text-green-500' : 'fa-exclamation-circle text-red-500'} text-xl"></i>
                        <p class="text-sm font-medium text-gray-900">${message}</p>
                    </div>
                `;

                document.getElementById('toast-container').appendChild(toast);

                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            async function submitBeneficialOwners(redirectAfterSave = false) {
                const form = document.getElementById('bo-form');
                syncBeneficialOwnerFieldMeta();
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
                        showToast(data.message || 'Unable to save beneficial owners information.', 'error');
                        return;
                    }

                    showToast('Beneficial owners information saved.', 'success');

                    if (redirectAfterSave) {
                        window.location.href = '{{ route('merchant.kyc.boardMembers', ['kyc_link' => $kyc_link]) }}';
                    }
                } catch (error) {
                    showToast('Something went wrong while saving.', 'error');
                }
            }

            function saveDraft() {
                submitBeneficialOwners(false);
            }

            function saveAndContinue() {
                submitBeneficialOwners(true);
            }
        </script>
    @endpush
</x-merchant.kyc>
