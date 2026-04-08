<section class="space-y-6">

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rounded-xl px-5 py-3 shadow-md">
        {{ __('Delete Account') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-6">
            @csrf
            @method('delete')

            <div class="space-y-2">
                <h2 class="text-lg font-semibold text-gray-900">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="text-sm text-gray-500">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
            </div>

            <div>
                <x-input-label for="password" value="{{ __('Password') }}"
                    class="mb-2 text-sm font-medium text-gray-700" />

                <x-text-input id="password" name="password" type="password"
                    class="block w-full rounded-xl border-gray-200 bg-white px-4 py-3 shadow-sm focus:border-red-400 focus:ring-red-200"
                    placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-4 py-2">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="rounded-xl px-5 py-2 shadow-md">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>