@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - 2iZii</title>
    <script src="https://cdn.tailwindcss.com"></script>
@endsection

@section('body')
    <body class="min-h-screen bg-[#F7F8FA] flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-8">
            <h1 class="text-2xl font-bold text-[#2D3A74] mb-2">Reset Password</h1>
            <p class="text-sm text-gray-600 mb-6">Set a new password for your merchant account.</p>

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 text-sm px-4 py-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email) }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FF7C00]">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FF7C00]">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FF7C00]">
                </div>

                <button type="submit"
                    class="w-full bg-[#FF7C00] hover:bg-[#E56D00] text-white font-semibold py-3 rounded-lg transition-colors">
                    Reset Password
                </button>
            </form>
        </div>
    </body>
@endsection
