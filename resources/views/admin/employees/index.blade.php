<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Employee Management
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('admin.employees.index') }}" class="mb-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search employee..."
                        class="border rounded p-2 w-full">
                </form>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2">Name</th>
                            <th class="p-2">Employee ID</th>
                            <th class="p-2">Email</th>
                            <th class="p-2">Department</th>
                            <th class="p-2">Position</th>
                            <th class="p-2">Verified</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr class="border-t">
                                <td class="p-2">{{ $employee->name }}</td>
                                <td class="p-2">{{ $employee->employee_portal_id }}</td>
                                <td class="p-2">{{ $employee->email }}</td>
                                <td class="p-2">{{ $employee->department }}</td>
                                <td class="p-2">{{ $employee->position }}</td>
                                <td class="p-2">{{ $employee->email_verified_at ? 'Yes' : 'No' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-2">No employees found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $employees->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>