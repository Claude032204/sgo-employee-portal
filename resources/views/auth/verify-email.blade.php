<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white shadow-lg rounded-2xl border border-green-100 p-8">

            {{-- Header --}}
            <div class="text-center mb-6">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-green-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 3.75h-9A2.25 2.25 0 005.25 6v12A2.25 2.25 0 007.5 20.25h9A2.25 2.25 0 0018.75 18V6A2.25 2.25 0 0016.5 3.75z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5l4.5 3 4.5-3" />
                    </svg>
                </div>

                <h1 class="text-2xl font-bold text-green-900">Verify Your Email</h1>
                <p class="mt-2 text-sm text-gray-500">
                    We sent a verification link to your email address.
                </p>
            </div>

            {{-- Success Message --}}
            @if (session('status') == 'verification-link-sent')
                <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            {{-- Instructions --}}
            <div class="mb-5 text-sm leading-relaxed text-gray-700">
                Before continuing, please check your inbox and click the verification link.
                If you did not receive the email, you can resend it below.
            </div>

            {{-- User Info --}}
            <div class="mb-6 rounded-xl border border-green-100 bg-green-50 p-4">
                <h2 class="mb-3 text-sm font-semibold text-green-900">Account Information</h2>

                <div class="space-y-2 text-sm text-gray-700">
                    <div class="flex items-center justify-between border-b border-green-100 pb-2">
                        <span class="font-medium text-gray-600">Login ID</span>
                        <span class="text-green-900 font-semibold">{{ auth()->user()->login_id }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-gray-600">Email</span>
                        <span
                            class="text-green-900 font-semibold break-all text-right">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-xl bg-green-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-xl border border-gray-300 px-5 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>