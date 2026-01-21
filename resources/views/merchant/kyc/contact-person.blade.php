@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Person - KYC</title>
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
                        accent: '#FFA439',
                        success: '#28A745',
                        neutral: '#F7F8FA',
                        grey: {
                            outline: '#BFC4CC',
                            text: '#6A6A6A',
                            light: '#E5E7EB'
                        }
                    }
                }
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F8FA; }
        ::-webkit-scrollbar { display: none; }
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
        .last-step .step-line { display: none; }
    </style>
@endsection

@section('body')
<body class="text-primary h-screen flex overflow-hidden">

    <x-merchant.kyc-stepper :active="4" />

    <!-- Main Content Area -->
    <main id="main-content" class="flex-1 overflow-y-auto bg-neutral relative">
        <div class="max-w-[1000px] mx-auto px-10 py-12 pb-32">
            
            <!-- Header Section -->
            <div id="page-header" class="mb-8">
                <h1 class="text-2xl font-semibold text-primary mb-2">Contact Person</h1>
                <p class="text-gray-500 text-sm">Provide the details of the person who will be the primary contact for this agreement.</p>
            </div>

            <!-- Contact Person Card -->
            <div id="contact-person-card" class="bg-white rounded-lg shadow-sm border border-gray-200/60 p-6">
                
                <!-- Section A: Personal Information -->
                <section id="section-personal-info" class="mb-8">
                    <div class="flex items-center gap-4 mb-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">Personal Information</h3>
                        <div class="h-px bg-gray-200 w-full"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-primary mb-1.5">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" class="form-input" placeholder="e.g. John Doe">
                        </div>

                        <!-- Position -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-primary mb-1.5">Position <span class="text-red-500">*</span></label>
                            <input type="text" class="form-input" placeholder="e.g. Finance Manager">
                        </div>

                        <!-- Email Address -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-primary mb-1.5">Email Address <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fa-regular fa-envelope"></i></span>
                                <input type="email" class="form-input pl-10" placeholder="john.doe@company.com">
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-primary mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fa-solid fa-phone"></i></span>
                                <input type="tel" class="form-input pl-10" placeholder="+1 (555) 000-0000">
                            </div>
                        </div>

                        <!-- Preferred Contact Method -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-primary mb-1.5">Preferred Contact Method <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select class="form-input appearance-none cursor-pointer bg-white">
                                    <option value="" disabled selected>Select method</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Phone</option>
                                    <option value="both">Both</option>
                                </select>
                                <span class="absolute right-4 top-3.5 text-gray-400 pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Secondary Phone -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-primary mb-1.5">Secondary Phone <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fa-solid fa-phone"></i></span>
                                <input type="tel" class="form-input pl-10" placeholder="+1 (555) 000-0000">
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section B: Address Details -->
                <section id="section-address-details" class="mb-8">
                    <div class="flex items-center gap-4 mb-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">Address Details</h3>
                        <div class="h-px bg-gray-200 w-full"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <!-- Address Line 1 -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-primary mb-1.5">Address Line 1 <span class="text-red-500">*</span></label>
                            <input type="text" class="form-input" placeholder="Street address, P.O. box">
                        </div>

                        <!-- Address Line 2 -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-primary mb-1.5">Address Line 2 <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <input type="text" class="form-input" placeholder="Apartment, suite, unit, etc.">
                        </div>

                        <!-- City -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-primary mb-1.5">City <span class="text-red-500">*</span></label>
                            <input type="text" class="form-input" placeholder="City">
                        </div>

                        <!-- Postal Code -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-primary mb-1.5">Postal Code <span class="text-red-500">*</span></label>
                            <input type="text" class="form-input" placeholder="ZIP / Postal Code">
                        </div>

                        <!-- Country -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-primary mb-1.5">Country <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select class="form-input appearance-none cursor-pointer bg-white">
                                    <option value="" disabled selected>Select Country</option>
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="DE">Germany</option>
                                    <option value="FR">France</option>
                                </select>
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
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">Documents</h3>
                        <div class="h-px bg-gray-200 w-full"></div>
                    </div>

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:bg-gray-50 transition-colors cursor-pointer group">
                        <div class="mb-3">
                            <div class="w-12 h-12 rounded-full bg-blue-50 text-primary mx-auto flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                            </div>
                        </div>
                        <h4 class="text-sm font-medium text-primary mb-1">Upload ID Document</h4>
                        <p class="text-xs text-gray-500 mb-4">Drag & drop or click to upload</p>
                        <p class="text-[10px] text-gray-400">Supported formats: PDF, JPG, PNG (Max 5MB)</p>
                    </div>
                </section>

            </div>
        </div>

        <!-- Sticky Footer -->
        <footer id="footer" class="fixed bottom-0 right-0 w-[calc(100%-260px)] bg-white border-t border-gray-200 px-10 py-4 z-30">
            <div class="max-w-[1000px] mx-auto flex items-center justify-between">
                <!-- Back Link -->
                <a href="{{ route('merchant.kyc.boardMembers') }}" class="group flex items-center gap-2 text-primary text-sm font-medium hover:underline">
                    <i class="fa-solid fa-arrow-left text-xs transition-transform group-hover:-translate-x-1"></i>
                    Back
                </a>

                <!-- Action Buttons -->
                <div class="flex items-center gap-4">
                    <button class="px-6 py-2.5 rounded-md border border-accent text-accent bg-white text-sm font-semibold hover:bg-orange-50 transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                        Save Draft
                    </button>
                    <a href="{{ route('merchant.kyc.purposeOfService') }}" class="px-6 py-2.5 rounded-md bg-accent text-white text-sm font-semibold hover:bg-orange-400 transition-colors shadow-sm flex items-center gap-2 focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                        Continue to Purpose of Service
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </footer>
    </main>

    <script>
        // Simple script to handle file selection simulation
        document.querySelector('.border-dashed').addEventListener('click', function() {
            alert('File upload dialog would open here.');
        });
    </script>
</body>
@endsection
