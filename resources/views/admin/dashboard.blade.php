<x-app-layout>

    <div class="py-8 bg-gradient-to-br from-[#eef5ec] to-[#f8fbf6] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col lg:flex-row gap-6">

                <!-- Sidebar -->
                <div
                    class="w-full lg:w-[260px] bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.06)] border border-white/40 p-5">

                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">
                        Quick Actions
                    </h3>

                    <div class="space-y-3">

                        <!-- 🔥 Dashboard (ACTIVE) -->
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-green-100 shadow-inner border border-green-200">

                            <div class="w-9 h-9 rounded-lg bg-green-200 flex items-center justify-center">
                                🏠
                            </div>

                            <span class="text-sm font-semibold text-green-900">
                                Dashboard
                            </span>
                        </a>

                        <!-- Upload -->
                        <a href="{{ route('admin.payslips.upload') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 hover:shadow-md transition-all duration-200 group">

                            <div
                                class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center group-hover:scale-110 transition">
                                📤
                            </div>

                            <span class="text-sm font-medium text-gray-800">
                                Upload Payslips
                            </span>
                        </a>

                        <!-- Manage -->
                        <a href="{{ route('admin.payslips.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 hover:shadow-md transition-all duration-200 group">

                            <div
                                class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center group-hover:scale-110 transition">
                                📄
                            </div>

                            <span class="text-sm font-medium text-gray-800">
                                Manage Payslips
                            </span>
                        </a>

                        <!-- Employees -->
                        <a href="{{ route('admin.employees.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 hover:shadow-md transition-all duration-200 group">

                            <div
                                class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center group-hover:scale-110 transition">
                                👥
                            </div>

                            <span class="text-sm font-medium text-gray-800">
                                Employees
                            </span>
                        </a>

                        <!-- Unmatched (LAST) -->
                        @if($lastBatch)
                            <a href="{{ route('admin.payslips.unmatched', $lastBatch->id) }}"
                                class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-yellow-50 hover:shadow-md transition-all duration-200 group">

                                <div
                                    class="w-9 h-9 rounded-lg bg-yellow-100 flex items-center justify-center group-hover:scale-110 transition">
                                    ⚠️
                                </div>

                                <span class="text-sm font-medium text-gray-800">
                                    Unmatched Payslips
                                </span>
                            </a>
                        @endif

                    </div>
                </div>

                <!-- Main Content -->
                <div
                    class="flex-1 bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.07)] border border-white/40 p-8">

                    <h3 class="text-2xl font-semibold text-gray-800 mb-8 tracking-tight text-center">
                        Dashboard Overview
                    </h3>

                    <!-- (rest of your dashboard stays unchanged) -->

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                        <!-- Employees -->
                        <div
                            class="group bg-gradient-to-br from-[#e9fbe9] to-[#d9f5d9] rounded-2xl p-6 shadow hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm text-gray-600 font-medium">Employees</div>
                                <div class="w-10 h-10 rounded-xl bg-green-200 flex items-center justify-center text-lg">
                                    👥</div>
                            </div>

                            <h4 class="text-3xl font-bold text-green-900 mb-4">
                                {{ $totalEmployees }}
                            </h4>

                            <a href="{{ route('admin.employees.index') }}"
                                class="inline-flex px-5 py-2 rounded-full bg-gradient-to-r from-[#6f7f5f] to-[#9bb48a] text-white text-sm shadow-md hover:shadow-lg hover:scale-105 transition">
                                Manage →
                            </a>
                        </div>

                        <!-- Payslips -->
                        <div
                            class="group bg-gradient-to-br from-[#e9fbe9] to-[#d9f5d9] rounded-2xl p-6 shadow hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm text-gray-600 font-medium">Payslips</div>
                                <div class="w-10 h-10 rounded-xl bg-green-200 flex items-center justify-center text-lg">
                                    📄</div>
                            </div>

                            <h4 class="text-3xl font-bold text-green-900 mb-4">
                                {{ $totalPayslips }}
                            </h4>

                            <a href="{{ route('admin.payslips.index') }}"
                                class="inline-flex px-5 py-2 rounded-full bg-gradient-to-r from-[#6f7f5f] to-[#9bb48a] text-white text-sm shadow-md hover:shadow-lg hover:scale-105 transition">
                                Manage →
                            </a>
                        </div>

                        <!-- Unmatched -->
                        <div
                            class="group bg-gradient-to-br from-[#fff6e5] to-[#ffeccc] rounded-2xl p-6 shadow hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm text-gray-600 font-medium">Unmatched</div>
                                <div
                                    class="w-10 h-10 rounded-xl bg-yellow-200 flex items-center justify-center text-lg">
                                    ⚠️</div>
                            </div>

                            <h4 class="text-3xl font-bold text-yellow-700 mb-4">
                                {{ $unmatchedPayslips }}
                            </h4>

                            @if($lastBatch)
                                <a href="{{ route('admin.payslips.unmatched', $lastBatch->id) }}"
                                    class="inline-flex px-5 py-2 rounded-full bg-gradient-to-r from-[#6f7f5f] to-[#9bb48a] text-white text-sm shadow-md hover:shadow-lg hover:scale-105 transition">
                                    Manage →
                                </a>
                            @else
                                <span class="inline-flex px-5 py-2 rounded-full bg-gray-300 text-white text-sm">
                                    Manage →
                                </span>
                            @endif
                        </div>

                    </div>

                    <!-- Last Batch -->
                    <div
                        class="bg-gradient-to-r from-[#eafbe7] to-[#dff4df] rounded-2xl shadow-md px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-sm text-gray-600 font-medium mb-1">
                                Last Upload Batch
                            </p>

                            <h4 class="text-lg font-bold text-green-900">
                                {{ $lastBatch?->batch_name ?? 'No uploads yet' }}
                            </h4>
                        </div>

                        <a href="{{ route('admin.payslips.index') }}"
                            class="inline-flex px-6 py-2 rounded-full bg-gradient-to-r from-[#6f7f5f] to-[#9bb48a] text-white text-sm shadow-md hover:shadow-lg hover:scale-105 transition">
                            View →
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>