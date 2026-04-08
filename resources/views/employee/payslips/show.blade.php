<x-app-layout>

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
                            class="flex items-center gap-3 rounded-2xl px-3 py-3 text-gray-700 hover:bg-green-50 transition">
                            <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center text-sm">
                                🏠
                            </div>
                            <div>
                                <p class="text-sm font-medium">Dashboard</p>
                                <p class="text-[11px] text-gray-400">Overview</p>
                            </div>
                        </a>

                        <!-- My Payslips ACTIVE -->
                        <a href="{{ route('employee.payslips') }}"
                            class="flex items-center gap-3 rounded-2xl px-3 py-3 bg-green-100/80 border border-green-200 text-green-900 shadow-sm">
                            <div class="w-8 h-8 rounded-xl bg-white/80 flex items-center justify-center text-sm">
                                📄
                            </div>
                            <div>
                                <p class="text-sm font-semibold">My Payslips</p>
                                <p class="text-[11px] text-green-700">Records</p>
                            </div>
                        </a>

                        <!-- Current Payslip -->
                        <a href="{{ route('employee.payslips.show', $payslip->id) }}"
                            class="flex items-center gap-3 rounded-2xl px-3 py-3 text-gray-700 hover:bg-green-50 transition">
                            <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center text-sm">
                                🧾
                            </div>
                            <div>
                                <p class="text-sm font-medium">Payslip Details</p>
                                <p class="text-[11px] text-gray-400">{{ $payslip->pay_period }}</p>
                            </div>
                        </a>

                        <!-- Profile -->
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 rounded-2xl px-3 py-3 text-gray-700 hover:bg-green-50 transition">
                            <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center text-sm">
                                👤
                            </div>
                            <div>
                                <p class="text-sm font-medium">Profile</p>
                                <p class="text-[11px] text-gray-400">Account settings</p>
                            </div>
                        </a>

                    </nav>

                    <div class="pt-4 border-t border-gray-100 mt-4 text-xs text-gray-400 text-center">
                        Employee Portal
                    </div>

                </aside>

                <!-- MAIN CONTENT -->
                <div class="space-y-6">

                    <!-- PAGE HEADER -->
                    <div
                        class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-white/40 p-8">
                        <h2 class="text-3xl font-bold text-green-900 mb-2">
                            Payslip Details
                        </h2>
                        <p class="text-gray-600">
                            Review and download your payslip record.
                        </p>
                    </div>

                    <!-- DETAILS + PREVIEW -->
                    <div
                        class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-white/40 p-6">

                        <!-- Top info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="rounded-2xl bg-gradient-to-r from-[#eafbe7] to-[#dff4df] p-5">
                                <p class="text-sm text-gray-600 mb-1">Pay Period</p>
                                <p class="text-xl font-bold text-green-900">
                                    {{ $payslip->pay_period }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-white border border-green-100 p-5">
                                <p class="text-sm text-gray-600 mb-1">Employee Name</p>
                                <p class="text-xl font-bold text-gray-800">
                                    {{ $payslip->employee_name }}
                                </p>
                            </div>
                        </div>

                        <!-- Image preview -->
                        @if($payslip->file_path)
                            <div class="rounded-3xl border border-green-100 bg-[#f7fbf7] p-4">
                                <img src="{{ asset('storage/' . $payslip->file_path) }}" alt="Payslip"
                                    class="w-full max-h-[850px] object-contain rounded-2xl border border-green-100 shadow-sm bg-white">
                            </div>
                        @else
                            <div class="rounded-2xl border border-green-100 bg-green-50 p-6 text-center">
                                <p class="text-green-700">Payslip image not available.</p>
                            </div>
                        @endif

                        <!-- Buttons -->
                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('employee.payslips') }}"
                                class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-white border border-green-200 text-green-800 font-medium hover:bg-green-50 transition">
                                ← Back to Payslips
                            </a>

                            <a href="{{ route('employee.payslips.download', $payslip->id) }}"
                                class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-gradient-to-r from-[#6f7f5f] to-[#9bb48a] text-white font-medium shadow-md hover:shadow-lg hover:scale-[1.02] transition">
                                Download Payslip
                            </a>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

</x-app-layout>