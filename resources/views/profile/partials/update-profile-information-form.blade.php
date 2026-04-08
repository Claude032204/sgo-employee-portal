<section class="space-y-6">


    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" class="mb-2 text-sm font-medium text-gray-700" />
            <x-text-input id="name" name="name" type="text"
                class="block w-full rounded-xl border-gray-200 bg-white px-4 py-3 shadow-sm focus:border-green-400 focus:ring-green-200"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-sm text-red-600" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="mb-2 text-sm font-medium text-gray-700" />
            <x-text-input id="email" name="email" type="email"
                class="block w-full rounded-xl border-gray-200 bg-white px-4 py-3 shadow-sm focus:border-green-400 focus:ring-green-200"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 text-sm text-red-600" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-4 rounded-2xl border border-yellow-200 bg-yellow-50 px-4 py-3">
                    <p class="text-sm text-yellow-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="ml-1 font-medium underline underline-offset-2 hover:text-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-300 rounded-md">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-700">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button
                class="rounded-xl px-5 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 shadow-md">
                {{ __('Save Changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-green-700">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>