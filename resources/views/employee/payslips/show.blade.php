<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-green-900 leading-tight">
            Payslip Details
        </h2>
    </x-slot>

    <div class="py-6 bg-green-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-green-100 shadow-sm rounded-xl p-6">

                <div class="mb-4 text-green-800 space-y-2">
                    <p><strong>Pay Period:</strong> {{ $payslip->pay_period }}</p>
                    <p><strong>Employee Name:</strong> {{ $payslip->employee_name }}</p>
                </div>

                @if($payslip->file_path)
                    <div class="mt-4 border border-green-100 rounded-lg p-3 bg-green-50">
                        <img src="{{ asset('storage/' . $payslip->file_path) }}" alt="Payslip"
                            class="max-w-full border rounded-lg shadow-sm">
                    </div>
                @else
                    <p class="mt-4 text-green-700">Payslip image not available.</p>
                @endif

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('employee.payslips') }}"
                        class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                        Back to Payslips
                    </a>

                    <a href="{{ route('employee.payslips.download', $payslip->id) }}"
                        class="inline-block bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2 rounded-lg transition">
                        Download Payslip
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>