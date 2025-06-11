@php
$user = Auth::user();
$establishment = $establishment ?? ($user ? \App\Models\Establishment::find($user->establishment_id) : null);
$establishmentName = $establishmentName ?? ($establishment ? $establishment->name : 'اسم المؤسسة غير متوفر');
$establishmentLogo = $establishmentLogo ?? ($establishment && $establishment->logo ? asset('storage/' . $establishment->logo) : null);
$academicYears = $academicYears ?? ($establishment ? \App\Models\AcademicYear::where('establishment_id', $establishment->id)->orderByDesc('end_date')->get() : collect());
$activeAcademicYear = $activeAcademicYear ?? ($establishment ? \App\Models\AcademicYear::where('establishment_id', $establishment->id)->where('status', 'active')->first() : null);
@endphp

<nav class="bg-blue-800 shadow-lg text-white">
    <div class="flex justify-between items-center mx-auto px-4 py-3 container">
        <div class="flex items-center space-x-4 space-x-reverse">
            @if($establishmentLogo)
            <img src="{{ $establishmentLogo }}" alt="شعار المؤسسة" class="ml-2 border rounded-full w-10 h-10">
            @endif
            <span class="font-semibold text-xl">مؤسسة {{ $establishmentName }}</span>
        </div>

        <div class="flex items-center space-x-6 space-x-reverse">
            <!-- Academic Year Selector -->
            <div class="group relative">
                <button class="flex items-center gap-x-2 bg-indigo-600 hover:bg-indigo-700 shadow-sm px-4 py-2.5 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 transition-all duration-200">
                    <i class="text-white text-sm fas fa-calendar-alt"></i>
                    <span class="font-medium text-white text-sm">
                        {{ $activeAcademicYear ? $activeAcademicYear->name : 'لا توجد سنة دراسية' }}
                    </span>
                    <i class="text-white text-xs group-hover:rotate-180 transition-transform duration-200 fas fa-chevron-down"></i>
                </button>

                <div class="hidden group-hover:block right-0 z-20 absolute bg-white shadow-lg mt-1.5 border border-gray-200 rounded-lg w-60 overflow-hidden">
                    <div class="divide-y divide-gray-100">
                        <div class="bg-indigo-50 px-4 py-3">
                            <h3 class="font-semibold text-indigo-800 text-sm">السنوات الدراسية</h3>
                        </div>

                        <div class="max-h-[280px] overflow-y-auto">
                            @forelse($academicYears as $year)
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
                            @empty
                            <div class="flex items-center gap-x-2 px-4 py-3 text-gray-500 text-sm">
                                <i class="text-gray-400 fas fa-info-circle"></i>
                                لا توجد سنوات دراسية
                            </div>
                            @endforelse
                        </div>

                        <div>
                            <a href="#" class="flex items-center gap-x-2 hover:bg-indigo-50 px-4 py-3 font-medium text-indigo-600 text-sm transition-colors duration-150">
                                <i class="text-indigo-500 fas fa-plus-circle"></i>
                                سنة جديدة
                            </a>
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
</nav>