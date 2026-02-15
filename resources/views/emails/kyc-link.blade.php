@component('mail::message')
    {{-- Header --}}
    <div style="text-align: center; margin-bottom: 30px;">
        # 🎉 Welcome to {{ config('app.name') }}!
    </div>

    {{-- Greeting --}}
    Hello **{{ $businessName }}**,

    Thank you for choosing **{{ config('app.name') }}** for your payment processing needs. We're excited to partner with you
    on your journey to seamless payment solutions!

    {{-- Main Message --}}
    <div style="background: #f8fafc; border-left: 4px solid #FF7C00; padding: 20px; margin: 25px 0; border-radius: 8px;">
        <strong>🚀 Next Step: Complete Your KYC</strong>

        To get started, we need you to complete the Know Your Customer (KYC) verification process. This is a quick and
        secure process that helps us ensure compliance and protect your business.
    </div>

    {{-- CTA Button --}}
    @component('mail::button', ['url' => $kycLink, 'color' => 'primary'])
        ✓ Complete KYC Now
    @endcomponent

    <div style="text-align: center; font-size: 12px; color: #6b7280; margin-top: 10px;">
        This link is valid for 30 days
    </div>

    ---

    {{-- Onboarding Details --}}
    @component('mail::panel')
        ### 📋 Your Onboarding Details

        <table style="width: 100%; font-size: 14px;">
            <tr>
                <td style="padding: 8px 0; color: #6b7280; width: 40%;"><strong>Request ID:</strong></td>
                <td style="padding: 8px 0; color: #1f2937;">{{ $requestId }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #6b7280;"><strong>Business Name:</strong></td>
                <td style="padding: 8px 0; color: #1f2937;">{{ $businessName }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #6b7280;"><strong>Contact Email:</strong></td>
                <td style="padding: 8px 0; color: #1f2937;">{{ $onboarding->merchant_contact_email }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #6b7280;"><strong>Solution:</strong></td>
                <td style="padding: 8px 0; color: #1f2937;">{{ $solutionName }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #6b7280;"><strong>Partner:</strong></td>
                <td style="padding: 8px 0; color: #1f2937;">{{ $partnerName }}</td>
            </tr>
        </table>
    @endcomponent

    ---

    {{-- What's Next Section --}}
    ### 📌 What Happens Next?

    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td style="padding: 10px 0; vertical-align: top;">
                <span
                    style="display: inline-block; width: 30px; height: 30px; background: #FF7C00; color: white; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; margin-right: 10px;">1</span>
            </td>
            <td style="padding: 10px 0;">
                <strong>Click the button above</strong><br>
                <span style="color: #6b7280; font-size: 14px;">Access your personalized KYC form</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px 0; vertical-align: top;">
                <span
                    style="display: inline-block; width: 30px; height: 30px; background: #FF7C00; color: white; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; margin-right: 10px;">2</span>
            </td>
            <td style="padding: 10px 0;">
                <strong>Complete the information</strong><br>
                <span style="color: #6b7280; font-size: 14px;">Fill in your business and operational details</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px 0; vertical-align: top;">
                <span
                    style="display: inline-block; width: 30px; height: 30px; background: #FF7C00; color: white; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; margin-right: 10px;">3</span>
            </td>
            <td style="padding: 10px 0;">
                <strong>Upload documents</strong><br>
                <span style="color: #6b7280; font-size: 14px;">Provide necessary verification documents</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px 0; vertical-align: top;">
                <span
                    style="display: inline-block; width: 30px; height: 30px; background: #FF7C00; color: white; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; margin-right: 10px;">4</span>
            </td>
            <td style="padding: 10px 0;">
                <strong>Submit for review</strong><br>
                <span style="color: #6b7280; font-size: 14px;">Our team will review within 2-3 business days</span>
            </td>
        </tr>
    </table>

    ---

    {{-- Help Section --}}
    @component('mail::panel', ['style' => 'background: #fef3c7; border-left-color: #f59e0b;'])
        ### 💡 Need Help?

        If you have any questions or encounter any issues, our support team is here to help:
        - 📧 Email: support@iziibuy.com
        - 📞 Phone: +44 20 1234 5678
        - 💬 Live Chat: Available on our website
    @endcomponent

    {{-- Security Notice --}}
    <div
        style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 15px; margin: 20px 0; font-size: 13px;">
        <strong style="color: #dc2626;">🔒 Security Notice:</strong><br>
        This link is unique to your application and contains sensitive information. Please do not share it with anyone. If
        you did not request this onboarding, please contact us immediately.
    </div>

    {{-- Footer --}}
    <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
        Best regards,<br>
        <strong>The {{ config('app.name') }} Team</strong>

        <div style="margin-top: 15px; font-size: 12px; color: #9ca3af;">
            Powering seamless payment solutions worldwide 🌍
        </div>
    </div>
@endcomponent
