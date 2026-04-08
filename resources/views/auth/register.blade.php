<x-guest-layout>
    <div class="min-h-screen bg-[#e9ebe6]">

        <!-- TOP IMAGE SLIDER -->
        <div class="w-full overflow-hidden relative h-[55vh] md:h-[60vh] bg-[#e9ebe6]">
            <div id="slider" class="flex h-full w-[300%]">
                <img src="{{ asset('images/imgbg1.jpg') }}"
                    class="w-1/3 h-full object-cover object-center flex-shrink-0" alt="Image 1">

                <img src="{{ asset('images/imgbg2.jpg') }}"
                    class="w-1/3 h-full object-cover object-center flex-shrink-0" alt="Image 2">

                <img src="{{ asset('images/imgbg1.jpg') }}"
                    class="w-1/3 h-full object-cover object-center flex-shrink-0" alt="Image 1 Clone">
            </div>
        </div>

        <!-- REGISTER SECTION -->
        <div class="flex justify-center px-4 -mt-40 md:-mt-52 relative z-10 pb-8">
            <div class="w-full max-w-xl text-center">

                <!-- CARD -->
                <div class="bg-[#f5f5f5] rounded-3xl p-6 sm:p-8 shadow-xl">

                    <!-- TITLE INSIDE CARD -->
                    <h1 class="text-3xl font-bold text-center mb-4">Register</h1>

                    <div class="flex justify-center mb-3">
                        <img src="{{ asset('images/synerglogo.png') }}" class="h-12 sm:h-14 object-contain"
                            alt="Synerg Logo">
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">

                            <div>
                                <label for="last_name" class="text-sm font-medium text-gray-700">Last Name</label>
                                <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}"
                                    required autofocus
                                    class="block mt-1 w-full h-11 rounded-full bg-gray-300 border-0 px-4">
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="first_name" class="text-sm font-medium text-gray-700">First Name</label>
                                <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}"
                                    required class="block mt-1 w-full h-11 rounded-full bg-gray-300 border-0 px-4">
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="middle_name" class="text-sm font-medium text-gray-700">Middle Name</label>
                                <input id="middle_name" type="text" name="middle_name" value="{{ old('middle_name') }}"
                                    class="block mt-1 w-full h-11 rounded-full bg-gray-300 border-0 px-4">
                                <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="email" class="text-sm font-medium text-gray-700">Email Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    class="block mt-1 w-full h-11 rounded-full bg-gray-300 border-0 px-4">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="relative">
                                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                                <input id="password" type="password" name="password" required
                                    class="block mt-1 w-full h-11 rounded-full bg-gray-300 border-0 px-4 pr-12">
                                <button type="button" onclick="togglePassword('password', 'eyeIcon1')"
                                    class="absolute right-3 top-[36px] text-gray-600">
                                    <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="relative">
                                <label for="password_confirmation" class="text-sm font-medium text-gray-700">Confirm
                                    Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="block mt-1 w-full h-11 rounded-full bg-gray-300 border-0 px-4 pr-12">
                                <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')"
                                    class="absolute right-3 top-[36px] text-gray-600">
                                    <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col items-center gap-3">
                            <button type="submit"
                                class="bg-gray-600 text-white px-8 py-2 rounded-full w-full sm:w-auto">
                                Register
                            </button>

                            <a class="text-sm text-gray-700 hover:underline" href="{{ route('login') }}">
                                Already registered? Sign In
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
        function togglePassword(inputId, iconId) {
            const password = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

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