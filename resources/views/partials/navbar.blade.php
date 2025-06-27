@php
$user = Auth::user();
$establishment = $establishment ?? ($user ? \App\Models\Establishment::find($user->establishment_id) : null);
$establishmentName = $establishmentName ?? ($establishment ? $establishment->name : 'اسم المؤسسة غير متوفر');
$establishmentLogo = $establishmentLogo ?? ($establishment && $establishment->logo ? asset('storage/' . $establishment->logo) : null);
$academicYears = collect($academicYears ?? ($establishment ? \App\Models\AcademicYear::where('establishment_id', $establishment->id)->orderByDesc('end_date')->get() : []));
// Always fetch the latest active academic year and current exam session from DB
$activeAcademicYear = \App\Models\AcademicYear::where('establishment_id', $establishment->id ?? null)->where('status', true)->first();
// Order exam sessions by id ascending (first, second, third)
$examSessions = $activeAcademicYear
? \App\Models\ExamSession::where('academic_year_id', $activeAcademicYear->id)
->orderByRaw("FIELD(semester, 'first', 'second', 'third')")
->get()
: collect();
$currentExamSession = $activeAcademicYear ? \App\Models\ExamSession::where('academic_year_id', $activeAcademicYear->id)->where('is_current', true)->first() : null;
@endphp

