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
        <h1 class="text-[28px] font-bold text-brand-dark mb-2">Company Information</h1>
        <p class="text-[15px] text-[#6A6A6A]">Provide the primary legal and registration details for your
            business.</p>
    </div>

    <form id="kyc-form">

        <section id="section-registered-details" class="mb-10">
            <h2 class="text-xl font-semibold text-brand-dark mb-6">Registered Company Details</h2>

            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <x-input.text label="Legal Company Name" placeholder="Enter official registered name"
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" required />
                </div>

                <div class="col-span-2">
                    <x-input.text placeholder="Trading name / Doing business as"
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm">
                        <x-slot:label>
                            Trade Name <span class="text-gray-400 text-xs">(Optional)</span>
                        </x-slot:label>
                    </x-input.text>
                </div>

                <div>
                    <x-input.text label="Company Registration Number" placeholder="OrgNr / CVR / BRN / VAT ID"
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" required />
                </div>

                <div>
                    <x-input.date label="Date of Incorporation"
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" required />
                </div>

                <div>
                    <x-input.select label="Country of Registration" disabled
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm bg-gray-50 cursor-not-allowed"
                        required :placeholder="false">
                        <option>Norway</option>
                    </x-input.select>
                </div>

                <div>
                    <x-input.select label="Business Type"
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" required
                        placeholder="Select business type">
                        <option value="">Select business type</option>
                        <option>Private Limited</option>
                        <option>OPC</option>
                        <option>Partnership</option>
                        <option>Sole Proprietorship</option>
                        <option>NGO / Non-profit</option>
                        <option>Public Limited</option>
                        <option>Others</option>
                    </x-input.select>
                </div>
            </div>
        </section>

        <section id="section-address" class="mb-10">
            <h2 class="text-xl font-semibold text-brand-dark mb-6">Registered Address</h2>

            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <x-input.text label="Address Line 1" placeholder="Building / Street name"
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" required />
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
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" required />
                </div>

                <div>
                    <x-input.text label="Postal Code" placeholder="Postal code"
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" required />
                </div>

                <div>
                    <x-input.select label="Country" disabled
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm bg-gray-50 cursor-not-allowed"
                        required :placeholder="false">
                        <option>Norway</option>
                    </x-input.select>
                </div>

                <div class="col-span-2">
                    <x-input.textarea :rows="3" placeholder="Any additional location information"
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm resize-none">
                        <x-slot:label>
                            Additional Location Details <span class="text-gray-400 text-xs">(Optional)</span>
                        </x-slot:label>
                    </x-input.textarea>
                </div>
            </div>
        </section>

        <section id="section-classification" class="mb-10">
            <h2 class="text-xl font-semibold text-brand-dark mb-6">Business Classification</h2>

            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <x-input.select label="Industry / MCC Code"
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" required
                        placeholder="Select industry category">
                        <option>Retail (5311)</option>
                        <option>Restaurant (5812)</option>
                        <option>Professional Services (8999)</option>
                        <option>Healthcare (8099)</option>
                    </x-input.select>
                </div>

                <div class="col-span-2">
                    <x-input.textarea label="Description of Business Activities" :rows="3"
                        placeholder="Provide a brief description of your products or services"
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm resize-none"
                        required />
                </div>

                <div>
                    <x-input.select label="Expected Monthly Transaction Volume"
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm" required
                        placeholder="Select volume range">
                        <option>
                            < 50,000 NOK</option>
                        <option>50,000–250,000 NOK</option>
                        <option>250,000–1,000,000 NOK</option>
                        <option>> 1,000,000 NOK</option>
                    </x-input.select>
                </div>

                <div>
                    <x-input.url placeholder="https://yourbusiness.com"
                        class="w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm">
                        <x-slot:label>
                            Website URL <span class="text-gray-400 text-xs">(Optional)</span>
                        </x-slot:label>
                    </x-input.url>
                </div>
            </div>
        </section>

        <section id="section-documents" class="mb-10">
            <h2 class="text-xl font-semibold text-brand-dark mb-6">Company Verification Documents</h2>

            <div class="space-y-4">
                <x-input.file-upload label="Certificate of Incorporation" accept=".pdf,.jpg,.jpeg,.png" maxSize="5MB"
                    required />

                <x-input.file-upload label="Registration Extract / Business License" accept=".pdf,.jpg,.jpeg,.png"
                    maxSize="5MB" required />

                <x-input.file-upload accept=".pdf,.jpg,.jpeg,.png" maxSize="5MB">
                    <x-slot:label>
                        VAT / Tax Registration Document <span class="text-gray-400 text-xs">(If applicable)</span>
                    </x-slot:label>
                </x-input.file-upload>
            </div>
        </section>

        <footer id="footer"
            class="fixed bottom-0 right-0 w-[calc(100%-260px)] bg-white border-t border-brand-border px-12 py-4 z-30">
            <div class="max-w-[900px] mx-auto flex items-center justify-between">
                <a href="{{ route('merchant.kyc.company') }}"
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

                    <a href="{{ route('merchant.kyc.beneficialOwners') }}"
                        class="px-8 py-2.5 bg-brand-orange hover:bg-brand-orangeHover text-white font-semibold rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <span>Continue to Beneficial Owners</span>
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                </div>
            </div>
        </footer>
    </form>
</x-merchant.kyc>
