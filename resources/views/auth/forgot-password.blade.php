<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">

        <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

            {{-- LEFT INFO --}}
            <div class="hidden md:flex flex-col justify-center bg-blue-600 p-10 text-white">
                <h1 class="text-4xl font-bold leading-tight">
                    Lupa Password?
                </h1>

                <p class="mt-4 text-white/90 text-lg">
                    Tenang, KitaTravel siap membantu!  
                    Masukkan email Anda, dan kami akan mengirimkan link untuk reset password Anda.
                </p>
            </div>

            {{-- RIGHT FORM --}}
            <div class="p-10 flex items-center">
                <div class="w-full max-w-md mx-auto">

                    <h2 class="text-3xl font-bold text-blue-600 mb-2 text-center">
                        Reset Password
                    </h2>

                    <p class="text-gray-600 text-sm mb-6 text-center">
                        Masukkan email Anda untuk menerima link reset password.
                    </p>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email"
                                class="block mt-2 w-full border rounded-lg px-4 py-2 bg-gray-50
                                       focus:ring focus:ring-blue-200"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required autofocus
                                placeholder="your@email.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm" />
                        </div>

                        {{-- Send Button --}}
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 
                                   rounded-lg transition">
                            Kirim Link Reset
                        </button>
                    </form>

                    {{-- Back to Login --}}
                    <div class="mt-6 text-center">
                        <a href="{{ route('login') }}"
                           class="text-sm text-blue-600 hover:text-blue-800 font-semibold underline">
                            Kembali ke Login
                        </a>
                    </div>

                </div>
            </div>

        </div>

    </div>
</x-guest-layout>