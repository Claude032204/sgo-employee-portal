<x-app-layout>

    <div class="py-8 bg-gradient-to-br from-[#eef5ec] to-[#f8fbf6] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

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

                        <!-- Upload -->
                        <a href="{{ route('admin.payslips.upload') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 hover:shadow-md transition">
                            <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center">
                                📤
                            </div>
                            <span class="text-sm font-medium text-gray-800">
                                Upload Payslips
                            </span>
                        </a>

                        <!-- Manage (ACTIVE) -->
                        <a href="{{ route('admin.payslips.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-green-100 shadow-inner border border-green-200">
                            <div class="w-9 h-9 rounded-lg bg-green-200 flex items-center justify-center">
                                📄
                            </div>
                            <span class="text-sm font-semibold text-green-900">
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
                        @if($batches->count() > 0)
                            <a href="{{ route('admin.payslips.unmatched', $batches->first()->id) }}"
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
                <div class="flex-1">

                    <!-- CARD -->
                    <div
                        class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-white/40 p-6 space-y-5">

                        <!-- TOP CONTROLS -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                            <h2 class="text-xl font-semibold text-gray-800 tracking-tight">
                                Payslip Batches
                            </h2>

                            <div class="flex items-center gap-3">

                                <!-- Search -->
                                <input type="text" id="searchInput" placeholder="Search batch..."
                                    class="rounded-xl border border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none">

                                <!-- Upload -->
                                <a href="{{ route('admin.payslips.upload') }}"
                                    class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm shadow-md hover:shadow-lg hover:scale-105 transition">
                                    📤 Upload ZIP
                                </a>

                            </div>
                        </div>

                        <!-- TABLE -->
                        <div class="rounded-2xl border border-gray-100 overflow-hidden">
                            <div class="max-h-[400px] overflow-y-auto">

                                <table class="w-full">
                                    <thead class="sticky top-0 bg-white z-10">
                                        <tr class="text-left text-sm text-gray-500 border-b">
                                            <th class="p-4">Batch</th>
                                            <th class="p-4">Files</th>
                                            <th class="p-4">Payslips</th>
                                            <th class="p-4 text-right">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tableBody" class="divide-y">
                                        @forelse($batches as $batch)
                                            <tr class="hover:bg-green-50/50 transition">
                                                <td class="p-4 batch-name">
                                                    <div class="flex flex-col">
                                                        <span class="font-semibold text-gray-800">
                                                            {{ $batch->batch_name }}
                                                        </span>
                                                        <span class="text-xs text-gray-400">
                                                            {{ $batch->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                </td>

                                                <td class="p-4">
                                                    <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                                                        {{ $batch->total_files }} files
                                                    </span>
                                                </td>

                                                <td class="p-4">
                                                    <span
                                                        class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                                        {{ $batch->total_payslips }} payslips
                                                    </span>
                                                </td>

                                                <td class="p-4 text-right">
                                                    <div class="flex justify-end items-center gap-2">
                                                        <a href="{{ route('admin.payslips.unmatched', $batch->id) }}"
                                                            class="inline-flex px-4 py-2 rounded-lg bg-gradient-to-r from-[#6f7f5f] to-[#9bb48a] text-white text-xs hover:scale-105 transition">
                                                            Manage →
                                                        </a>

                                                        <form method="POST"
                                                            action="{{ route('admin.payslips.destroy', $batch->id) }}"
                                                            onsubmit="return confirm('Are you sure you want to delete this batch and all related payslips?');"
                                                            class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="inline-flex px-4 py-2 rounded-lg bg-gradient-to-r from-red-600 to-red-500 text-white text-xs hover:scale-105 transition">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="p-6 text-center text-gray-400">
                                                    No payslip batches uploaded yet.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <!-- Pagination -->
                        <div>
                            {{ $batches->links() }}
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- SEARCH -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('#tableBody tr');

        searchInput.addEventListener('keyup', function () {
            const value = this.value.toLowerCase();

            rows.forEach(row => {
                const name = row.querySelector('.batch-name')?.innerText.toLowerCase();
                row.style.display = name && name.includes(value) ? '' : 'none';
            });
        });
    </script>

</x-app-layout>