<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Upload Payslip ZIP
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('admin.payslips.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Pay Period</label>
                        <input type="text" name="pay_period" class="mt-1 block w-full border rounded p-2"
                            placeholder="March 2026" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">ZIP File</label>
                        <input type="file" name="zip_file" class="mt-1 block w-full border rounded p-2" accept=".zip"
                            required>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Upload ZIP
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>