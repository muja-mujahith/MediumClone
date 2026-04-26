<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">

        <div class="w-full max-w-md bg-white shadow-md rounded-2xl p-6 sm:p-8">

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                Create Account
            </h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" value="Name" />
                    <x-text-input id="name"
                        class="block mt-1 w-full"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Username -->
                <div>
                    <x-input-label for="username" value="Username" />
                    <x-text-input id="username"
                        class="block mt-1 w-full"
                        type="text"
                        name="username"
                        :value="old('username')"
                        required />
                    <x-input-error :messages="$errors->get('username')" class="mt-1" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password"
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" value="Confirm Password" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation"
                        required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">

                    <a href="{{ route('login') }}"
                       class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Already registered?
                    </a>

                    <x-primary-button class="w-full sm:w-auto justify-center">
                        Register
                    </x-primary-button>
                </div>

            </form>
        </div>
    </div>
</x-guest-layout>