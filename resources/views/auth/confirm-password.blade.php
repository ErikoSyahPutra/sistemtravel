<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">

            <!-- Title -->
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-4">
                {{ __('Confirm Password') }}
            </h2>

            <p class="text-sm text-gray-600 mb-6 text-center">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password"
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Button -->
                <button
                    class="w-full bg-blue-600 text-white py-2 rounded-xl font-medium hover:bg-blue-700 transition">
                    {{ __('Confirm') }}
                </button>
            </form>

        </div>
    </div>
</x-guest-layout>