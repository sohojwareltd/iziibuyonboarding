<x-merchant.kyc>
    <section class="min-h-[70vh] flex items-center justify-center px-4">
        <div class="max-w-2xl w-full bg-white border border-gray-100 rounded-xl shadow-sm p-8 text-center">
            <div class="w-16 h-16 mx-auto rounded-full bg-green-50 text-green-600 flex items-center justify-center mb-4">
                <i class="fa-solid fa-check text-2xl"></i>
            </div>

            @if (($onboarding?->status ?? null) === 'active')
                <h1 class="text-2xl font-semibold text-primary mb-3">Your onboarding is now active</h1>
                <p class="text-gray-600 leading-relaxed">
                    Thank you for your submission. Your KYC has been activated by our team.
                    The next process will be shared with you shortly.
                </p>
            @else
                <h1 class="text-2xl font-semibold text-primary mb-3">Thank you for your submission</h1>
                <p class="text-gray-600 leading-relaxed">
                    We have received your KYC information. Our team will review and activate your account.
                    You will continue to see this page until activation is completed.
                </p>
            @endif

            <div class="mt-6 text-sm text-gray-500">
                If you need help, please contact support.
            </div>
        </div>
    </section>
</x-merchant.kyc>
