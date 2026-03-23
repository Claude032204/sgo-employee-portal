<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payslip Batches
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('admin.payslips.upload') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Upload ZIP
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2">Batch</th>
                            <th class="p-2">Files</th>
                            <th class="p-2">Payslips</th>
                            <th class="p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($batches as $batch)
                            <tr class="border-t">
                                <td class="p-2">{{ $batch->batch_name }}</td>
                                <td class="p-2">{{ $batch->total_files }}</td>
                                <td class="p-2">{{ $batch->total_payslips }}</td>
                                <td class="p-2">
                                    <a href="{{ route('admin.payslips.unmatched', $batch->id) }}" class="text-blue-600">
                                        Manage Unmatched
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>