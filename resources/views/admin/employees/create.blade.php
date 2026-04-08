<x-app-layout>

    <div class="py-8 bg-gradient-to-br from-[#eef5ec] to-[#f8fbf6] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col lg:flex-row gap-6">

                <!-- SIDEBAR -->
                <div
                    class="w-full lg:w-[260px] bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.06)] border border-white/40 p-5">

                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">
                        Quick Actions
                    </h3>

                    <div class="space-y-3">

                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 hover:shadow-md transition">
                            <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center">🏠</div>
                            <span class="text-sm font-medium text-gray-800">Dashboard</span>
                        </a>

                        <!-- Upload -->
                        <a href="{{ route('admin.payslips.upload') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 hover:shadow-md transition">
                            <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center">📤</div>
                            <span class="text-sm font-medium text-gray-800">Upload Payslips</span>
                        </a>

                        <!-- Manage Payslips -->
                        <a href="{{ route('admin.payslips.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 hover:shadow-md transition">
                            <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center">📄</div>
                            <span class="text-sm font-medium text-gray-800">Manage Payslips</span>
                        </a>

                        <!-- Employees ACTIVE -->
                        <a href="{{ route('admin.employees.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-green-100 shadow-inner border border-green-200">
                            <div class="w-9 h-9 rounded-lg bg-green-200 flex items-center justify-center">👥</div>
                            <span class="text-sm font-semibold text-green-900">Employees</span>
                        </a>

                        <!-- Unmatched -->
                        @if(\App\Models\PayslipBatch::count() > 0)
                            <a href="{{ route('admin.payslips.unmatched', \App\Models\PayslipBatch::latest()->first()->id) }}"
                                class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-yellow-50 hover:shadow-md transition">
                                <div class="w-9 h-9 rounded-lg bg-yellow-100 flex items-center justify-center">⚠️</div>
                                <span class="text-sm font-medium text-gray-800">Unmatched Payslips</span>
                            </a>
                        @endif

                    </div>
                </div>

                <!-- MAIN CONTENT -->
                <div class="flex-1">

                    <div
                        class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-white/40 p-8 space-y-6">

                        <!-- Header -->
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-semibold text-gray-800 tracking-tight">
                                    Add Employee
                                </h2>
                                <p class="text-sm text-gray-500 mt-1">
                                    Create a new employee record in the portal.
                                </p>
                            </div>

                            <a href="{{ route('admin.employees.index') }}"
                                class="inline-flex items-center px-4 py-2 rounded-xl bg-gray-100 text-gray-700 text-sm hover:bg-gray-200 transition">
                                ← Back
                            </a>
                        </div>

                        <!-- Errors -->
                        @if ($errors->any())
                            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-4">
                                <div class="text-sm font-semibold text-red-700 mb-2">Please fix the following:</div>
                                <div class="space-y-1 text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <div>• {{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Form -->
                        <form method="POST" action="{{ route('admin.employees.store') }}" class="space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                <!-- Last Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Last Name
                                    </label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}"
                                        class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none transition"
                                        required>
                                    <p class="text-[11px] text-gray-400 mt-1">
                                        Uppercase
                                    </p>
                                </div>

                                <!-- First Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        First Name
                                    </label>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}"
                                        class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none transition"
                                        required>
                                </div>

                                <!-- Middle Name (SHORTER LOOK) -->
                                <div class="md:max-w-[220px]">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Middle Name
                                    </label>
                                    <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                                        class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none transition">
                                    <p class="text-[11px] text-gray-400 mt-1">
                                        Optional
                                    </p>
                                </div>

                            </div>
                            <!-- Submit -->
                            <div class="pt-2">
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-gradient-to-r from-green-600 to-green-500 text-white font-medium shadow-md hover:shadow-lg hover:scale-[1.02] transition-all">
                                    Add Employee
                                </button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>

</x-app-layout>