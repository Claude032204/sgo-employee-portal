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

                        <!-- Manage -->
                        <a href="{{ route('admin.payslips.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 hover:shadow-md transition">
                            <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center">📄</div>
                            <span class="text-sm font-medium text-gray-800">Manage Payslips</span>
                        </a>

                        <!-- Employees (ACTIVE) -->
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
                        class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-white/40 p-6 space-y-5">

                        <!-- HEADER -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                            <h2 class="text-xl font-semibold text-gray-800">
                                Employee Management
                            </h2>

                            <a href="{{ route('admin.employees.create') }}"
                                class="inline-flex items-center px-5 py-2 rounded-xl bg-gradient-to-r from-green-600 to-green-500 text-white text-sm shadow-md hover:shadow-lg hover:scale-105 transition">
                                ➕ Add Employee
                            </a>

                        </div>

                        <!-- SUCCESS -->
                        @if(session('success'))
                            <div class="p-3 bg-green-100 text-green-800 rounded-xl text-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- SEARCH -->
                        <form method="GET" action="{{ route('admin.employees.index') }}">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search employee..."
                                class="w-full rounded-xl border border-gray-200 px-4 py-2 focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none">
                        </form>

                        <!-- TABLE -->
                        <div class="rounded-2xl border border-gray-100 overflow-hidden">
                            <div class="max-h-[450px] overflow-y-auto">

                                <table class="w-full">
                                    <thead class="sticky top-0 bg-white z-10">
                                        <tr class="text-left text-sm text-gray-500 border-b">
                                            <th class="p-4">Name</th>
                                            <th class="p-4">Login ID</th>
                                            <th class="p-4">Temporary Password</th>
                                            <th class="p-4">Email</th>
                                            <th class="p-4">Department</th>
                                            <th class="p-4">Position</th>
                                            <th class="p-4">Verified</th>
                                            <th class="p-4">Account</th>
                                            <th class="p-4 text-right">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y">

                                        @forelse($employees as $employee)
                                            <tr class="hover:bg-green-50/50 transition">

                                                <td class="p-4 font-medium text-gray-800">
                                                    {{ $employee->name }}
                                                </td>

                                                <td class="p-4 text-sm text-gray-600">
                                                    {{ $employee->login_id }}
                                                </td>

                                                <td class="p-4 text-sm text-gray-600">
                                                    {{ $employee->temp_password ?? 'Changed already' }}
                                                </td>

                                                <td class="p-4 text-sm text-gray-600">
                                                    {{ $employee->email }}
                                                </td>

                                                <td class="p-4 text-sm text-gray-600">
                                                    {{ $employee->department }}
                                                </td>

                                                <td class="p-4 text-sm text-gray-600">
                                                    {{ $employee->position }}
                                                </td>

                                                <!-- Verified -->
                                                <td class="p-4">
                                                    <span
                                                        class="px-3 py-1 rounded-full text-xs 
                                                                                        {{ $employee->email_verified_at ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                                        {{ $employee->email_verified_at ? 'Verified' : 'Not Verified' }}
                                                    </span>
                                                </td>

                                                <!-- Account -->
                                                <td class="p-4">
                                                    <span
                                                        class="px-3 py-1 rounded-full text-xs 
                                                                                        {{ $employee->password ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                        {{ $employee->password ? 'Completed' : 'Pending' }}
                                                    </span>
                                                </td>

                                                <!-- Action -->
                                                <td class="p-4 text-right">
                                                    <form method="POST"
                                                        action="{{ route('admin.employees.destroy', $employee->id) }}"
                                                        onsubmit="return confirm('Are you sure to remove this employee? {{ $employee->name }}');">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="px-3 py-1 rounded-lg bg-red-500 text-white text-xs hover:bg-red-600 transition">
                                                            Remove
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="p-6 text-center text-gray-400">
                                                    No employees found.
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <!-- PAGINATION -->
                        <div>
                            {{ $employees->links() }}
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

</x-app-layout>