<nav class="bg-blue-800 shadow-lg text-white">
    <div class="flex justify-between items-center mx-auto px-4 py-3 container">
        <!-- Left: Logo and Name -->
        <div class="flex items-center space-x-4 space-x-reverse">
            @if($establishmentLogo)
            <img src="{{ $establishmentLogo }}" alt="شعار المؤسسة" class="ml-2 border rounded-full w-10 h-10">
            @endif
            <span class="hidden sm:inline font-semibold text-xl">مؤسسة {{ $establishmentName }}</span>
        </div>

        <!-- Hamburger for mobile -->
        <div class="sm:hidden flex items-center">
            <button id="navbar-mobile-toggle" class="focus:outline-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden sm:flex items-center space-x-6 space-x-reverse">
            <!-- Academic Year Selector (Desktop) -->
            <div class="group relative">
                <button class="flex items-center gap-x-2 bg-indigo-600 hover:bg-indigo-700 shadow-sm px-4 py-2.5 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 transition-all duration-200">
                    <i class="text-white text-sm fas fa-calendar-alt"></i>
                    <span class="font-medium text-white text-sm">
                        {{ $activeAcademicYear ? $activeAcademicYear->name : 'لا توجد سنة دراسية' }}
                    </span>
                    <i class="text-white text-xs group-hover:rotate-180 transition-transform duration-200 fas fa-chevron-down"></i>
                </button>
                <div class="hidden group-focus-within:block group-hover:block right-0 z-20 absolute bg-white shadow-lg mt-1.5 border border-gray-200 rounded-lg w-60 overflow-hidden">
                    <div class="divide-y divide-gray-100">
                        <div class="bg-indigo-50 px-4 py-3">
                            <h3 class="font-semibold text-indigo-800 text-sm">السنوات الدراسية</h3>
                        </div>
                        <div class="max-h-[280px] overflow-y-auto">
                            @php
                            $filteredYears = $academicYears->filter(function($year) use ($establishment) {
                            return $year->establishment_id == ($establishment ? $establishment->id : null);
                            });
                            @endphp
                            @foreach($filteredYears as $year)
                            <form action="{{ route('academic-years.activate', $year->id) }}" method="POST" class="group flex justify-between items-center hover:bg-gray-50 px-4 py-3 transition-colors duration-150">
                                @csrf
                                <span class="font-medium text-gray-800 text-sm">{{ $year->name }}</span>
                                @if($year->status)
                                <span class="inline-flex items-center gap-x-1 bg-green-50 px-2.5 py-1 rounded-full font-medium text-green-700 text-xs">
                                    <i class="text-[10px] text-green-500 fas fa-check-circle"></i>
                                    نشطة
                                </span>
                                @else
                                <button type="submit" class="inline-flex items-center gap-x-1 bg-gray-100 hover:bg-indigo-100 px-2.5 py-1 rounded-full font-medium text-gray-600 hover:text-indigo-700 text-xs">
                                    <i class="text-[10px] text-gray-400 fas fa-times-circle"></i>
                                    تفعيل
                                </button>
                                @endif
                            </form>
                            @endforeach
                        </div>
                        <div>
                            <!-- Trigger button for modal -->
                            <button type="button"
                                id="openAcademicYearModal"
                                class="flex items-center gap-x-2 hover:bg-indigo-50 px-4 py-3 w-full font-medium text-indigo-600 text-sm text-left transition-colors duration-150">
                                <i class="text-indigo-500 fas fa-plus-circle"></i>
                                سنة جديدة
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Exam Session Selector (Desktop) -->
            <div class="group relative">
                <button class="flex items-center gap-x-2 bg-indigo-500 hover:bg-indigo-600 shadow-sm px-4 py-2.5 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 transition-all duration-200">
                    <i class="text-white text-sm fas fa-clock"></i>
                    <span class="font-medium text-white text-sm">
                        {{ $currentExamSession ? $currentExamSession->name : 'لا توجد جلسة امتحان' }}
                    </span>
                    <i class="text-white text-xs group-hover:rotate-180 transition-transform duration-200 fas fa-chevron-down"></i>
                </button>
                <div class="hidden group-focus-within:block group-hover:block right-0 z-20 absolute bg-white shadow-lg mt-1.5 border border-gray-200 rounded-lg w-60 overflow-hidden">
                    <div class="divide-y divide-gray-100">
                        <div class="bg-indigo-50 px-4 py-3">
                            <h3 class="font-semibold text-indigo-800 text-sm">جلسات الامتحان</h3>
                        </div>
                        <div class="max-h-[280px] overflow-y-auto">
                            @foreach($examSessions as $session)
                            <form action="{{ route('exam_sessions.activate', $session->id) }}" method="POST" class="group flex justify-between items-center hover:bg-gray-50 px-4 py-3 transition-colors duration-150">
                                @csrf
                                <span class="font-medium text-gray-800 text-sm">{{ $session->name }}</span>
                                @if($session->is_current)
                                <span class="inline-flex items-center gap-x-1 bg-green-50 px-2.5 py-1 rounded-full font-medium text-green-700 text-xs">
                                    <i class="text-[10px] text-green-500 fas fa-check-circle"></i>
                                    نشطة
                                </span>
                                @else
                                <button type="submit" class="inline-flex items-center gap-x-1 bg-gray-100 hover:bg-indigo-100 px-2.5 py-1 rounded-full font-medium text-gray-600 hover:text-indigo-700 text-xs">
                                    <i class="text-[10px] text-gray-400 fas fa-times-circle"></i>
                                    تفعيل
                                </button>
                                @endif
                            </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Notifications -->
            <a href="#" class="relative hover:text-blue-200">
                <i class="fas fa-bell"></i>
                <span class="-top-2 -right-2 absolute flex justify-center items-center bg-red-500 rounded-full w-5 h-5 text-white text-xs">5</span>
            </a>
            <!-- User Profile -->
            <div class="flex items-center space-x-2 space-x-reverse">
                @php
                $user = Auth::user();
                $userName = $user && isset($user->name) ? $user->name : 'مستخدم';
                @endphp
                <img src="https://ui-avatars.com/api/?name={{ urlencode($userName) }}&background=random"
                    class="rounded-full w-8 h-8"
                    alt="صورة المستخدم">
                <span>{{ $userName }}</span>
                <i class="text-xs fas fa-chevron-down"></i>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="navbar-mobile-menu" class="hidden sm:hidden bg-blue-700 px-4 py-2">
        <div class="flex flex-col space-y-4">
            <!-- Academic Year Selector (Mobile) -->
            <div class="group relative">
                <button class="flex items-center gap-x-2 bg-indigo-600 hover:bg-indigo-700 shadow-sm px-4 py-2.5 rounded-lg w-full">
                    <i class="text-white text-sm fas fa-calendar-alt"></i>
                    <span class="font-medium text-white text-sm">
                        {{ $activeAcademicYear ? $activeAcademicYear->name : 'لا توجد سنة دراسية' }}
                    </span>
                    <i class="text-white text-xs group-hover:rotate-180 transition-transform duration-200 fas fa-chevron-down"></i>
                </button>
                <div class="hidden group-focus-within:block group-hover:block right-0 left-0 z-20 absolute bg-white shadow-lg mt-1.5 border border-gray-200 rounded-lg w-full overflow-hidden">
                    <div class="divide-y divide-gray-100">
                        <div class="bg-indigo-50 px-4 py-3">
                            <h3 class="font-semibold text-indigo-800 text-sm">السنوات الدراسية</h3>
                        </div>
                        <div class="max-h-[280px] overflow-y-auto">
                            @foreach($filteredYears as $year)
                            <form action="{{ route('academic-years.activate', $year->id) }}" method="POST" class="group flex justify-between items-center hover:bg-gray-50 px-4 py-3 transition-colors duration-150">
                                @csrf
                                <span class="font-medium text-gray-800 text-sm">{{ $year->name }}</span>
                                @if($year->status)
                                <span class="inline-flex items-center gap-x-1 bg-green-50 px-2.5 py-1 rounded-full font-medium text-green-700 text-xs">
                                    <i class="text-[10px] text-green-500 fas fa-check-circle"></i>
                                    نشطة
                                </span>
                                @else
                                <button type="submit" class="inline-flex items-center gap-x-1 bg-gray-100 hover:bg-indigo-100 px-2.5 py-1 rounded-full font-medium text-gray-600 hover:text-indigo-700 text-xs">
                                    <i class="text-[10px] text-gray-400 fas fa-times-circle"></i>
                                    تفعيل
                                </button>
                                @endif
                            </form>
                            @endforeach
                        </div>
                        <div>
                            <!-- Trigger button for modal -->
                            <button type="button"
                                id="openAcademicYearModal"
                                class="flex items-center gap-x-2 hover:bg-indigo-50 px-4 py-3 w-full font-medium text-indigo-600 text-sm text-left transition-colors duration-150">
                                <i class="text-indigo-500 fas fa-plus-circle"></i>
                                سنة جديدة
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Notifications (mobile) -->
            <a href="#" class="flex items-center gap-x-2 hover:bg-blue-600 px-4 py-3 rounded-lg">
                <i class="fas fa-bell"></i>
                <span>الإشعارات</span>
                <span class="flex justify-center items-center bg-red-500 ml-auto rounded-full w-5 h-5 text-white text-xs">5</span>
            </a>
            <!-- User Profile (mobile) -->
            <div class="flex items-center gap-x-2 hover:bg-blue-600 px-4 py-3 rounded-lg">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($userName ?? 'مستخدم') }}&background=random"
                    class="rounded-full w-8 h-8"
                    alt="صورة المستخدم">
                <span>{{ $userName ?? 'مستخدم' }}</span>
                <i class="ml-auto text-xs fas fa-chevron-down"></i>
            </div>
        </div>
    </div>
