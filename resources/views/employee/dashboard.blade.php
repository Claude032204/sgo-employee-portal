<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-green-900 leading-tight">
            Employee Dashboard
        </h2>
    </x-slot>

    <div class="py-6 bg-green-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white border border-green-100 shadow-sm rounded-xl p-6">
                <h3 class="text-2xl font-bold text-green-900 mb-2">
                    Welcome, {{ $user->name }}
                </h3>
                <p class="text-green-700">
                    Access your payslips and account details here.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white border border-green-100 shadow-sm rounded-xl p-6">
                    <h3 class="text-lg font-bold text-green-900 mb-4">Dashboard Summary</h3>
                    <div class="space-y-2 text-green-800">
                        <p><strong>Total Payslips Available:</strong> {{ $totalPayslips }}</p>
                        <p><strong>Latest Payslip:</strong> {{ $latestPayslip?->pay_period ?? 'No payslip yet' }}</p>
                        <p><strong>Account Status:</strong> {{ $accountStatus['portal_access'] }}</p>
                        <p><strong>Email Verified:</strong> {{ $accountStatus['email_verified'] ? 'Yes' : 'No' }}</p>
                    </div>
                </div>

                <div class="bg-white border border-green-100 shadow-sm rounded-xl p-6">
                    <h3 class="text-lg font-bold text-green-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('employee.payslips') }}"
                            class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                            View My Payslips
                        </a>

                        @if($latestPayslip)
                            <div>
                                <a href="{{ route('employee.payslips.show', $latestPayslip->id) }}"
                                    class="text-green-700 hover:text-green-900 font-medium">
                                    View Latest Payslip
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white border border-green-100 shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-bold text-green-900 mb-4">Latest Payslip</h3>

                @if($latestPayslip)
                    <div class="space-y-2 text-green-800">
                        <p><strong>Pay Period:</strong> {{ $latestPayslip->pay_period }}</p>
                        <p><strong>Status:</strong> Available</p>
                        <a href="{{ route('employee.payslips.show', $latestPayslip->id) }}"
                            class="inline-block mt-2 text-green-700 hover:text-green-900 font-medium">
                            View Payslip
                        </a>
                    </div>
                @else
                    <p class="text-green-700">No payslip available yet.</p>
                @endif
            </div>

            <div class="bg-white border border-green-100 shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-bold text-green-900 mb-4">Recent Payslips</h3>

                @if($recentPayslips->count() > 0)
                    <ul class="space-y-2">
                        @foreach($recentPayslips as $payslip)
                            <li class="border-b border-green-100 pb-2 last:border-b-0">
                                <a href="{{ route('employee.payslips.show', $payslip->id) }}"
                                    class="text-green-700 hover:text-green-900 font-medium">
                                    {{ $payslip->pay_period }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-green-700">No recent payslips yet.</p>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white border border-green-100 shadow-sm rounded-xl p-6">
                    <h3 class="text-lg font-bold text-green-900 mb-4">Account Information</h3>
                    <div class="space-y-2 text-green-800">
                        <p><strong>Employee Portal ID:</strong> {{ $user->employee_portal_id }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Birthdate:</strong> {{ $user->birthdate?->format('F d, Y') }}</p>
                        <p><strong>Position:</strong> {{ $user->position }}</p>
                        <p><strong>Department:</strong> {{ $user->department }}</p>
                    </div>
                </div>

                <div class="bg-white border border-green-100 shadow-sm rounded-xl p-6">
                    <h3 class="text-lg font-bold text-green-900 mb-4">Account Status</h3>
                    <div class="space-y-2 text-green-800">
                        <p><strong>Email Verified:</strong> {{ $accountStatus['email_verified'] ? 'Yes' : 'No' }}</p>
                        <p><strong>Portal Access:</strong> {{ $accountStatus['portal_access'] }}</p>
                        <p><strong>Payslip Access:</strong> {{ $accountStatus['payslip_access'] }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>