<x-merchant.kyc>

    @push('css')
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #F7F8FA;
            }

            /* Custom scrollbar for main content */
            ::-webkit-scrollbar {
                width: 6px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
            }

            ::-webkit-scrollbar-thumb {
                background: #E5E7EB;
                border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #D1D5DB;
            }

            /* Checkbox/Radio custom styles */
            .custom-checkbox:checked {
                background-color: #2D3A74;
                border-color: #2D3A74;
            }
        </style>
    @endpush
    <!-- HEADER -->
    <header id="page-header" class="mb-8">
        <h1 class="text-2xl font-semibold text-primary mb-2">{{ $section->name }}</h1>
        <p class="text-slate-500 text-sm">{{ $section->description }}</p>
    </header>

    @php
        $signatoryGroups = !empty($savedGroups) ? $savedGroups : [0 => []];
    @endphp

    <form id="authorized-signatories-form" method="POST" action="{{ route('merchant.kyc.section.fields.save', ['kyc_link' => $kyc_link, 'section' => $section->slug]) }}">
        @csrf
        <input type="hidden" name="onboarding_id" value="{{ $onboarding_id }}">
        <div id="authorized-signatories-container">
            @if ($fields->isNotEmpty())
                @foreach ($signatoryGroups as $groupIndex => $groupValues)
                <section id="signatory-card-1"
                    class="authorized-signatory-card bg-white rounded-lg shadow-sm border border-gray-100 p-4 sm:p-6 mb-6">

                    <!-- Card Header -->
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 sm:mb-6 pb-4 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-slate-800">Authorized Signatory #{{ $loop->iteration }}</h2>
                        <button class="remove-signatory-btn text-slate-400 hover:text-red-500 transition-colors"
                            title="Remove Signatory" type="button" style="{{ count($signatoryGroups) > 1 ? 'display:block;' : 'display:none;' }}">
                            <i class="fa-regular fa-trash-can text-lg"></i>
                        </button>
                    </div>

                    <!-- Dynamic Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($fields as $field)
                            @php
                                $colSpan = in_array($field->data_type, ['textarea', 'address', 'file'])
                                    ? 'md:col-span-2'
                                    : '';
                            @endphp
                            <div class="{{ $colSpan }}">
                                <input type="hidden" name="as_fields[{{ $groupIndex }}][{{ $field->id }}][field_id]" value="{{ $field->id }}">
                                <input type="hidden" name="as_fields[{{ $groupIndex }}][{{ $field->id }}][key]" value="{{ $field->internal_key }}">
                                <x-kyc-field :field="$field" :value="$groupValues[$field->id] ?? null" :nameOverride="'as_fields[' . $groupIndex . '][' . $field->id . '][value]'" />
                            </div>
                        @endforeach
                    </div>

                </section>
                @endforeach
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                    <i class="fa-solid fa-exclamation-triangle text-yellow-600 text-3xl mb-3"></i>
                    <p class="text-yellow-800 font-medium">No fields configured for this section</p>
                    <p class="text-yellow-600 text-sm mt-1">Please contact the administrator to configure KYC fields.
                    </p>
                </div>
            @endif
        </div>

        <div class="text-center mb-8 mt-4">
            <button type="button" id="add-authorized-signatory-btn"
                class="inline-flex items-center gap-2 px-8 py-2.5 border border-brand-accent text-brand-accent bg-white hover:bg-blue-50 font-medium rounded-lg transition-colors duration-200">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>Add Another Authorized Signatory</span>
            </button>
        </div>

        <footer id="footer"
            class="fixed bottom-0 right-0 w-full md:w-[calc(100%-260px)] bg-white border-t border-brand-border px-4 sm:px-6 md:px-12 py-3 sm:py-4 z-30">
            <div class="max-w-[900px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <a href="{{ route('merchant.kyc.bankInformation', ['kyc_link' => $kyc_link]) }}"
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

                    <button type="button" onclick="saveAndReview()"
                        class="flex-1 sm:flex-none px-4 sm:px-8 py-2.5 bg-brand-orange hover:bg-brand-orangeHover text-white font-semibold rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-xs sm:text-base">
                        <span>Review & Submit</span>
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
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Remove Authorized Signatory</h3>
                <p class="text-sm text-gray-600 mb-6">Are you sure you want to remove this authorized signatory? This
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
            let signatoryCount = document.querySelectorAll('.authorized-signatory-card').length || 1;
            let signatoryToRemove = null;

            window.addEventListener('load', function() {
                setupUploadZones();
                updateRemoveButtons();
                setupOwnershipValidation();
            });

            function setupUploadZones() {
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.upload-zone')) {
                        const zone = e.target.closest('.upload-zone');
                        const input = zone.querySelector('input[type="file"]');
                        input.click();
                    }
                });

                document.addEventListener('change', function(e) {
                    if (e.target.type === 'file' && e.target.files.length > 0) {
                        const zone = e.target.closest('.upload-zone');
                        const fileName = e.target.files[0].name;
                        zone.innerHTML = `
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-file-pdf text-2xl text-brand-orange"></i>
                                    <div class="text-left">
                                        <p class="text-sm font-medium text-gray-900">${fileName}</p>
                                        <p class="text-xs text-gray-500">Uploaded successfully</p>
                                    </div>
                                </div>
                                <button onclick="removeFile(this)" class="text-red-500 hover:text-red-700">
                                    <i class="fa-solid fa-trash text-sm"></i>
                                </button>
                            </div>
                        `;
                        zone.classList.add('bg-green-50', 'border-green-300');
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

            document.getElementById('add-authorized-signatory-btn').addEventListener('click', function() {
                const container = document.getElementById('authorized-signatories-container');
                const cardCount = container.querySelectorAll('.authorized-signatory-card').length + 1;
                const newCard = createSignatoryCard(cardCount);
                container.appendChild(newCard);
                updateRemoveButtons();
                setupUploadZones();
                newCard.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });

            function createSignatoryCard(index) {
                const template = document.querySelector('.authorized-signatory-card');
                const clone = template.cloneNode(true);

                clone.id = `signatory-card-${index}`;
                clone.querySelector('h2').textContent = `Authorized Signatory #${index}`;

                const resetUploadZone = (zone) => {
                    zone.classList.remove('bg-green-50', 'border-green-300');
                    zone.innerHTML = `
                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-slate-400 mb-3"></i>
                        <p class="text-sm font-medium text-slate-700 mb-1">Click to upload or drag and drop</p>
                        <p class="text-xs text-slate-500">ID Document, Proof of Address, Authorization Document, Signature Specimen</p>
                        <p class="text-xs text-slate-400 mt-2">PDF, PNG, JPG up to 10MB</p>
                        <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                    `;
                };

                const inputs = clone.querySelectorAll('input');
                inputs.forEach(input => {
                    if (input.type === 'hidden') {
                        return;
                    }

                    const oldId = input.id;
                    if (oldId) {
                        const base = oldId.replace(/-\d+$/, '');
                        const newId = `${base}-${index}`;
                        input.id = newId;
                        const relatedLabel = clone.querySelector(`label[for="${oldId}"]`);
                        if (relatedLabel) relatedLabel.setAttribute('for', newId);
                    }

                    if (input.type === 'checkbox') {
                        input.checked = false;
                    } else if (input.type === 'file') {
                        input.value = '';
                    } else {
                        input.value = '';
                    }

                    input.classList.remove('error-field');
                });

                const selects = clone.querySelectorAll('select');
                selects.forEach(select => {
                    const oldId = select.id;
                    if (oldId) {
                        const base = oldId.replace(/-\d+$/, '');
                        const newId = `${base}-${index}`;
                        select.id = newId;
                        const relatedLabel = clone.querySelector(`label[for="${oldId}"]`);
                        if (relatedLabel) relatedLabel.setAttribute('for', newId);
                    }
                    select.selectedIndex = 0;
                    select.classList.remove('error-field');
                });

                clone.querySelectorAll('.upload-zone').forEach(resetUploadZone);

                clone.querySelectorAll('[name]').forEach(field => {
                    const name = field.getAttribute('name');
                    if (!name) {
                        return;
                    }
                    field.setAttribute('name', name.replace(/\[\d+\]/, `[${index - 1}]`));
                });

                return clone;
            }

            function updateRemoveButtons() {
                const cards = document.querySelectorAll('.authorized-signatory-card');
                const removeButtons = document.querySelectorAll('.remove-signatory-btn');

                removeButtons.forEach((btn) => {
                    if (cards.length > 1) {
                        btn.classList.remove('hidden');
                        btn.onclick = function(e) {
                            e.preventDefault();
                            signatoryToRemove = btn.closest('.authorized-signatory-card');
                            document.getElementById('confirmation-modal').classList.remove('hidden');
                        };
                    } else {
                        btn.classList.add('hidden');
                    }
                });
            }

            function confirmRemove() {
                if (signatoryToRemove) {
                    signatoryToRemove.remove();
                    signatoryToRemove = null;
                    document.getElementById('confirmation-modal').classList.add('hidden');
                    updateRemoveButtons();
                    renumberSignatoryCards();
                }
            }

            function cancelRemove() {
                signatoryToRemove = null;
                document.getElementById('confirmation-modal').classList.add('hidden');
            }

            function renumberSignatoryCards() {
                const cards = document.querySelectorAll('.authorized-signatory-card');
                cards.forEach((card, index) => {
                    card.id = `signatory-card-${index + 1}`;
                    card.querySelector('h2').textContent = `Authorized Signatory #${index + 1}`;

                    card.querySelectorAll('[name]').forEach(field => {
                        const name = field.getAttribute('name');
                        if (!name) {
                            return;
                        }
                        field.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                    });
                });

                signatoryCount = cards.length;
            }

            function removeFile(btn) {
                const zone = btn.closest('.upload-zone');
                zone.innerHTML = `
                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600 mb-1">Drag and drop files here or <span class="text-brand-blue font-medium">browse</span></p>
                    <p class="text-xs text-gray-400">Supported formats: PDF, JPG, PNG (Max 5MB)</p>
                    <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                `;
                zone.classList.remove('bg-green-50', 'border-green-300');
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

            async function submitAuthorizedSignatories(redirectAfterSave = false) {
                const form = document.getElementById('authorized-signatories-form');
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
                        showToast(data.message || 'Unable to save authorized signatories information.', 'error');
                        return;
                    }

                    showToast('Authorized signatories information saved.', 'success');

                    if (redirectAfterSave) {
                        window.location.href = '{{ route('merchant.kyc.review', ['kyc_link' => $kyc_link]) }}';
                    }
                } catch (error) {
                    showToast('Something went wrong while saving.', 'error');
                }
            }

            function saveDraft() {
                submitAuthorizedSignatories(false);
            }

            function saveAndReview() {
                submitAuthorizedSignatories(true);
            }
        </script>
    @endpush
</x-merchant.kyc>
