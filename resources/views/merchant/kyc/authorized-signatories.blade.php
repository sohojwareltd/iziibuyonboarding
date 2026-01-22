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
        <h1 class="text-2xl font-semibold text-primary mb-2">Authorized Signatories</h1>
        <p class="text-slate-500 text-sm">Provide details of individuals legally authorized to sign agreements
            on behalf of the company.</p>
    </header>

    <!-- INFO BANNER -->
    <div id="info-banner"
        class="mb-8 bg-accent-light border-l-4 border-accent-border p-4 rounded-r-md flex items-start gap-3">
        <i class="fa-solid fa-triangle-exclamation text-accent-border mt-0.5"></i>
        <p class="text-sm text-slate-700 font-medium">Acquirers require details of individuals with legal
            signing authority for compliance verification.</p>
    </div>

    <form id="authorized-signatories-form">
        <div id="authorized-signatories-container">
        <!-- SIGNATORY CARD 1 -->
        <section id="signatory-card-1" class="authorized-signatory-card bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">

            <!-- Card Header -->
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-slate-800">Authorized Signatory #1</h2>
                <button class="remove-signatory-btn text-slate-400 hover:text-red-500 transition-colors" title="Remove Signatory" type="button">
                    <i class="fa-regular fa-trash-can text-lg"></i>
                </button>
            </div>

            <!-- SECTION A: PERSONAL INFO -->
            <div class="mb-8">
                <h3
                    class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                    Personal Information</h3>
                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <!-- First Name -->
                    <div>
                        <x-input.text label="First Name" id="first_name" name="first_name" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm"
                            placeholder="e.g. John" />
                    </div>
                    <!-- Last Name -->
                    <div>
                        <x-input.text label="Last Name" id="last_name" name="last_name" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm"
                            placeholder="e.g. Doe" />
                    </div>
                    <!-- Email -->
                    <div>
                        <x-input.email label="Email Address" id="email" name="email" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm"
                            placeholder="john.doe@company.com" />
                    </div>
                    <!-- Phone -->
                    <div>
                        <x-input.tel label="Phone Number" id="phone" name="phone" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm"
                            placeholder="+1 234 567 8900" />
                    </div>
                    <!-- DOB -->
                    <div>
                        <x-input.date label="Date of Birth" id="dob" name="dob" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm text-slate-600" />
                    </div>
                    <!-- Nationality -->
                    <div>
                        <x-input.select label="Nationality" id="nationality" name="nationality" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm bg-white appearance-none cursor-pointer pr-10">
                            <option value="US">United States</option>
                            <option value="GB">United Kingdom</option>
                            <option value="CA">Canada</option>
                        </x-input.select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500 -mt-9">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION B: ROLE & AUTHORIZATION -->
            <div class="mb-8">
                <h3
                    class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                    Role & Authorization Details</h3>
                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Role -->
                    <div>
                        <x-input.select label="Role in Company" id="role" name="role" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm bg-white appearance-none cursor-pointer pr-10">
                            <option>Director</option>
                            <option>Legal Representative</option>
                            <option>Managing Director</option>
                            <option>Owner</option>
                            <option>Other</option>
                        </x-input.select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500 -mt-9">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>

                    <!-- Start Date -->
                    <div>
                        <x-input.date label="Start Date in Role" id="start_date" name="start_date" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm text-slate-600" />
                    </div>

                    <!-- Authorization Type -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Authorization Type*</label>
                        <div class="flex flex-wrap gap-4">
                            <x-input.checkbox id="auth_sole" name="auth_sole" label="Sole Signatory"
                                class="rounded text-primary focus:ring-primary border-gray-300 w-4 h-4" />
                            <x-input.checkbox id="auth_joint" name="auth_joint" label="Joint Signatory"
                                class="rounded text-primary focus:ring-primary border-gray-300 w-4 h-4" />
                            <x-input.checkbox id="auth_limited" name="auth_limited" label="Limited Authority"
                                class="rounded text-primary focus:ring-primary border-gray-300 w-4 h-4" />
                            <x-input.checkbox id="auth_poa" name="auth_poa" label="Power of Attorney"
                                class="rounded text-primary focus:ring-primary border-gray-300 w-4 h-4" />
                        </div>
                    </div>

                    <!-- Is Beneficial Owner -->
                    <div
                        class="col-span-2 flex items-center justify-between p-3 bg-slate-50 rounded border border-gray-100">
                        <div>
                            <span class="text-sm font-medium text-slate-700">Is this person also a Beneficial
                                Owner?</span>
                            <p class="text-xs text-slate-500 mt-0.5">If yes, their information will be linked to the
                                Beneficial Owners section.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_beneficial_owner" value="1" class="sr-only peer" />
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- SECTION C: IDENTIFICATION DETAILS -->
            <div class="mb-8">
                <h3
                    class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                    Identification Details</h3>
                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <!-- ID Type -->
                    <div>
                        <x-input.select label="Identification Type" id="id_type" name="id_type" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm bg-white appearance-none cursor-pointer pr-10">
                            <option>Passport</option>
                            <option>National ID Card</option>
                            <option>Driver's License</option>
                        </x-input.select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500 -mt-9">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    <!-- ID Number -->
                    <div>
                        <x-input.text label="Identification Number" id="id_number" name="id_number" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm"
                            placeholder="ID Number" />
                    </div>
                    <!-- Expiry -->
                    <div>
                        <x-input.date label="ID Expiry Date" id="id_expiry" name="id_expiry" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm text-slate-600" />
                    </div>
                    <!-- Country of Issue -->
                    <div>
                        <x-input.select label="Country of Issue" id="id_country" name="id_country" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm bg-white appearance-none cursor-pointer pr-10">
                            <option>United States</option>
                            <option>United Kingdom</option>
                            <option>France</option>
                            <option>Germany</option>
                        </x-input.select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500 -mt-9">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION D: RESIDENTIAL ADDRESS -->
            <div class="mb-8">
                <h3
                    class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                    Residential Address</h3>
                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Address 1 -->
                    <div class="col-span-2">
                        <x-input.text label="Address Line 1" id="address_line1" name="address_line1" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm"
                            placeholder="Street address, P.O. box" />
                    </div>
                    <!-- Address 2 -->
                    <div class="col-span-2">
                        <x-input.text label="Address Line 2" id="address_line2" name="address_line2"
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm"
                            placeholder="Apartment, suite, unit, building, floor, etc." />
                    </div>
                    <!-- City -->
                    <div>
                        <x-input.text label="City" id="city" name="city" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm"
                            placeholder="e.g. New York" />
                    </div>
                    <!-- Postal Code -->
                    <div>
                        <x-input.text label="Postal Code" id="postal_code" name="postal_code" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm"
                            placeholder="e.g. 10001" />
                    </div>
                    <!-- Country -->
                    <div class="col-span-2">
                        <x-input.select label="Country" id="country" name="country" required
                            class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm bg-white appearance-none cursor-pointer pr-10">
                            <option>United States</option>
                            <option>United Kingdom</option>
                            <option>Canada</option>
                        </x-input.select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500 -mt-9">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION E: DOCUMENT UPLOADS -->
            <div>
                <h3
                    class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                    Document Uploads</h3>

                <!-- Upload Area -->
                <div class="upload-zone border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-primary transition-colors cursor-pointer bg-slate-50/50">
                    <i class="fa-solid fa-cloud-arrow-up text-4xl text-slate-400 mb-3"></i>
                    <p class="text-sm font-medium text-slate-700 mb-1">Click to upload or drag and drop</p>
                    <p class="text-xs text-slate-500">ID Document, Proof of Address, Authorization Document,
                        Signature Specimen</p>
                    <p class="text-xs text-slate-400 mt-2">PDF, PNG, JPG up to 10MB</p>
                    <input type="file" class="hidden" accept=".pdf,.png,.jpg,.jpeg">
                </div>

                <!-- Uploaded Files Preview (Example) -->
                <div class="mt-4 space-y-2">
                    <div class="flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-pdf text-red-500"></i>
                            <div>
                                <p class="text-sm font-medium text-slate-700">passport_john_doe.pdf</p>
                                <p class="text-xs text-slate-500">2.4 MB</p>
                            </div>
                        </div>
                        <button class="text-slate-400 hover:text-red-500 transition-colors">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>

        </section>
        </div>

        <div class="text-center mb-8 mt-4">
            <button type="button" id="add-authorized-signatory-btn"
                class="inline-flex items-center gap-2 px-8 py-2.5 border border-brand-accent text-brand-accent bg-white hover:bg-blue-50 font-medium rounded-lg transition-colors duration-200">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>Add Another Authorized Signatory</span>
            </button>
        </div>

        <footer id="footer"
            class="fixed bottom-0 right-0 w-[calc(100%-260px)] bg-white border-t border-brand-border px-12 py-4 z-30">
            <div class="max-w-[900px] mx-auto flex items-center justify-between">
                <a href="{{ route('merchant.kyc.bankInformation') }}"
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

                    <a href="{{ route('merchant.kyc.review') }}"
                        class="px-8 py-2.5 bg-brand-orange hover:bg-brand-orangeHover text-white font-semibold rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <span>Continue to Review and Submit</span>
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
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
            let signatoryCount = 1;
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
                });
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

            function saveDraft() {
                showToast('Your progress has been saved.', 'success');
            }
        </script>
    @endpush
</x-merchant.kyc>