</nav>

{{-- Modal for creating new academic year --}}
<div id="academicYearModal" class="hidden z-50 fixed inset-0 flex justify-center items-center bg-black bg-opacity-40">
    <div class="bg-white shadow-lg p-6 rounded-lg w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-indigo-700 text-lg">إضافة سنة دراسية جديدة</h3>
            <button type="button" id="closeAcademicYearModal" class="text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <form method="POST" action="{{ route('academic-years.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">اسم السنة الدراسية</label>
                <input type="text" name="name" required class="px-3 py-2 border focus:border-indigo-400 rounded focus:outline-none focus:ring w-full" placeholder="مثال: 2024/2025">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">تاريخ البداية</label>
                <input type="date" name="start_date" required class="px-3 py-2 border focus:border-indigo-400 rounded focus:outline-none focus:ring w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">تاريخ النهاية</label>
                <input type="date" name="end_date" required class="px-3 py-2 border focus:border-indigo-400 rounded focus:outline-none focus:ring w-full">
            </div>
            <input type="hidden" name="establishment_id" value="{{ $establishment->id ?? '' }}">
            <div class="flex justify-end gap-2">
                <button type="button" id="cancelAcademicYearModal" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded text-gray-700">إلغاء</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded text-white">إضافة</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Responsive mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('navbar-mobile-toggle');
        const mobileMenu = document.getElementById('navbar-mobile-menu');
        if (toggleBtn && mobileMenu) {
            toggleBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
            // Optional: close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!toggleBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }
    });

    // Modal for academic year
    document.addEventListener('DOMContentLoaded', function() {
        const cancelBtn = document.getElementById('cancelAcademicYearModal');
        const openBtn = document.getElementById('openAcademicYearModal');
        const modal = document.getElementById('academicYearModal');
        const closeBtn = document.getElementById('closeAcademicYearModal');

        function openModal() {
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
        if (openBtn) openBtn.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        // Optional: close modal when clicking outside the modal content
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) closeModal();
            });
        }
    });
</script>