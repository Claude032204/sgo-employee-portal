<x-guest-layout>
    <div class="min-h-screen flex bg-[#e9ebe6]">

        <!-- LEFT IMAGE SLIDER -->
        <div class="hidden md:block md:w-[38%] overflow-hidden relative">
            <div id="slider" class="flex h-screen w-[300%]">
                <img src="{{ asset('images/imgbg1.jpg') }}" class="w-1/3 h-screen object-cover flex-shrink-0">
                <img src="{{ asset('images/imgbg2.jpg') }}" class="w-1/3 h-screen object-cover flex-shrink-0">
                <img src="{{ asset('images/imgbg1.jpg') }}" class="w-1/3 h-screen object-cover flex-shrink-0">
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="flex w-full md:w-[62%] items-center justify-center px-4 sm:px-6 h-screen overflow-hidden">
            <div class="w-full max-w-md text-center">

                <h1 class="text-3xl sm:text-4xl font-bold mb-4 sm:mb-6">Sign In</h1>

                <div class="bg-[#f5f5f5] rounded-3xl py-10 px-6 sm:px-8 shadow-sm">

                    <!-- LOGO -->
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('images/synerglogo.png') }}" class="h-12 sm:h-14 object-contain">
                    </div>

                    @if (session('status'))
                        <div class="mb-4 rounded-lg bg-green-100 p-3 text-sm text-green-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Login -->
                        <div class="text-left">
                            <label for="login" class="text-sm font-medium text-gray-700">
                                Login ID or Email
                            </label>
                            <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
                                class="w-full mt-1 mb-3 h-11 rounded-full bg-gray-300 border-0 px-4"
                                placeholder="Enter your Login ID or Email">
                            <x-input-error :messages="$errors->get('login')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="text-left relative mt-2">
                            <label for="password" class="text-sm font-medium text-gray-700">
                                Password
                            </label>

                            <input id="password" type="password" name="password" required
                                class="w-full mt-1 mb-3 h-11 rounded-full bg-gray-300 border-0 px-4 pr-12">

                            <button type="button" onclick="togglePassword()"
                                class="absolute right-3 top-[36px] text-gray-600">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Forgot Password -->
                        <div class="text-center text-sm mt-4 mb-4">
                            @if (Route::has('password.request'))
                                <a class="text-gray-600 hover:text-gray-900 hover:underline"
                                    href="{{ route('password.request') }}">
                                    Forgot your password?
                                </a>
                            @endif
                        </div>

                        <!-- BUTTON -->
                        <div class="flex justify-center">
                            <button type="submit"
                                class="bg-gray-600 text-white px-6 py-2 rounded-full w-full sm:w-auto">
                                Log in
                            </button>
                        </div>

                        <!-- REGISTER LINK -->
                        <div class="text-center mt-4 text-sm">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="font-semibold text-gray-700 hover:underline">
                                Register
                            </a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- SLIDER -->
    <script>
        let currentSlide = 0;
        const slider = document.getElementById('slider');
        const totalSlides = 3;

        function goToSlide(index, withTransition = true) {
            slider.style.transition = withTransition ? 'transform 0.8s ease-in-out' : 'none';
            slider.style.transform = `translateX(-${index * 33.3333}%)`;
        }

        setInterval(() => {
            currentSlide++;
            goToSlide(currentSlide);

            if (currentSlide === totalSlides - 1) {
                setTimeout(() => {
                    currentSlide = 0;
                    goToSlide(currentSlide, false);
                }, 800);
            }
        }, 4000);
    </script>

    <!-- PASSWORD TOGGLE -->
    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.368M6.223 6.223A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.132 5.411M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 6L3 3" />
                `;
            } else {
                password.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
</x-guest-layout>