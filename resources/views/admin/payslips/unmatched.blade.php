<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Unmatched Payslips
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">{{ $batch->batch_name }}</h3>

                <div class="space-y-6">
                    @foreach($payslips as $payslip)
                        <div class="border rounded p-4">
                            <div class="mb-3 text-sm text-gray-700">
                                <p><strong>Source PDF:</strong> {{ $payslip->source_pdf }}</p>
                                <p><strong>Page:</strong> {{ $payslip->page_number }}</p>
                                <p><strong>Segment:</strong> {{ $payslip->segment_position }}</p>
                                <p><strong>Detected Name:</strong> {{ $payslip->detected_name ?? 'Not detected yet' }}</p>
                            </div>

                            @if($payslip->file_path)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $payslip->file_path) }}" alt="Payslip Preview"
                                        class="max-w-full border rounded">
                                </div>
                            @endif

                            <form method="POST" action="{{ route('admin.payslips.assign', $payslip->id) }}">
                                @csrf
                                <div class="flex gap-2">
                                    <select name="user_id" class="border rounded p-2 w-full" required>
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">
                                                {{ $employee->name }} ({{ $employee->employee_portal_id }})
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded">
                                        Assign
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>