@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - 2iZii</title>
    <script src="https://cdn.tailwindcss.com"></script>
@endsection

@section('body')
    <body class="min-h-screen bg-[#F7F8FA] flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-8">
            <h1 class="text-2xl font-bold text-[#2D3A74] mb-2">Forgot Password</h1>
            <p class="text-sm text-gray-600 mb-6">Enter your merchant email and we'll send a reset link.</p>

            @if (session('status'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 text-sm px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 text-sm px-4 py-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FF7C00]">
                </div>

                <button type="submit"
                    class="w-full bg-[#FF7C00] hover:bg-[#E56D00] text-white font-semibold py-3 rounded-lg transition-colors">
                    Email Password Reset Link
                </button>
            </form>

            @if (!empty($kyc_link))
                <a href="{{ route('merchant.kyc.start', ['kyc_link' => $kyc_link]) }}"
                    class="inline-block mt-5 text-sm text-[#2D3A74] hover:underline">
                    Back to KYC Login
                </a>
            @endif
        </div>
    </body>
@endsection
