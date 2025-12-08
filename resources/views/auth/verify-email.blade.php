<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl">
            
            <h2 class="text-2xl font-bold text-blue-700 mb-3 text-center">
                Verify Your Email
            </h2>

            <p class="text-gray-600 text-sm leading-relaxed text-center mb-6">
                Thanks for signing up! Before getting started, please verify your email 
                address by clicking the link we just sent you. <br>
                If you didn’t receive the email, we can send another one.
            </p>

            {{-- Success Message --}}
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-green-600 text-sm font-medium text-center">
                    A new verification link has been sent to your email.
                </div>
            @endif

            <div class="mt-4 flex flex-col space-y-3">

                {{-- Resend --}}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 
                               rounded-lg shadow-md transition duration-200">
                        Resend Verification Email
                    </button>
                </form>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf
                    <button type="submit"
                        class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Log Out
                    </button>
                </form>

            </div>

        </div>

    </div>
</x-guest-layout>