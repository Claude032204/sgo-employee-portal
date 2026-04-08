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

                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 transition">
                            <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">🏠</div>
                            <span class="text-sm text-gray-800">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.payslips.upload') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 transition">
                            <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">📤</div>
                            <span class="text-sm text-gray-800">Upload Payslips</span>
                        </a>

                        <a href="{{ route('admin.payslips.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 transition">
                            <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">📄</div>
                            <span class="text-sm text-gray-800">Manage Payslips</span>
                        </a>

                        <a href="{{ route('admin.employees.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-white hover:bg-green-50 transition">
                            <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">👥</div>
                            <span class="text-sm text-gray-800">Employees</span>
                        </a>

                        <!-- ACTIVE -->
                        <a href="#"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 bg-yellow-100 border border-yellow-200 shadow-inner">
                            <div class="w-9 h-9 bg-yellow-200 rounded-lg flex items-center justify-center">⚠️</div>
                            <span class="text-sm font-semibold text-yellow-800">Unmatched Payslips</span>
                        </a>

                    </div>
                </div>

                <!-- MAIN CONTENT -->
                <div class="flex-1 space-y-6">

                    <!-- HEADER -->
                    <div
                        class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.06)] border border-white/40 p-6">

                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            Unmatched Payslips
                        </h2>

                        <p class="text-sm text-gray-500">
                            {{ $batch->batch_name }}
                        </p>

                        @if(session('success'))
                            <div class="mt-4 p-3 bg-green-100 text-green-800 rounded-xl text-sm">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>

                    <!-- LIST -->
                    <div class="space-y-6">

                        @forelse($payslips as $payslip)

                            <div
                                class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_10px_30px_rgba(0,0,0,0.05)] border border-white/40 p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

                                <!-- LEFT: BIG IMAGE AREA -->
                                <div class="lg:col-span-2">

                                    <div class="mb-3 text-sm text-gray-600 flex flex-wrap gap-4">
                                        <span>📄 {{ $payslip->source_pdf }}</span>
                                        <span>📑 Page {{ $payslip->page_number }}</span>
                                        <span>🔖 {{ $payslip->segment_position }}</span>
                                    </div>

                                    <div class="mb-3">
                                        <span class="text-xs text-gray-500">Detected Name</span>
                                        <p class="font-semibold text-gray-800 text-lg">
                                            {{ $payslip->detected_name ?? 'Not detected' }}
                                        </p>
                                    </div>

                                    @if($payslip->file_path)
                                        <div class="mt-4">
                                            <img src="{{ asset('storage/' . $payslip->file_path) }}" alt="Payslip Preview"
                                                class="w-full max-h-[500px] object-contain rounded-2xl border shadow-md bg-gray-50 cursor-zoom-in hover:scale-[1.02] transition duration-200"
                                                onclick="openModal('{{ asset('storage/' . $payslip->file_path) }}')">
                                        </div>
                                    @endif

                                </div>

                                <!-- RIGHT: ASSIGN PANEL -->
                                <div class="flex flex-col justify-center">

                                    <form method="POST" action="{{ route('admin.payslips.assign', $payslip->id) }}"
                                        class="space-y-4">
                                        @csrf

                                        <label class="text-sm text-gray-600 font-medium">
                                            Assign to Employee
                                        </label>

                                        <select name="user_id"
                                            class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none"
                                            required>
                                            <option value="">Select Employee</option>
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->id }}">
                                                    {{ $employee->name }} ({{ $employee->employee_portal_id }})
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="submit"
                                            class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-medium shadow hover:shadow-lg hover:scale-[1.02] transition">
                                            Assign Payslip
                                        </button>
                                    </form>

                                </div>

                            </div>

                        @empty
                            <div
                                class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_10px_30px_rgba(0,0,0,0.05)] border border-white/40 p-10 text-center text-gray-400">
                                No unmatched payslips 🎉
                            </div>
                        @endforelse

                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- IMAGE MODAL -->
    <div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50 px-4"
        onclick="handleBackdropClick(event)">

        <!-- CLOSE BUTTON -->
        <button type="button" onclick="closeModal()"
            class="absolute top-5 right-6 text-white text-4xl leading-none hover:scale-110 transition z-50">
            &times;
        </button>

        <!-- IMAGE CONTAINER -->
        <div class="relative max-w-6xl w-full flex items-center justify-center">
            <img id="modalImage" src="" alt="Zoomed Payslip"
                class="max-w-full max-h-[90vh] object-contain rounded-2xl shadow-2xl border border-white/20 bg-white">
        </div>
    </div>

    <script>
        function openModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');

            modalImage.src = src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modalImage.src = '';
            document.body.classList.remove('overflow-hidden');
        }

        function handleBackdropClick(event) {
            if (event.target.id === 'imageModal') {
                closeModal();
            }
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>

</x-app-layout>