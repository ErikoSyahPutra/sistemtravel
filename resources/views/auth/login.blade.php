<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">

        <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

            {{-- LEFT SECTION --}}
            <div class="hidden md:flex flex-col justify-center bg-blue-600 p-10 text-white">
                <h1 class="text-4xl font-bold leading-tight">
                    Selamat Datang<br>
                    di <span class="text-yellow-300">KitaTravel</span>
                </h1>

                <p class="mt-4 text-white/90 text-lg">
                    Temukan paket tur terbaik dengan harga terjangkau.  
                    Rencanakan perjalanan impian Anda bersama kami!
                </p>
            </div>

            {{-- RIGHT SECTION --}}
            <div class="p-10 flex items-center">
                <div class="w-full max-w-md mx-auto">

                    <h2 class="text-3xl font-bold text-blue-600 mb-2">
                        Login
                    </h2>
                    <p class="text-gray-500 text-sm mb-6">
                        Masukkan email dan password Anda
                    </p>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email"
                                class="block mt-1 w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                                type="email" name="email" :value="old('email')"
                                required autofocus placeholder="contoh@email.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm" />
                        </div>

                        {{-- Password --}}
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password"
                                class="block mt-1 w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                                type="password" name="password" required placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm" />
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember"
                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                <span class="ml-2 text-gray-600">Ingat saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        {{-- Button --}}
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">
                            Login
                        </button>
                    </form>

                    <p class="mt-6 text-center text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                           class="text-blue-600 hover:text-blue-800 font-semibold">
                           Daftar di sini
                        </a>
                    </p>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>