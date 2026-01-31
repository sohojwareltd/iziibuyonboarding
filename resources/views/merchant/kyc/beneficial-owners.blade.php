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
        <h1 class="text-xl sm:text-2xl font-bold text-brand-dark mb-2">Beneficial Owners</h1>
        <p class="text-[15px] text-[#6A6A6A]">Provide details of individuals who hold 25% or more ownership in
            the business.</p>
    </div>

    <div id="info-banner" class="bg-[#FFF6E8] border-l-4 border-brand-orange p-4 rounded-lg mb-8">
        <p class="text-[13px] font-medium text-[#8A6C1A]">
            <i class="fa-solid fa-info-circle mr-2"></i>
            According to EU AML regulations, you must declare all individuals with 25% or more ownership.
        </p>
    </div>

    <form id="bo-form">
        <div id="beneficial-owners-container">

            <div class="beneficial-owner-card bg-white border border-[#E0E0E0] rounded-xl p-4 sm:p-6 mb-6" data-bo-index="1">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-brand-dark">Beneficial Owner #1</h3>
                    <button type="button"
                        class="remove-bo-btn text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200 hidden">
                        <i class="fa-solid fa-trash text-sm"></i>
                    </button>
                </div>

                <div class="space-y-8">

                    <div class="personal-info">
                        <h4 class="text-base font-medium text-brand-dark mb-4">Personal Information</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <x-input.text 
                                    label="First Name" 
                                    placeholder="Enter first name"
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" 
                                    required 
                                />
                            </div>
                            <div>
                                <x-input.text 
                                    label="Last Name" 
                                    placeholder="Enter last name"
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" 
                                    required 
                                />
                            </div>
                            <div>
                                <x-input.date 
                                    label="Date of Birth" 
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" 
                                    required 
                                />
                            </div>
                            <div>
                                <x-input.select 
                                    label="Nationality" 
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" 
                                    required
                                    placeholder="Select nationality"
                                >
                                    <option>Norwegian</option>
                                    <option>Danish</option>
                                    <option>Swedish</option>
                                    <option>Finnish</option>
                                    <option>German</option>
                                    <option>Other</option>
                                </x-input.select>
                            </div>
                            <div>
                                <x-input.email 
                                    placeholder="name@example.com"
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                >
                                    <x-slot:label>
                                        Email Address <span class="text-gray-400 text-xs">(Optional)</span>
                                    </x-slot:label>
                                </x-input.email>
                            </div>
                            <div>
                                <x-input.tel 
                                    placeholder="+47 ..."
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                >
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
                                <x-input.select 
                                    label="Identification Type" 
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" 
                                    required
                                    placeholder="Select ID type"
                                >
                                    <option>Passport</option>
                                    <option>National ID</option>
                                    <option>Driver's License</option>
                                </x-input.select>
                            </div>
                            <div>
                                <x-input.text 
                                    label="Identification Number" 
                                    placeholder="Enter ID number"
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" 
                                    required 
                                />
                            </div>
                            <div>
                                <x-input.date 
                                    label="ID Expiry Date" 
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" 
                                    required 
                                />
                            </div>
                            <div>
                                <x-input.select 
                                    label="Country of Issue" 
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" 
                                    required
                                    placeholder="Select country"
                                >
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
                                <x-input.number 
                                    label="Ownership Percentage" 
                                    placeholder="25" 
                                    suffix="%"
                                    min="1" 
                                    max="100"
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm ownership-percentage" 
                                    required 
                                />
                            </div>
                            <div></div>
                            <div class="col-span-2">
                                <x-input.text 
                                    label="Address Line 1" 
                                    placeholder="Street address"
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" 
                                    required 
                                />
                            </div>
                            <div class="col-span-2">
                                <x-input.text 
                                    placeholder="Apartment, suite, unit, etc."
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm"
                                >
                                    <x-slot:label>
                                        Address Line 2 <span class="text-gray-400 text-xs">(Optional)</span>
                                    </x-slot:label>
                                </x-input.text>
                            </div>
                            <div>
                                <x-input.text 
                                    label="City" 
                                    placeholder="City name"
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" 
                                    required 
                                />
                            </div>
                            <div>
                                <x-input.text 
                                    label="Postal Code" 
                                    placeholder="Postal code"
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" 
                                    required 
                                />
                            </div>
                            <div>
                                <x-input.select 
                                    label="Country" 
                                    class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" 
                                    required
                                    placeholder="Select country"
                                >
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
                            <x-input.file-upload 
                                label="Proof of Identity" 
                                accept=".pdf,.jpg,.jpeg,.png" 
                                maxSize="5MB" 
                                required 
                            />

                            <x-input.file-upload 
                                label="Proof of Address" 
                                accept=".pdf,.jpg,.jpeg,.png" 
                                maxSize="5MB" 
                                required 
                            />
                        </div>
                    </div>

                </div>
            </div>

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
                    <button onclick="saveDraft()"
                        class="flex-1 sm:flex-none px-3 sm:px-6 py-2.5 border border-brand-orange text-brand-orange bg-white hover:bg-orange-50 font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-xs sm:text-sm">
                        <i class="fa-regular fa-floppy-disk text-sm hidden sm:inline"></i>
                        <span>Draft</span>
                    </button>

                    <a href="{{ route('merchant.kyc.boardMembers', ['kyc_link' => $kyc_link]) }}"
                        class="flex-1 sm:flex-none px-4 sm:px-8 py-2.5 bg-brand-orange hover:bg-brand-orangeHover text-white font-semibold rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-xs sm:text-base">
                        <span>Continue</span>
                        <i class="fa-solid fa-arrow-right text-sm hidden sm:inline"></i>
                    </a>
                </div>
            </div>
        </footer>

    </form>

    <div id="toast-container" class="fixed top-6 right-6 z-50"></div>

    <div id="confirmation-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
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
            let boCount = 1;
            let boToRemove = null;
    
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
                const cardHTML = `
                    <div class="beneficial-owner-card bg-white border border-[#E0E0E0] rounded-xl p-4 sm:p-6 mb-6" data-bo-index="${index}">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-brand-dark">Beneficial Owner #${index}</h3>
                            <button type="button" class="remove-bo-btn text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200">
                                <i class="fa-solid fa-trash text-sm"></i>
                            </button>
                        </div>
                        <div class="space-y-8">
                            <div class="personal-info">
                                <h4 class="text-base font-medium text-brand-dark mb-4">Personal Information</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" placeholder="Enter first name" class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" placeholder="Enter last name" class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="date" class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nationality <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-accent focus:ring-1 focus:ring-accent outline-none bg-white appearance-none" required>
                                                <option value="" disabled selected>Select nationality</option>
                                                <option>Norwegian</option>
                                                <option>Danish</option>
                                                <option>Swedish</option>
                                                <option>Finnish</option>
                                                <option>German</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-gray-400 text-xs">(Optional)</span></label>
                                        <div class="relative">
                                            <input type="email" placeholder="name@example.com" class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-gray-400 text-xs">(Optional)</span></label>
                                        <div class="relative">
                                            <input type="tel" placeholder="+47 ..." class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors">
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="identification-info">
                                <h4 class="text-base font-medium text-brand-dark mb-4">Identification Details</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Identification Type <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-accent focus:ring-1 focus:ring-accent outline-none bg-white appearance-none" required>
                                                <option value="" disabled selected>Select ID type</option>
                                                <option>Passport</option>
                                                <option>National ID</option>
                                                <option>Driver's License</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Identification Number <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" placeholder="Enter ID number" class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">ID Expiry Date <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="date" class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Country of Issue <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-accent focus:ring-1 focus:ring-accent outline-none bg-white appearance-none" required>
                                                <option value="" disabled selected>Select country</option>
                                                <option>Norway</option>
                                                <option>Denmark</option>
                                                <option>Sweden</option>
                                                <option>Finland</option>
                                                <option>Germany</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="ownership-info">
                                <h4 class="text-base font-medium text-brand-dark mb-4">Ownership Details</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Ownership Percentage <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="number" min="1" max="100" placeholder="25" class="w-full rounded-md border border-gray-300 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors px-4 pr-8 ownership-percentage" required>
                                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">%</span>
                                        </div>
                                    </div>
                                    <div></div>
                                    <div class="col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1 <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" placeholder="Street address" class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors" required>
                                        </div>
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 2 <span class="text-gray-400 text-xs">(Optional)</span></label>
                                        <div class="relative">
                                            <input type="text" placeholder="Apartment, suite, unit, etc." class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" placeholder="City name" class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" placeholder="Postal code" class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-accent focus:ring-1 focus:ring-accent outline-none bg-white appearance-none" required>
                                                <option value="" disabled selected>Select country</option>
                                                <option>Norway</option>
                                                <option>Denmark</option>
                                                <option>Sweden</option>
                                                <option>Finland</option>
                                                <option>Germany</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="documents-section">
                                <h4 class="text-base font-medium text-brand-dark mb-4">Document Uploads</h4>
                                <div class="space-y-4">
                                    <div class="upload-zone bg-white rounded-xl border-2 border-dashed border-gray-300 p-6 text-center cursor-pointer hover:border-accent transition-colors">
                                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-3"></i>
                                        <p class="text-sm font-medium text-gray-700 mb-1">Proof of Identity <span class="text-red-500">*</span></p>
                                        <p class="text-xs text-gray-500">Upload PDF JPG PNG (Max 5MB)</p>
                                        <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
    
                                    <div class="upload-zone bg-white rounded-xl border-2 border-dashed border-gray-300 p-6 text-center cursor-pointer hover:border-accent transition-colors">
                                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-3"></i>
                                        <p class="text-sm font-medium text-gray-700 mb-1">Proof of Address <span class="text-red-500">*</span></p>
                                        <p class="text-xs text-gray-500">Upload PDF JPG PNG (Max 5MB)</p>
                                        <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
    
                const div = document.createElement('div');
                div.innerHTML = cardHTML.trim();
                return div.firstChild;
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
                });
            }
    
            function removeFile(btn) {
                const zone = btn.closest('.upload-zone');
                zone.innerHTML = `
                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-3"></i>
                    <p class="text-sm font-medium text-gray-700 mb-1">Upload Document</p>
                    <p class="text-xs text-gray-500">Upload PDF / JPG / PNG (Max 5MB)</p>
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
