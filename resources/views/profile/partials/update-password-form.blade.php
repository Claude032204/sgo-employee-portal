<section class="space-y-6">

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')"
                class="mb-2 text-sm font-medium text-gray-700" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="block w-full rounded-xl border-gray-200 bg-white px-4 py-3 shadow-sm focus:border-green-400 focus:ring-green-200"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')"
                class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')"
                class="mb-2 text-sm font-medium text-gray-700" />
            <x-text-input id="update_password_password" name="password" type="password"
                class="block w-full rounded-xl border-gray-200 bg-white px-4 py-3 shadow-sm focus:border-green-400 focus:ring-green-200"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')"
                class="mb-2 text-sm font-medium text-gray-700" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="block w-full rounded-xl border-gray-200 bg-white px-4 py-3 shadow-sm focus:border-green-400 focus:ring-green-200"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-2 text-sm text-red-600" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button
                class="rounded-xl px-5 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 shadow-md">
                {{ __('Update Password') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-green-700">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>