<x-app-layout>


    <div class="min-h-screen flex items-center justify-center bg-[#e9ebe6] px-4">

        <div class="w-full max-w-md">

            <div class="bg-[#f5f5f5] rounded-3xl p-8 shadow-sm">

                <!-- TITLE -->
                <h2 class="text-2xl font-bold text-center mb-2">
                    Complete Your Account
                </h2>

                <p class="text-sm text-gray-500 text-center mb-4">
                    Please enter your email and create a password.
                </p>

                <!-- LOGIN ID -->
                <p class="text-center text-sm text-gray-600 mb-6">
                    Your Login ID:
                    <span class="font-semibold">{{ auth()->user()->login_id }}</span>
                </p>

                <!-- STATUS -->
                @if (session('status'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- ERRORS -->
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg text-sm">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('employee.complete-account.update') }}">
                    @csrf

                    <!-- EMAIL -->
                    <div class="mb-4 text-left">
                        <label class="text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="w-full mt-1 h-11 rounded-full bg-gray-300 border-0 px-4" required>
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-4 text-left relative">
                        <label class="text-sm font-medium text-gray-700">New Password</label>
                        <input id="password" type="password" name="password"
                            class="w-full mt-1 h-11 rounded-full bg-gray-300 border-0 px-4 pr-12" required>

                        <button type="button" onclick="togglePassword('password','eye1')"
                            class="absolute right-3 top-[36px] text-gray-600">
                            <svg id="eye1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div class="mb-6 text-left relative">
                        <label class="text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="w-full mt-1 h-11 rounded-full bg-gray-300 border-0 px-4 pr-12" required>

                        <button type="button" onclick="togglePassword('password_confirmation','eye2')"
                            class="absolute right-3 top-[36px] text-gray-600">
                            <svg id="eye2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

                    <!-- BUTTON -->
                    <div class="flex justify-center">
                        <button type="submit" class="bg-gray-600 text-white px-6 py-2 rounded-full w-full">
                            Save and Continue
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <!-- PASSWORD TOGGLE -->
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.368M6.223 6.223A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.132 5.411M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 6L3 3" />
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
</x-app-layout>