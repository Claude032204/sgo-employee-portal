<x-app-layout>

    @php
        $hasIncompleteProfile =
            empty($user->employee_id) ||
            empty($user->sss) ||
            empty($user->tin) ||
            empty($user->philhealth) ||
            empty($user->pagibig) ||
            empty($user->position) ||
            empty($user->department);
    @endphp

    <div class="py-8 bg-gradient-to-br from-[#eef5ec] to-[#f8fbf6] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-[220px_minmax(0,1fr)] gap-6">

                <!-- FULL HEIGHT SIDEBAR -->
                <aside
                    class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-[0_8px_30px_rgba(0,0,0,0.05)] border border-white/50 p-4 h-full lg:min-h-[calc(100vh-120px)] flex flex-col">

                    <div class="mb-4 px-2">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">
                            My Workspace
                        </p>
                    </div>

                    <nav class="space-y-2 flex-1">

                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-3 rounded-2xl px-3 py-3 bg-green-100/80 border border-green-200 text-green-900 shadow-sm">
                            <div class="w-8 h-8 rounded-xl bg-white/80 flex items-center justify-center text-sm">
                                🏠
                            </div>
                            <div>
                                <p class="text-sm font-semibold">Dashboard</p>
                                <p class="text-[11px] text-green-700">Overview</p>
                            </div>
                        </a>

                        <!-- Payslips -->
                        <a href="{{ route('employee.payslips') }}"
                            class="flex items-center gap-3 rounded-2xl px-3 py-3 text-gray-700 hover:bg-green-50 transition">
                            <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center text-sm">
                                📄
                            </div>
                            <div>
                                <p class="text-sm font-medium">My Payslips</p>
                                <p class="text-[11px] text-gray-400">Records</p>
                            </div>
                        </a>

                        <!-- Latest -->
                        @if($latestPayslip)
                            <a href="{{ route('employee.payslips.show', $latestPayslip->id) }}"
                                class="flex items-center gap-3 rounded-2xl px-3 py-3 text-gray-700 hover:bg-green-50 transition">
                                <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center text-sm">
                                    🧾
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Latest Payslip</p>
                                    <p class="text-[11px] text-gray-400">Quick access</p>
                                </div>
                            </a>
                        @endif

                        <!-- Profile -->
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center justify-between rounded-2xl px-3 py-3 text-gray-700 hover:bg-green-50 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center text-sm">
                                    👤
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Profile</p>
                                    <p class="text-[11px] text-gray-400">Account settings</p>
                                </div>
                            </div>

                            @if($hasIncompleteProfile)
                                <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                            @endif
                        </a>

                    </nav>

                    <div class="pt-4 border-t border-gray-100 mt-4 text-xs text-gray-400 text-center">
                        Employee Portal
                    </div>

                </aside>

                <!-- MAIN CONTENT -->
                <div class="space-y-6">

                    <!-- WELCOME -->
                    <div
                        class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-white/40 p-8">
                        <h2 class="text-3xl font-bold text-green-900 mb-2">
                            Welcome {{ $user->name }}
                        </h2>
                        <p class="text-gray-600">
                            Access your payslips and account details here.
                        </p>
                    </div>

                    <!-- TOP SUMMARY CARDS -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- Total Payslips -->
                        <div
                            class="bg-gradient-to-br from-[#e9fbe9] to-[#d9f5d9] rounded-2xl p-6 shadow hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm text-gray-600 font-medium">
                                    Total Payslips
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-green-200 flex items-center justify-center text-lg">
                                    📄
                                </div>
                            </div>

                            <h4 class="text-3xl font-bold text-green-900 mb-2">
                                {{ $totalPayslips }}
                            </h4>

                            <p class="text-sm text-gray-600">
                                Available in your account
                            </p>
                        </div>

                        <!-- Latest Payslip Clickable -->
                        @if($latestPayslip)
                            <a href="{{ route('employee.payslips.show', $latestPayslip->id) }}"
                                class="block bg-gradient-to-br from-[#eef8ff] to-[#dceeff] rounded-2xl p-6 shadow hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="text-sm text-gray-600 font-medium">
                                        Latest Payslip
                                    </div>
                                    <div class="w-10 h-10 rounded-xl bg-blue-200 flex items-center justify-center text-lg">
                                        🧾
                                    </div>
                                </div>

                                <h4 class="text-xl font-bold text-gray-800 mb-2">
                                    {{ $latestPayslip->pay_period }}
                                </h4>

                                <p class="text-sm text-gray-600">
                                    Click to view latest payslip
                                </p>
                            </a>
                        @else
                            <div
                                class="bg-gradient-to-br from-[#eef8ff] to-[#dceeff] rounded-2xl p-6 shadow hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="text-sm text-gray-600 font-medium">
                                        Latest Payslip
                                    </div>
                                    <div class="w-10 h-10 rounded-xl bg-blue-200 flex items-center justify-center text-lg">
                                        🧾
                                    </div>
                                </div>

                                <h4 class="text-xl font-bold text-gray-800 mb-2">
                                    No payslip yet
                                </h4>

                                <p class="text-sm text-gray-600">
                                    Most recent available record
                                </p>
                            </div>
                        @endif

                        <!-- Account Status -->
                        <div
                            class="bg-gradient-to-br from-[#fff7e8] to-[#ffeccc] rounded-2xl p-6 shadow hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm text-gray-600 font-medium">
                                    Account Status
                                </div>
                                <div
                                    class="w-10 h-10 rounded-xl bg-yellow-200 flex items-center justify-center text-lg">
                                    🔐
                                </div>
                            </div>

                            <h4 class="text-xl font-bold text-gray-800 mb-2">
                                {{ $accountStatus['portal_access'] }}
                            </h4>

                            <p class="text-sm text-gray-600">
                                Email Verified: {{ $accountStatus['email_verified'] ? 'Yes' : 'No' }}
                            </p>
                        </div>
                    </div>

                    <!-- RECENT PAYSLIPS -->
                    <div
                        class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-white/40 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-5">
                            Recent Payslips
                        </h3>

                        @if($recentPayslips->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentPayslips as $payslip)
                                    <a href="{{ route('employee.payslips.show', $payslip->id) }}"
                                        class="flex items-center justify-between rounded-2xl border border-gray-100 px-4 py-4 hover:bg-green-50/60 hover:shadow-sm transition">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                                                📄
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $payslip->pay_period }}</p>
                                                <p class="text-xs text-gray-500">Payslip record</p>
                                            </div>
                                        </div>
                                        <span class="text-green-700 font-medium">View →</span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No recent payslips yet.</p>
                        @endif
                    </div>

                    <!-- ACCOUNT INFO + STATUS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div
                            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-white/40 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-5">
                                Account Information
                            </h3>

                            <div class="space-y-4 text-sm">
                                <div>
                                    <p class="text-gray-500">Employee Portal ID</p>
                                    <p class="font-semibold text-gray-800">{{ $user->login_id }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-500">Email</p>
                                    <p class="font-semibold text-gray-800">{{ $user->email }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-500">Position</p>
                                    <p class="font-semibold text-gray-800">{{ $user->position }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-500">Department</p>
                                    <p class="font-semibold text-gray-800">{{ $user->department }}</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-white/40 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-5">
                                Account Status
                            </h3>

                            <div class="space-y-4 text-sm">
                                <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                                    <span class="text-gray-600">Email Verified</span>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium {{ $accountStatus['email_verified'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $accountStatus['email_verified'] ? 'Yes' : 'No' }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                                    <span class="text-gray-600">Portal Access</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                        {{ $accountStatus['portal_access'] }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                                    <span class="text-gray-600">Payslip Access</span>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        {{ $accountStatus['payslip_access'] }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

</x-app-layout>