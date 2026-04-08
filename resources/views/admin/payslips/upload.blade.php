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
                            <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center">
                                🏠
                            </div>
                            <span class="text-sm font-medium text-gray-800">
                                Dashboard
                            </span>
                        </a>

                        <!-- Upload (ACTIVE) -->
                        <a href="{{ route('admin.payslips.upload') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-green-100 shadow-inner border border-green-200">
                            <div class="w-9 h-9 rounded-lg bg-green-200 flex items-center justify-center">
                                📤
                            </div>
                            <span class="text-sm font-semibold text-green-900">
                                Upload Payslips
                            </span>
                        </a>

                        <!-- Manage -->
                        <a href="{{ route('admin.payslips.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 hover:shadow-md transition">
                            <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center">
                                📄
                            </div>
                            <span class="text-sm font-medium text-gray-800">
                                Manage Payslips
                            </span>
                        </a>

                        <!-- Employees -->
                        <a href="{{ route('admin.employees.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 hover:shadow-md transition">
                            <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center">
                                👥
                            </div>
                            <span class="text-sm font-medium text-gray-800">
                                Employees
                            </span>
                        </a>

                        <!-- Unmatched (LAST) -->
                        @if(\App\Models\PayslipBatch::count() > 0)
                            <a href="{{ route('admin.payslips.unmatched', \App\Models\PayslipBatch::latest()->first()->id) }}"
                                class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-yellow-50 hover:shadow-md transition">
                                <div class="w-9 h-9 rounded-lg bg-yellow-100 flex items-center justify-center">
                                    ⚠️
                                </div>
                                <span class="text-sm font-medium text-gray-800">
                                    Unmatched Payslips
                                </span>
                            </a>
                        @endif

                    </div>
                </div>

                <!-- MAIN CONTENT -->
                <div class="flex-1 space-y-6">

                    <!-- BULK UPLOAD -->
                    <div
                        class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-white/40 p-8">

                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-xl">
                                📦
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">
                                Bulk Upload (ZIP)
                            </h3>
                        </div>

                        <form action="{{ route('admin.payslips.store') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-5">
                            @csrf

                            <!-- Pay Period -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-2">
                                    Pay Period
                                </label>

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                                    <select name="month"
                                        class="rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none transition"
                                        required>
                                        <option value="">Month</option>
                                        @foreach([
                                            'January','February','March','April','May','June',
                                            'July','August','September','October','November','December'
                                        ] as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>

                                    <input type="number" name="start_day" min="1" max="31"
                                        placeholder="Start Day"
                                        class="rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none transition"
                                        required>

                                    <input type="number" name="end_day" min="1" max="31"
                                        placeholder="End Day"
                                        class="rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none transition"
                                        required>

                                    <input type="number" name="year" min="2000" max="2100"
                                        placeholder="Year"
                                        class="rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none transition"
                                        required>
                                </div>

                                <p class="text-xs text-gray-400 mt-2">
                                    Example: March 8–12, 2026
                                </p>
                            </div>

                            <!-- ZIP -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">
                                    ZIP File
                                </label>
                                <input type="file" name="zip_file"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 bg-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-green-100 file:text-green-800 hover:file:bg-green-200 transition"
                                    accept=".zip" required>
                            </div>

                            <button type="submit"
                                class="w-full py-3 rounded-xl bg-gradient-to-r from-green-600 to-green-500 text-white font-medium shadow-md hover:shadow-lg hover:scale-[1.02] transition-all">
                                Upload ZIP
                            </button>
                        </form>
                    </div>

                    <!-- MANUAL UPLOAD -->
                    <div
                        class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-white/40 p-8">

                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-xl">
                                📄
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">
                                Manual Payslip Upload
                            </h3>
                        </div>

                        <form action="{{ route('admin.manual-payslips.store') }}" method="POST"
                            enctype="multipart/form-data" class="space-y-5">
                            @csrf

                            <!-- Employee -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">
                                    Employee
                                </label>
                                <select name="user_id"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition"
                                    required>
                                    <option value="">Select Employee</option>
                                    @foreach(\App\Models\User::where('role', 'employee')->orderBy('name')->get() as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->name }} ({{ $employee->login_id }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Pay Period -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-2">
                                    Pay Period
                                </label>

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                                    <select name="month"
                                        class="rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition"
                                        required>
                                        <option value="">Month</option>
                                        @foreach([
                                            'January','February','March','April','May','June',
                                            'July','August','September','October','November','December'
                                        ] as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>

                                    <input type="number" name="start_day" min="1" max="31" placeholder="Start Day"
                                        class="rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition"
                                        required>

                                    <input type="number" name="end_day" min="1" max="31" placeholder="End Day"
                                        class="rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition"
                                        required>

                                    <input type="number" name="year" min="2000" max="2100" placeholder="Year"
                                        class="rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition"
                                        required>
                                </div>

                                <p class="text-xs text-gray-400 mt-2">
                                    Example: March 8–12, 2026
                                </p>
                            </div>

                            <!-- File -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">
                                    PNG or IMG
                                </label>
                                <input type="file" name="payslip_file"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 bg-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-100 file:text-blue-800 hover:file:bg-blue-200 transition"
                                    accept=".png,.jpg,.jpeg,.pdf" required>
                            </div>

                            <button type="submit"
                                class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white font-medium shadow-md hover:shadow-lg hover:scale-[1.02] transition-all">
                                Upload Payslip
                            </button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- MANUAL UPLOAD TOAST -->
    @if(session('manual_success'))
        <div id="manual-toast"
            class="fixed bottom-6 right-6 z-[9999] bg-white border border-green-200 shadow-xl rounded-2xl px-5 py-4 flex items-center gap-4">

            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-lg">
                ✔
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-800">
                    Manual Upload Complete
                </p>
                <p class="text-xs text-gray-500">
                    {{ session('manual_success') }}
                </p>
            </div>

            <button type="button"
                onclick="closeManualToast()"
                class="ml-3 text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>

        <style>
            @keyframes manual-toast-in {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            @keyframes manual-toast-out {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }

            #manual-toast {
                animation: manual-toast-in 0.35s ease-out;
            }

            .manual-toast-hide {
                animation: manual-toast-out 0.35s ease-in forwards;
            }
        </style>

        <script>
            function closeManualToast() {
                const toast = document.getElementById('manual-toast');
                if (!toast) return;

                toast.classList.add('manual-toast-hide');
                setTimeout(() => {
                    toast.remove();
                }, 350);
            }

            setTimeout(() => {
                closeManualToast();
            }, 4000);
        </script>
    @endif

</x-app-layout>