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
                    Buat akun Anda dan mulai jelajahi berbagai pilihan paket perjalanan terbaik
                    dengan mudah, cepat, dan nyaman!
                </p>
            </div>

            {{-- RIGHT: REGISTER FORM --}}
            <div class="p-10 flex items-center">
                <div class="w-full max-w-md mx-auto">

                    <h2 class="text-3xl font-bold text-blue-600 mb-2 text-center">
                        Daftar Akun
                    </h2>

                    <p class="text-gray-500 text-sm text-center mb-6">
                        Isi data Anda untuk membuat akun baru
                    </p>

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name"
                                class="block mt-1 w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                                type="text" name="name" required autofocus placeholder="Nama lengkap" />
                            <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email"
                                class="block mt-1 w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                                type="email" name="email" required placeholder="contoh@email.com" />
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

                        {{-- Confirm Password --}}
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation"
                                class="block mt-1 w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                                type="password" name="password_confirmation" required placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm" />
                        </div>

                        {{-- Button --}}
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">
                            Daftar
                        </button>
                    </form>

                    {{-- LOGIN LINK --}}
                    <p class="mt-6 text-center text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                           class="text-blue-600 hover:text-blue-800 font-semibold">
                           Masuk di sini
                        </a>
                    </p>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>