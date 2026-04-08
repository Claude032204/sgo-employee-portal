<x-app-layout>
    <x-slot name="header">
        @php
            $user = auth()->user();

            $hasIncompleteProfile =
                empty($user->employee_id) ||
                empty($user->sss) ||
                empty($user->tin) ||
                empty($user->philhealth) ||
                empty($user->pagibig) ||
                empty($user->position) ||
                empty($user->department);

            $profileFields = [
                $user->employee_id,
                $user->sss,
                $user->tin,
                $user->philhealth,
                $user->pagibig,
                $user->position,
                $user->department,
            ];

            $completedFields = collect($profileFields)->filter(fn($field) => !empty($field))->count();
            $totalFields = count($profileFields);
            $completionPercentage = intval(($completedFields / $totalFields) * 100);
        @endphp

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-emerald-900 leading-tight">
                    My Profile
                </h2>
                <p class="text-sm text-emerald-700 mt-1">
                    View and update your personal and employment details.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-xs text-emerald-700 font-medium">Profile Completion</p>
                    <p class="text-sm font-bold text-emerald-900">{{ $completionPercentage }}%</p>
                </div>

                <div class="relative">
                    <div
                        class="w-11 h-11 rounded-full bg-white border border-emerald-200 shadow-sm flex items-center justify-center text-lg">
                        @if($hasIncompleteProfile)
                            ⚠️
                        @else
                            ✅
                        @endif
                    </div>

                    @if($hasIncompleteProfile)
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-emerald-50 via-white to-green-100 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Quick Navigation --}}
            <div class="flex flex-wrap gap-3">

                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border font-semibold transition
    {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm' : 'bg-white text-emerald-800 border-emerald-200 hover:bg-emerald-50' }}">
                    <span>🏠</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('employee.payslips') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border font-semibold transition
    {{ request()->routeIs('employee.payslips*') ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm' : 'bg-white text-emerald-800 border-emerald-200 hover:bg-emerald-50' }}">
                    <span>📄</span>
                    <span>Payslips</span>
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border font-semibold transition
    {{ request()->routeIs('profile.edit') ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm' : 'bg-white text-emerald-800 border-emerald-200 hover:bg-emerald-50' }}">
                    <span>👤</span>
                    <span>Profile</span>
                </a>

            </div>

            @if (session('status') === 'profile-updated')
                <div
                    class="flex items-start gap-3 p-4 rounded-2xl border border-green-200 bg-green-50 text-green-800 shadow-sm">
                    <div class="text-xl">✅</div>
                    <div>
                        <p class="font-semibold">Profile updated successfully.</p>
                        <p class="text-sm text-green-700">Your account information has been saved.</p>
                    </div>
                </div>
            @endif

            @if($hasIncompleteProfile)
                <div
                    class="flex items-start gap-3 p-4 rounded-2xl border border-yellow-200 bg-yellow-50 text-yellow-800 shadow-sm">
                    <div class="text-xl">⚠️</div>
                    <div>
                        <p class="font-semibold">Incomplete profile information</p>
                        <p class="text-sm text-yellow-700">
                            Please complete the required employment and government details to keep your account updated.
                        </p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-2xl border border-red-200 bg-red-50 text-red-800 shadow-sm">
                    <p class="font-semibold mb-2">Please fix the following:</p>
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white border border-emerald-100 rounded-3xl shadow-sm overflow-hidden">
                <div
                    class="px-6 md:px-8 py-6 border-b border-emerald-100 bg-gradient-to-r from-emerald-700 via-emerald-600 to-green-600 text-white">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm border border-white/20 flex items-center justify-center text-2xl font-bold">
                                {{ strtoupper(substr($user->first_name ?? $user->name, 0, 1)) }}
                            </div>
                            <di<h3 class="text-xl font-bold">
                                {{ strtoupper($user->last_name) }},
                                {{ $user->first_name }}{{ $user->middle_name ? ' ' . $user->middle_name : '' }}
                                </h3>
                                <p class="text-emerald-50 text-sm">
                                    {{ $user->position ?: 'Employee' }}{{ $user->department ? ' • ' . $user->department : '' }}
                                </p>
                        </div>
                    </div>

                    <div class="w-full md:w-56">
                        <div class="flex items-center justify-between text-xs text-white/90 mb-1">
                            <span>Completion</span>
                            <span>{{ $completionPercentage }}%</span>
                        </div>
                        <div class="w-full h-2.5 bg-white/20 rounded-full overflow-hidden">
                            <div class="h-full bg-white rounded-full" style="width: {{ $completionPercentage }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="p-6 md:p-8">
                @csrf
                @method('patch')

                <div class="space-y-8">

                    {{-- Personal Information --}}
                    <div>
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-emerald-900">Personal Information</h3>
                            <p class="text-sm text-emerald-700">These details are read-only and based on your
                                account record.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-emerald-800 mb-2">Last Name</label>
                                <input type="text" value="{{ strtoupper($user->last_name) }}"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-100 px-4 py-3 text-gray-700 focus:outline-none"
                                    readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-emerald-800 mb-2">First Name</label>
                                <input type="text" value="{{ $user->first_name }}"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-100 px-4 py-3 text-gray-700 focus:outline-none"
                                    readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-emerald-800 mb-2">Middle Name</label>
                                <input type="text" value="{{ $user->middle_name }}"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-100 px-4 py-3 text-gray-700 focus:outline-none"
                                    readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-emerald-800 mb-2">Login ID</label>
                                <input type="text" value="{{ $user->login_id }}"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-100 px-4 py-3 text-gray-700 focus:outline-none"
                                    readonly>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-emerald-800 mb-2">Email Address</label>
                                <input type="text" value="{{ $user->email }}"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-100 px-4 py-3 text-gray-700 focus:outline-none"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    {{-- Employment Information --}}
                    <div class="border-t border-emerald-100 pt-8">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-emerald-900">Employment Information</h3>
                            <p class="text-sm text-emerald-700">Update your work-related details below.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-emerald-800 mb-2">Employee ID</label>
                                <input type="text" name="employee_id"
                                    value="{{ old('employee_id', $user->employee_id) }}"
                                    class="w-full rounded-xl border border-emerald-200 px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-emerald-800 mb-2">Position</label>
                                <input type="text" name="position" value="{{ old('position', $user->position) }}"
                                    class="w-full rounded-xl border border-emerald-200 px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-emerald-800 mb-2">Department</label>
                                <input type="text" name="department" value="{{ old('department', $user->department) }}"
                                    class="w-full rounded-xl border border-emerald-200 px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- Government Information --}}
                    <div class="border-t border-emerald-100 pt-8">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-emerald-900">Government Information</h3>
                            <p class="text-sm text-emerald-700">Provide your required government identification
                                details.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-emerald-800 mb-2">SSS</label>
                                <input type="text" name="sss" value="{{ old('sss', $user->sss) }}"
                                    class="w-full rounded-xl border border-emerald-200 px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-emerald-800 mb-2">TIN</label>
                                <input type="text" name="tin" value="{{ old('tin', $user->tin) }}"
                                    class="w-full rounded-xl border border-emerald-200 px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-emerald-800 mb-2">PhilHealth</label>
                                <input type="text" name="philhealth" value="{{ old('philhealth', $user->philhealth) }}"
                                    class="w-full rounded-xl border border-emerald-200 px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-emerald-800 mb-2">Pag-IBIG</label>
                                <input type="text" name="pagibig" value="{{ old('pagibig', $user->pagibig) }}"
                                    class="w-full rounded-xl border border-emerald-200 px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                            </div>
                        </div>
                    </div>

                    <div
                        class="border-t border-emerald-100 pt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <p class="text-sm text-emerald-700">
                            Keep your details accurate to avoid issues with account access and payroll records.
                        </p>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-semibold shadow-sm transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 3.75H6.75A2.25 2.25 0 004.5 6v12a2.25 2.25 0 002.25 2.25h10.5A2.25 2.25 0 0019.5 18V6.75L16.5 3.75z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 13.5l2 2 4-4" />
                            </svg>
                            Save Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</x-app-layout>