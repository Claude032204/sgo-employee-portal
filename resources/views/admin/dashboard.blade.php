<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-green-900 leading-tight">
            HR / Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-6 bg-green-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white border border-green-100 shadow-sm rounded-xl p-6">
                <h3 class="text-xl font-bold text-green-900 mb-4">Welcome, {{ auth()->user()->name }}</h3>
                <p class="text-green-800"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p class="text-green-800"><strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}</p>
            </div>

            <div class="bg-white border border-green-100 shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-bold text-green-900 mb-4">Dashboard Summary</h3>
                <div class="space-y-2 text-green-800">
                    <p><strong>Total Employees:</strong> {{ $totalEmployees }}</p>
                    <p><strong>Total Payslips Uploaded:</strong> {{ $totalPayslips }}</p>
                    <p><strong>Unmatched Payslips:</strong> {{ $unmatchedPayslips }}</p>
                    <p><strong>Last Upload Batch:</strong> {{ $lastBatch?->batch_name ?? 'No uploads yet' }}</p>
                </div>
            </div>

            <div class="bg-white border border-green-100 shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-bold text-green-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <div>
                        <a href="{{ route('admin.payslips.upload') }}"
                            class="text-green-700 hover:text-green-900 font-medium">
                            Upload Payslip ZIP
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('admin.payslips.index') }}"
                            class="text-green-700 hover:text-green-900 font-medium">
                            Manage Payslips
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('admin.employees.index') }}"
                            class="text-green-700 hover:text-green-900 font-medium">
                            Manage Employees
                        </a>
                    </div>
                    @if($lastBatch)
                        <div>
                            <a href="{{ route('admin.payslips.unmatched', $lastBatch->id) }}"
                                class="text-green-700 hover:text-green-900 font-medium">
                                Review Latest Unmatched Payslips
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>