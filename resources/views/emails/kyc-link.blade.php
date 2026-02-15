<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KYC Verification - {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            line-height: 1.6;
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 10px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .header-banner {
            background: linear-gradient(135deg, #2D3A74 0%, #4055A8 100%);
            padding: 40px 25px;
            text-align: center;
            color: white;
        }
        .header-banner h1 {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }
        .header-banner p {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.95);
            margin: 0;
            font-weight: 500;
        }
        .main-content {
            padding: 32px 25px;
            background: white;
        }
        .greeting {
            color: #1f2937;
            font-size: 18px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .greeting strong {
            font-weight: 700;
            color: #2d3a74;
        }
        .intro-text {
            color: #4b5563;
            font-size: 15px;
            line-height: 1.8;
            margin-bottom: 28px;
        }
        .info-card {
            background: linear-gradient(135deg, #f0f7ff 0%, #f0f4f8 100%);
            border-left: 5px solid #FF7C00;
            padding: 22px;
            border-radius: 6px;
            margin-bottom: 28px;
        }
        .info-card-title {
            color: #2d3a74;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .info-table {
            width: 100%;
            font-size: 14px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 12px 0;
            color: #6b7280;
        }
        .info-table td:first-child {
            width: 35%;
            font-weight: 700;
            color: #374151;
        }
        .info-table td:last-child {
            color: #1f2937;
            font-weight: 600;
            padding-left: 12px;
        }
        .info-table tr:not(:last-child) {
            border-bottom: 1px solid #e5e7eb;
        }
        .cta-section {
            text-align: center;
            margin: 35px 0;
        }
        .btn {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }
        .btn:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        }
        .cta-note {
            color: #9ca3af;
            font-size: 12px;
            margin-top: 14px;
            font-style: italic;
        }
        .login-section {
            background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);
            border: 1px solid #bfdbfe;
            border-left: 5px solid #3b82f6;
            padding: 24px;
            border-radius: 6px;
            margin-bottom: 28px;
        }
        .section-title {
            color: #1e40af;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .login-table {
            width: 100%;
            font-size: 14px;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        .login-table td {
            padding: 12px 0;
            color: #1e40af;
            font-weight: 700;
        }
        .login-table td:last-child {
            color: #1f2937;
            font-weight: 600;
            font-family: 'Monaco', 'Courier New', monospace;
            background: white;
            padding: 12px 14px;
            border-radius: 6px;
            border: 1px solid #bfdbfe;
        }
        .login-table tr:nth-child(2) {
            height: 8px;
        }
        .login-table tr:nth-child(3) td:last-child {
            background: transparent;
            color: #4b5563;
            font-family: inherit;
            padding: 12px 0;
            border: none;
            font-weight: 500;
        }
        .quick-access {
            background: white;
            border: 1px solid #bfdbfe;
            padding: 14px;
            border-radius: 6px;
            font-size: 13px;
            line-height: 1.7;
            color: #1e40af;
        }
        .quick-access strong {
            display: block;
            margin-bottom: 6px;
            color: #1e40af;
        }
        .process-section {
            margin: 35px 0;
        }
        .process-title {
            color: #2d3a74;
            font-size: 16px;
            font-weight: 700;
            display: block;
            margin-bottom: 24px;
        }
        .process-table {
            width: 100%;
            border-collapse: collapse;
        }
        .process-number {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #FF7C00 0%, #E87000 100%);
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 45px;
            font-weight: 700;
            font-size: 20px;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(255, 124, 0, 0.2);
        }
        .process-content {
            padding: 0 0 0 18px;
            vertical-align: middle;
        }
        .process-step-title {
            color: #2d3a74;
            font-size: 15px;
            font-weight: 700;
            display: block;
            margin-bottom: 6px;
        }
        .process-step-desc {
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
        }
        .process-table tr {
            padding: 12px 0;
        }
        .process-table tr:not(:last-child) td {
            padding-bottom: 24px;
        }
        .tips-section {
            background: linear-gradient(135deg, #fef9e7 0%, #fef3c7 100%);
            border: 1px solid #fcd34d;
            border-left: 5px solid #f59e0b;
            padding: 20px;
            border-radius: 6px;
            margin: 28px 0;
            font-size: 13px;
            line-height: 1.7;
        }
        .tips-title {
            color: #92400e;
            font-weight: 700;
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .tips-content {
            color: #78350f;
        }
        .support-section {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            padding: 24px;
            border-radius: 6px;
            margin: 28px 0;
            border-left: 5px solid #6b7280;
        }
        .support-title {
            color: #2d3a74;
            font-weight: 700;
            display: block;
            margin-bottom: 14px;
            font-size: 16px;
        }
        .support-content {
            font-size: 13px;
            color: #4b5563;
            line-height: 1.8;
        }
        .support-item {
            margin: 10px 0;
        }
        .support-item strong {
            color: #374151;
        }
        .support-item a {
            color: #FF7C00;
            text-decoration: none;
            font-weight: 600;
        }
        .support-item a:hover {
            text-decoration: underline;
        }
        .security-section {
            background: linear-gradient(135deg, #fef5f5 0%, #fef2f2 100%);
            border: 1px solid #fecaca;
            border-left: 5px solid #dc2626;
            padding: 20px;
            border-radius: 6px;
            margin: 28px 0;
            font-size: 13px;
            line-height: 1.7;
        }
        .security-title {
            color: #7f1d1d;
            font-weight: 700;
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .security-content {
            color: #7f1d1d;
        }
        .footer {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            color: white;
            padding: 32px 25px;
            text-align: center;
            border-radius: 0 0 12px 12px;
        }
        .footer p {
            margin: 0;
        }
        .footer-main {
            margin-bottom: 8px;
            font-size: 15px;
        }
        .footer-team {
            margin-bottom: 22px;
            font-size: 17px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        .footer-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 16px;
            font-size: 12px;
            color: #d1d5db;
            line-height: 1.6;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 600px) {
            .email-wrapper {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                border-radius: 0 !important;
            }
            .header-banner {
                padding: 28px 18px !important;
            }
            .header-banner h1 {
                font-size: 24px !important;
                margin-bottom: 8px !important;
            }
            .header-banner p {
                font-size: 14px !important;
            }
            .main-content {
                padding: 22px 18px !important;
            }
            .footer {
                padding: 22px 18px !important;
                border-radius: 0 !important;
            }
            .greeting {
                font-size: 16px !important;
                margin-bottom: 16px !important;
            }
            .intro-text {
                font-size: 14px !important;
                margin-bottom: 20px !important;
            }
            .info-card {
                padding: 16px !important;
                margin-bottom: 20px !important;
                border-left: 4px !important;
            }
            .info-card-title {
                font-size: 15px !important;
                margin-bottom: 12px !important;
            }
            .info-table {
                font-size: 13px !important;
            }
            .info-table td {
                padding: 10px 0 !important;
                display: block !important;
                width: 100% !important;
            }
            .info-table td:first-child {
                width: 100% !important;
                margin-bottom: 4px !important;
                padding-bottom: 0 !important;
            }
            .info-table td:last-child {
                padding-left: 0 !important;
            }
            .info-table tr:not(:last-child) {
                border-bottom: 1px solid #e5e7eb !important;
                margin-bottom: 8px !important;
                padding-bottom: 8px !important;
            }
            .cta-section {
                margin: 25px 0 !important;
            }
            .btn {
                display: block !important;
                width: 100% !important;
                padding: 14px 20px !important;
                font-size: 15px !important;
            }
            .cta-note {
                font-size: 11px !important;
                margin-top: 10px !important;
            }
            .login-section {
                padding: 18px !important;
                margin-bottom: 20px !important;
                border-left: 4px !important;
            }
            .section-title {
                font-size: 15px !important;
                margin-bottom: 12px !important;
            }
            .login-table {
                font-size: 13px !important;
                margin-bottom: 12px !important;
            }
            .login-table td {
                padding: 10px 0 !important;
                display: block !important;
                width: 100% !important;
            }
            .login-table td:first-child {
                margin-bottom: 4px !important;
                padding-bottom: 0 !important;
            }
            .login-table td:last-child {
                padding: 10px 12px !important;
                margin-top: 4px !important;
            }
            .quick-access {
                padding: 12px !important;
                font-size: 12px !important;
            }
            .process-section {
                margin: 25px 0 !important;
            }
            .process-title {
                font-size: 15px !important;
                margin-bottom: 18px !important;
            }
            .process-table tr:not(:last-child) td {
                padding-bottom: 18px !important;
            }
            .process-number {
                width: 40px !important;
                height: 40px !important;
                line-height: 40px !important;
                font-size: 18px !important;
            }
            .process-content {
                padding: 0 0 0 12px !important;
            }
            .process-step-title {
                font-size: 14px !important;
                margin-bottom: 4px !important;
            }
            .process-step-desc {
                font-size: 12px !important;
            }
            .tips-section {
                padding: 16px !important;
                margin: 20px 0 !important;
                border-left: 4px !important;
                font-size: 12px !important;
            }
            .tips-title {
                font-size: 13px !important;
                margin-bottom: 8px !important;
            }
            .support-section {
                padding: 18px !important;
                margin: 20px 0 !important;
                border-left: 4px !important;
            }
            .support-title {
                font-size: 15px !important;
                margin-bottom: 12px !important;
            }
            .support-content {
                font-size: 12px !important;
            }
            .support-item {
                margin: 8px 0 !important;
            }
            .security-section {
                padding: 16px !important;
                margin: 20px 0 !important;
                border-left: 4px !important;
                font-size: 12px !important;
            }
            .security-title {
                font-size: 13px !important;
                margin-bottom: 8px !important;
            }
            .footer-team {
                font-size: 15px !important;
                margin-bottom: 16px !important;
            }
            .footer-main {
                font-size: 14px !important;
            }
            .footer-divider {
                font-size: 11px !important;
            }
        }
        
        @media (max-width: 480px) {
            .header-banner {
                padding: 20px 15px !important;
            }
            .header-banner h1 {
                font-size: 20px !important;
            }
            .main-content,
            .footer {
                padding: 18px 15px !important;
            }
            .btn {
                padding: 12px 15px !important;
                font-size: 14px !important;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        {{-- Header Banner --}}
        <div class="header-banner">
            <h1>🎉 Welcome to {{ config('app.name') }}!</h1>
            <p>Your Merchant Onboarding Portal</p>
        </div>

        {{-- Main Content --}}
        <div class="main-content">
            {{-- Personalized Greeting --}}
            <p class="greeting">
                Hello <strong>{{ $businessName }}</strong>,
            </p>

            {{-- Intro Text --}}
            <p class="intro-text">
                Thank you for choosing to partner with <strong>{{ config('app.name') }}</strong>. We're excited to work with you and help accelerate your payment processing journey. To activate your merchant account, we need you to complete a quick KYC (Know Your Customer) verification.
            </p>

            {{-- Key Information Card --}}
            <div class="info-card">
                <div class="info-card-title">📋 Your Request Details</div>
                <table class="info-table">
                    <tr>
                        <td><strong>Request ID:</strong></td>
                        <td>{{ $requestId }}</td>
                    </tr>
                    <tr>
                        <td><strong>Business:</strong></td>
                        <td>{{ $businessName }}</td>
                    </tr>
                    <tr>
                        <td><strong>Solution:</strong></td>
                        <td>{{ $solutionName }}</td>
                    </tr>
                    <tr>
                        <td><strong>Partner:</strong></td>
                        <td>{{ $partnerName }}</td>
                    </tr>
                </table>
            </div>

            {{-- Start KYC CTA --}}
            <div class="cta-section">
                <a href="{{ $kycLink }}" class="btn">🚀 Start KYC Verification</a>
                <p class="cta-note">Link valid for 30 days from today</p>
            </div>

            {{-- Login Information Section --}}
            <div class="login-section">
                <div class="section-title">🔑 Your Login Credentials</div>
                
                <table class="login-table">
                    <tr>
                        <td>Email:</td>
                        <td>{{ $merchantEmail }}</td>
                    </tr>
                    <tr></tr>
                    <tr></tr>
                    <tr>
                        <td>Password:</td>
                        <td>password123</td>
                    </tr>
                </table>

                <div class="quick-access">
                    <strong>⚡ Quick Access:</strong>
                    Use the button above to go directly to your welcome page. If needed, you can sign in manually using the credentials shown above.
                </div>
            </div>

            {{-- Process Steps --}}
            <div class="process-section">
                <strong class="process-title">✅ Simple 4-Step Process</strong>
                
                <table class="process-table">
                    <tr>
                        <td style="width: 50px; padding: 0; vertical-align: top;">
                            <span class="process-number">1</span>
                        </td>
                        <td class="process-content">
                            <span class="process-step-title">Access Your Portal</span>
                            <span class="process-step-desc">Click the button above or use your login credentials</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50px; padding: 0; vertical-align: top;">
                            <span class="process-number">2</span>
                        </td>
                        <td class="process-content">
                            <span class="process-step-title">Fill Business Information</span>
                            <span class="process-step-desc">Complete company details, beneficial owners, and operational info</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50px; padding: 0; vertical-align: top;">
                            <span class="process-number">3</span>
                        </td>
                        <td class="process-content">
                            <span class="process-step-title">Upload Documents</span>
                            <span class="process-step-desc">Provide business registration, ID, and other required documents</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50px; padding: 0; vertical-align: top;">
                            <span class="process-number">4</span>
                        </td>
                        <td class="process-content">
                            <span class="process-step-title">Review & Approval</span>
                            <span class="process-step-desc">Our team reviews and approves within 2-3 business days</span>
                        </td>
                    </tr>
                </table>
            </div>

            {{-- Additional Info Box --}}
            <div class="tips-section">
                <span class="tips-title">💡 Pro Tips</span>
                <div class="tips-content">
                    • Keep your documents ready for faster processing<br>
                    • Ensure all information matches your business registration<br>
                    • Secure upload - all data is encrypted<br>
                    • You can save and resume your progress anytime
                </div>
            </div>

            {{-- Support Section --}}
            <div class="support-section">
                <strong class="support-title">📞 Need Assistance?</strong>
                <div class="support-content">
                    <div class="support-item">📧 <strong>Email:</strong> <a href="mailto:support@iziibuy.com">support@iziibuy.com</a></div>
                    <div class="support-item">📞 <strong>Phone:</strong> +44 20 1234 5678</div>
                    <div class="support-item">⏰ <strong>Hours:</strong> Monday - Friday, 9:00 AM - 6:00 PM GMT</div>
                </div>
            </div>

            {{-- Security Notice --}}
            <div class="security-section">
                <strong class="security-title">🔒 Security & Privacy</strong>
                <div class="security-content">
                    This link is secure and unique to your account. Please do not share it with anyone. Always verify you're on our official domain before entering sensitive information. If you didn't request this, please contact us immediately.
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p class="footer-main">Best regards,</p>
            <p class="footer-team">The {{ config('app.name') }} Team</p>
            
            <div class="footer-divider">
                <p>🌍 Powering seamless payment solutions worldwide</p>
                <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>