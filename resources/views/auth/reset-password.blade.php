<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">

            <!-- Title -->
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-4">
                {{ __('Reset Password') }}
            </h2>

            <p class="text-sm text-gray-600 text-center mb-6">
                {{ __('Enter your new password below to reset your account.') }}
            </p>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email', $request->email)"
                        required autofocus autocomplete="username" />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('New Password')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation"
                        required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit -->
                <button
                    class="w-full bg-blue-600 text-white py-2 rounded-xl font-medium hover:bg-blue-700 transition">
                    {{ __('Reset Password') }}
                </button>

            </form>

        </div>
    </div>
</x-guest-layout>