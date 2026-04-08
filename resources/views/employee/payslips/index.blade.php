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

                        <!-- Payslips ACTIVE -->
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

                        <!-- Latest -->
                        @if($payslips->count() > 0)
                            <a href="{{ route('employee.payslips.show', $payslips->first()->id) }}"
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
                            My Payslips
                        </h2>
                        <p class="text-gray-600">
                            View and download your available payslip records.
                        </p>
                    </div>

                    <!-- PAYSLIPS LIST -->
                    <div
                        class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-white/40 p-6">

                        @if($payslips->count() == 0)
                            <div class="text-center py-12">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                                    📄
                                </div>
                                <p class="text-gray-600 font-medium">No payslips available yet.</p>
                                <p class="text-sm text-gray-400 mt-1">Your payslips will appear here once uploaded.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($payslips as $payslip)
                                    <div
                                        class="rounded-2xl border border-green-100 bg-white px-5 py-4 hover:bg-green-50/60 hover:shadow-md transition">
                                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center text-lg">
                                                    📄
                                                </div>

                                                <div>
                                                    <a href="{{ route('employee.payslips.show', $payslip->id) }}"
                                                        class="text-lg font-semibold text-gray-800 hover:text-green-800 transition">
                                                        {{ $payslip->pay_period }}
                                                    </a>
                                                    <p class="text-sm text-gray-500">
                                                        Payslip record
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('employee.payslips.show', $payslip->id) }}"
                                                    class="inline-flex px-4 py-2 rounded-full bg-white border border-green-200 text-green-800 text-sm font-medium hover:bg-green-50 transition">
                                                    View
                                                </a>

                                                <a href="{{ route('employee.payslips.download', $payslip->id) }}"
                                                    class="inline-flex px-5 py-2 rounded-full bg-gradient-to-r from-[#6f7f5f] to-[#9bb48a] text-white text-sm font-medium shadow-md hover:shadow-lg hover:scale-105 transition">
                                                    Download
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>

                </div>

            </div>
        </div>
    </div>

</x-app-layout>