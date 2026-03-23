<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-green-900 leading-tight">
            My Payslips
        </h2>
    </x-slot>

    <div class="py-6 bg-green-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border border-green-100 shadow-sm rounded-xl p-6">
                @if($payslips->count() == 0)
                    <p class="text-green-700">No payslips available yet.</p>
                @else
                    <ul class="space-y-3">
                        @foreach($payslips as $payslip)
                            <li class="border border-green-100 rounded-lg p-4 hover:bg-green-50 transition">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('employee.payslips.show', $payslip->id) }}"
                                        class="text-green-700 hover:text-green-900 font-semibold">
                                        {{ $payslip->pay_period }}
                                    </a>

                                    <a href="{{ route('employee.payslips.download', $payslip->id) }}"
                                        class="text-emerald-700 hover:text-emerald-900 font-medium">
                                        Download
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>