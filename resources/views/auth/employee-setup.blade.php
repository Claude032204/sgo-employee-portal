<x-guest-layout>
    <form method="POST" action="{{ route('employee.setup.store') }}">
        @csrf

        <div class="mb-4">
            <x-input-label for="employee_portal_id" :value="__('Employee Portal ID')" />
            <x-text-input id="employee_portal_id" class="block mt-1 w-full" type="text" name="employee_portal_id"
                :value="old('employee_portal_id')" required autofocus />
            <x-input-error :messages="$errors->get('employee_portal_id')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="birthdate" :value="__('Birthdate')" />
            <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate"
                :value="old('birthdate')" required />
            <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Back to Login') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Set Up Account') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>