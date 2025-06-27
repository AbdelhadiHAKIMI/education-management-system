@extends('layouts.app')

@section('title', 'إضافة برنامج جديد')

@section('content')
@php
// Ensure variables are defined
if (!isset($students)) $students = collect();
if (!isset($branches)) $branches = \App\Models\Branch::all();
if (!isset($staff)) $staff = collect();
if (!isset($academicYears)) $academicYears = \App\Models\AcademicYear::where('establishment_id', auth()->user()->establishment_id ?? null)->where('is_active', true)->get();
if (!isset($step1)) $step1 = [];
if (!isset($step2)) $step2 = [];
if (!isset($step3)) $step3 = [];
@endphp

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="mx-auto px-2 sm:px-4 py-6 sm:py-8 max-w-6xl">
    <!-- Header -->
    <div class="flex md:flex-row flex-col justify-between items-start md:items-center gap-4 mb-6 md:mb-8">
        <div>
            <h1 class="font-bold text-gray-800 text-2xl">إضافة برنامج جديد</h1>
            <p class="mt-1 text-gray-600">أكمل المعالج لإنشاء برنامج تعليمي جديد</p>
        </div>
        <a href="{{ route('admin.programs.index') }}" class="flex items-center mt-2 md:mt-0 text-primary hover:text-primary-dark">
            <i class="fa-arrow-left ml-2 fas"></i>
            العودة إلى قائمة البرامج
        </a>
    </div>

    <!-- Wizard Container -->
    <div class="bg-white shadow-md border border-gray-100 rounded-xl overflow-hidden">
        <!-- Wizard Header -->
        <div class="bg-gray-50 p-4 sm:p-6 border-gray-100 border-b">
            <h2 class="font-semibold text-gray-800 text-xl">معالج إنشاء البرنامج</h2>
        </div>

        <!-- Steps Indicator -->
        <div class="px-2 sm:px-6 pt-6 pb-2">
            <div class="relative">
                <div class="flex justify-between">
                    @foreach([1, 2, 3, 4] as $step)
                    <div class="z-10 relative flex flex-col flex-1 items-center">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex justify-center items-center w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 {{ $step == 1 ? 'border-primary bg-primary text-white' : 'border-gray-300 bg-white text-gray-400' }} transition-colors duration-300">
                                {{ $step }}
                            </div>
                            @if($step < 4)
                                <div class="w-8 sm:w-24 h-1 mx-1 sm:mx-2 {{ $step == 1 ? 'bg-primary' : 'bg-gray-200' }} transition-colors duration-300">
                        </div>
                        @endif
                    </div>
                    <span class="mt-2 text-xs font-medium {{ $step == 1 ? 'text-primary' : 'text-gray-500' }}">
                        @if($step == 1) معلومات البرنامج
                        @elseif($step == 2) الطلاب
                        @elseif($step == 3) الفريق
                        @else إنهاء
                        @endif
                    </span>
                </div>
                @endforeach
            </div>
            <div class="top-5 right-0 left-0 z-0 absolute bg-gray-100 h-1"></div>
        </div>
    </div>

    <!-- Step 1: Program Information -->
    <div id="step1" class="p-4 sm:p-6 step-content">
        <h3 class="flex items-center mb-6 font-semibold text-gray-800 text-lg">
            <span class="flex justify-center items-center bg-primary/10 mr-3 rounded-full w-8 h-8 text-primary">1</span>
            معلومات البرنامج الأساسية
        </h3>

        <form method="POST" action="{{ route('admin.programs.store') }}" id="program-create-form">
            @csrf
            <div class="gap-4 sm:gap-6 grid grid-cols-1 md:grid-cols-2">
                <!-- Name -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">اسم البرنامج *</label>
                    <input name="name" type="text" value="{{ old('name', $wizard['name'] ?? '') }}"
                        class="px-4 py-2.5 border border-gray-300 focus:border-primary rounded-lg focus:ring-2 focus:ring-primary/50 w-full transition-all duration-300"
                        placeholder="مثال: التربص الصيفي" required>
                </div>

                <!-- Type -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">نوع البرنامج *</label>
                    <select name="type" class="px-4 py-2.5 border border-gray-300 focus:border-primary rounded-lg focus:ring-2 focus:ring-primary/50 w-full transition-all duration-300" required>
                        <option value="">اختر النوع</option>
                        <option value="سنة دراسية كاملة" {{ old('type', $wizard['type'] ?? '') == 'سنة دراسية كاملة' ? 'selected' : '' }}>سنة دراسية كاملة</option>
                        <option value="فصل دراسي" {{ old('type', $wizard['type'] ?? '') == 'فصل دراسي' ? 'selected' : '' }}>فصل دراسي</option>
                        <option value="دورة تكوينية" {{ old('type', $wizard['type'] ?? '') == 'دورة تكوينية' ? 'selected' : '' }}>دورة تكوينية</option>
                    </select>
                </div>

                <!-- Dates -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">تاريخ البدء *</label>
                    <input name="start_date" type="date" value="{{ old('start_date', $wizard['start_date'] ?? '') }}"
                        class="w-full px-4 py-2.5 border {{ $errors->has('start_date') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300"
                        required>
                    @error('start_date')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">تاريخ الانتهاء *</label>
                    <input name="end_date" type="date" value="{{ old('end_date', $wizard['end_date'] ?? '') }}"
                        class="w-full px-4 py-2.5 border {{ $errors->has('end_date') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300"
                        required>
                    @error('end_date')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Academic Year -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">السنة الدراسية *</label>
                    @php
                    $userEstablishmentId = auth()->user()->establishment_id ?? null;
                    $academicYearsForEst = $academicYears->where('establishment_id', $userEstablishmentId);
                    $activeAcademicYear = $academicYearsForEst->where('status', true)->first();
                    @endphp
                    <select name="academic_year_id"
                        class="bg-gray-100 px-4 py-2.5 border border-gray-300 focus:border-primary rounded-lg focus:ring-2 focus:ring-primary/50 w-full transition-all duration-300 cursor-not-allowed"
                        required
                        readonly
                        disabled>
                        @if($activeAcademicYear)
                        <option value="{{ $activeAcademicYear->id }}" selected>{{ $activeAcademicYear->name }}</option>
                        @else
                        <option value="">لا توجد سنة دراسية نشطة</option>
                        @endif
                    </select>
                    @if($activeAcademicYear)
                    <input type="hidden" name="academic_year_id" value="{{ $activeAcademicYear->id }}">
                    @endif
                </div>

                <!-- Level -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">المستوى *</label>
                    <select name="level_id" class="px-4 py-2.5 border border-gray-300 focus:border-primary rounded-lg focus:ring-2 focus:ring-primary/50 w-full transition-all duration-300" required>
                        <option value="">اختر المستوى</option>
                        @foreach($levels as $level)
                        <option value="{{ $level->id }}" {{ old('level_id', $wizard['level_id'] ?? '') == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Fees -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">رسوم التسجيل *</label>
                    <div class="relative">
                        <input name="registration_fees" type="number" min="0" value="{{ old('registration_fees', $wizard['registration_fees'] ?? '') }}"
                            class="py-2.5 pr-4 pl-10 border border-gray-300 focus:border-primary rounded-lg focus:ring-2 focus:ring-primary/50 w-full transition-all duration-300"
                            required>
                        <span class="top-1/2 left-3 absolute text-gray-500 -translate-y-1/2 transform">د.ج</span>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">حالة البرنامج</label>
                    <select name="is_active" class="px-4 py-2.5 border border-gray-300 focus:border-primary rounded-lg focus:ring-2 focus:ring-primary/50 w-full transition-all duration-300">
                        <option value="1" {{ (old('is_active', $wizard['is_active'] ?? '1') == '1') ? 'selected' : '' }}>نشط</option>
                        <option value="0" {{ (old('is_active', $wizard['is_active'] ?? '1') == '0') ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div class="mt-4 sm:mt-6">
                <label class="block mb-1 font-medium text-gray-700 text-sm">وصف البرنامج</label>
                <textarea name="description" class="px-4 py-2.5 border border-gray-300 focus:border-primary rounded-lg focus:ring-2 focus:ring-primary/50 w-full transition-all duration-300"
                    rows="3" placeholder="أدخل وصفاً مختصراً للبرنامج">{{ old('description', $wizard['description'] ?? '') }}</textarea>
            </div>

            <input type="hidden" name="created_by_id" value="{{ auth()->id() }}">
            <input type="hidden" name="establishment_id" value="{{ session('establishment')->id ?? (auth()->user()->establishment_id ?? '') }}">

            <!-- Navigation -->
            <div class="flex sm:flex-row flex-col justify-end gap-2 sm:space-x-3 mt-6 sm:mt-8">
                <button type="button"
                    onclick="nextStep(2)"
                    class="flex justify-center items-center bg-green-600 hover:bg-green-700 shadow px-6 py-2.5 rounded-lg w-full sm:w-auto font-semibold text-white transition-colors duration-300">
                    التالي
                    <i class="fa-arrow-left mr-2 fas"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Step 2: Students -->
    <div id="step2" class="hidden p-4 sm:p-6 step-content">
        <h3 class="flex items-center mb-6 font-semibold text-gray-800 text-lg">
            <span class="flex justify-center items-center bg-primary/10 mr-3 rounded-full w-8 h-8 text-primary">2</span>
            اختيار الطلاب المشاركين
        </h3>

        <div class="bg-gray-50 mb-4 sm:mb-6 p-3 sm:p-4 rounded-lg">
            <div class="flex md:flex-row flex-col md:justify-between md:items-center gap-4">
                <div class="flex-1">
                    <label class="block mb-1 font-medium text-gray-700 text-sm">تصفية حسب الشعبة</label>
                    <select id="branchFilter" class="px-4 py-2 border border-gray-300 focus:border-primary rounded-lg focus:ring-2 focus:ring-primary/50 w-full transition-all duration-300">
                        <option value="">كل الشعب</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-row gap-2">
                    <button type="button" id="selectAllStudents" class="bg-white hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-lg w-full md:w-auto text-gray-700 text-sm transition-colors duration-300">
                        تحديد الكل
                    </button>
                    <button type="button" id="deselectAllStudents" class="bg-white hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-lg w-full md:w-auto text-gray-700 text-sm transition-colors duration-300">
                        إلغاء الكل
                    </button>
                </div>
            </div>
        </div>

        <div class="gap-2 sm:gap-3 grid grid-cols-1 md:grid-cols-2" id="students-list">
            @foreach($students as $student)
            <label class="flex items-center hover:bg-primary/5 p-3 border border-gray-200 hover:border-primary/30 rounded-lg transition-colors duration-200 cursor-pointer" data-branch="{{ $student->branch_id }}">
                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="border-gray-300 rounded focus:ring-primary/50 w-5 h-5 text-primary transition-colors duration-200 student-checkbox" checked>
                <div class="ml-3">
                    <span class="block font-medium text-gray-800 text-sm">{{ $student->full_name }}</span>
                    <span class="block mt-0.5 text-gray-500 text-xs">{{ $student->branch?->name ?? 'بدون شعبة' }}</span>
                </div>
            </label>
            @endforeach
        </div>

        <!-- Navigation -->
        <div class="flex sm:flex-row flex-col justify-between gap-2 mt-6 sm:mt-8">
            <button type="button"
                onclick="prevStep(1)"
                class="flex justify-center items-center bg-gray-200 hover:bg-gray-300 shadow px-6 py-2.5 rounded-lg w-full sm:w-auto font-semibold text-gray-800 transition-colors duration-300">
                <i class="fa-arrow-right mr-2 fas"></i>
                السابق
            </button>
            <button type="button"
                onclick="nextStep(3)"
                class="flex justify-center items-center bg-green-600 hover:bg-green-700 shadow px-6 py-2.5 rounded-lg w-full sm:w-auto font-semibold text-white transition-colors duration-300">
                التالي
                <i class="fa-arrow-left mr-2 fas"></i>
            </button>
        </div>
    </div>

    <!-- Step 3: Staff -->
    <div id="step3" class="hidden p-4 sm:p-6 step-content">
        <h3 class="flex items-center mb-6 font-semibold text-gray-800 text-lg">
            <span class="flex justify-center items-center bg-primary/10 mr-3 rounded-full w-8 h-8 text-primary">3</span>
            تعيين الفريق العامل
        </h3>

        @php
        $userEstablishmentId = auth()->user()->establishment_id ?? null;
        $academicYearsForEst = $academicYears->where('establishment_id', $userEstablishmentId);
        @endphp
        <form id="staff-filter-form" class="flex flex-wrap items-center gap-4 mb-4" onsubmit="return false;">
            <label class="font-medium text-gray-700 text-sm">السنة الدراسية:</label>
            <select name="staff_academic_year_id" id="staff_academic_year_id" class="px-3 py-2 border rounded">
                @foreach($academicYearsForEst as $year)
                <option value="{{ $year->id }}" {{ (isset($selectedStaffAcademicYearId) && $selectedStaffAcademicYearId == $year->id) ? 'selected' : '' }}>
                    {{ $year->name }}
                </option>
                @endforeach
            </select>
            <label class="font-medium text-gray-700 text-sm">نوع المؤطر:</label>
            <select name="staff_type" id="staff_type" class="px-3 py-2 border rounded">
                <option value="">الكل</option>
                <option value="إداري" @if(request('staff_type')=='إداري' ) selected @endif>إداري</option>
                <option value="مؤطر دراسي" @if(request('staff_type')=='مؤطر دراسي' ) selected @endif>مؤطر دراسي</option>
                <option value="خدمات" @if(request('staff_type')=='خدمات' ) selected @endif>خدمات</option>
            </select>
        </form>

        <div id="staff-step-content">
            @include('admin.programs.partials.step3_staff', ['filteredStaff' => $filteredStaff])
        </div>

        <!-- Navigation -->
        <div class="flex sm:flex-row flex-col justify-between gap-2 mt-6 sm:mt-8">
            <button type="button"
                onclick="prevStep(2)"
                class="flex justify-center items-center bg-gray-200 hover:bg-gray-300 shadow px-6 py-2.5 rounded-lg w-full sm:w-auto font-semibold text-gray-800 transition-colors duration-300">
                <i class="fa-arrow-right mr-2 fas"></i>
                السابق
            </button>
            <button type="button"
                onclick="nextStep(4)"
                class="flex justify-center items-center bg-green-600 hover:bg-green-700 shadow px-6 py-2.5 rounded-lg w-full sm:w-auto font-semibold text-white transition-colors duration-300">
                التالي
                <i class="fa-arrow-left mr-2 fas"></i>
            </button>
        </div>
    </div>

    <!-- Step 4: Confirmation -->
    <div id="step4" class="hidden p-4 sm:p-6 step-content">
        <h3 class="flex items-center mb-6 font-semibold text-gray-800 text-lg">
            <span class="flex justify-center items-center bg-primary/10 mr-3 rounded-full w-8 h-8 text-primary">4</span>
            تأكيد إنشاء البرنامج
        </h3>

        <div class="bg-gray-50 mb-4 sm:mb-6 p-4 sm:p-6 rounded-lg">
            <div class="gap-4 sm:gap-6 grid grid-cols-1 md:grid-cols-2">
                <!-- Program Info -->
                <div>
                    <h4 class="mb-3 pb-2 border-gray-200 border-b font-medium text-gray-800">معلومات البرنامج</h4>
                    <ul class="space-y-2" id="program-data-preview-list">
                        <!-- Filled by JavaScript -->
                    </ul>
                </div>

                <!-- Students -->
                <div>
                    <h4 class="mb-3 pb-2 border-gray-200 border-b font-medium text-gray-800">الطلاب المشاركون</h4>
                    <ul class="space-y-2 max-h-40 sm:max-h-60 overflow-y-auto" id="students-data-preview-list">
                        <!-- Filled by JavaScript -->
                    </ul>
                </div>

                <!-- Staff -->
                <div class="md:col-span-2">
                    <h4 class="mb-3 pb-2 border-gray-200 border-b font-medium text-gray-800">الفريق العامل</h4>
                    <ul class="space-y-2 max-h-40 sm:max-h-60 overflow-y-auto" id="staff-data-preview-list">
                        <!-- Filled by JavaScript -->
                    </ul>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.programs.store') }}" id="finalProgramForm">
            @csrf
            <!-- Hidden fields -->
            <input type="hidden" name="name" id="hidden_name">
            <input type="hidden" name="type" id="hidden_type">
            <input type="hidden" name="start_date" id="hidden_start_date">
            <input type="hidden" name="end_date" id="hidden_end_date">
            <input type="hidden" name="academic_year_id" id="hidden_academic_year_id">
            <input type="hidden" name="level_id" id="hidden_level_id">
            <input type="hidden" name="registration_fees" id="hidden_registration_fees">
            <input type="hidden" name="is_active" id="hidden_is_active">
            <input type="hidden" name="description" id="hidden_description">
            <input type="hidden" name="created_by_id" value="{{ auth()->id() }}">
            <input type="hidden" name="establishment_id" value="{{ session('establishment')->id ?? (auth()->user()->establishment_id ?? '') }}">
            <div id="hidden-students"></div>

            <!-- Navigation -->
            <div class="flex sm:flex-row flex-col justify-between gap-2 mt-6 sm:mt-8">
                <button type="button"
                    onclick="prevStep(3)"
                    class="flex justify-center items-center bg-gray-200 hover:bg-gray-300 shadow px-6 py-2.5 rounded-lg w-full sm:w-auto font-semibold text-gray-800 transition-colors duration-300">
                    <i class="fa-arrow-right mr-2 fas"></i>
                    السابق
                </button>
                <button type="submit"
                    id="final-submit-btn"
                    class="flex justify-center items-center bg-green-700 hover:bg-green-800 shadow px-6 py-2.5 rounded-lg w-full sm:w-auto font-bold text-white transition-colors duration-300">
                    <i class="mr-2 fas fa-save"></i>
                    حفظ البرنامج
                </button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    // Step Navigation
    function nextStep(step) {
        document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
        document.getElementById('step' + step).classList.remove('hidden');
        updateStepIndicator(step);
        if (step === 4) collectStepData();
    }

    function prevStep(step) {
        document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
        document.getElementById('step' + step).classList.remove('hidden');
        updateStepIndicator(step);
    }

    // Update step indicator
    function updateStepIndicator(currentStep) {
        const steps = document.querySelectorAll('.flex-1 .w-8');
        steps.forEach((el, index) => {
            const isCompleted = index < currentStep - 1;
            const isCurrent = index === currentStep - 1;

            // Update circle
            el.classList.toggle('border-primary', isCompleted || isCurrent);
            el.classList.toggle('bg-primary', isCompleted || isCurrent);
            el.classList.toggle('text-white', isCompleted || isCurrent);
            el.classList.toggle('border-gray-300', !isCompleted && !isCurrent);
            el.classList.toggle('bg-white', !isCompleted && !isCurrent);
            el.classList.toggle('text-gray-400', !isCompleted && !isCurrent);

            // Update line between circles
            if (el.nextElementSibling) {
                el.nextElementSibling.classList.toggle('bg-primary', isCompleted);
                el.nextElementSibling.classList.toggle('bg-gray-200', !isCompleted);
            }
        });
    }

    // Collect data for preview
    function collectStepData() {
        // Step 1: Program data
        const programData = {
            'اسم البرنامج': document.querySelector('#step1 [name="name"]').value,
            'نوع البرنامج': document.querySelector('#step1 [name="type"]').value,
            'تاريخ البدء': document.querySelector('#step1 [name="start_date"]').value,
            'تاريخ الانتهاء': document.querySelector('#step1 [name="end_date"]').value,
            'السنة الدراسية': document.querySelector('#step1 [name="academic_year_id"] option:checked').textContent,
            'المستوى': document.querySelector('#step1 [name="level_id"] option:checked').textContent,
            'رسوم التسجيل': document.querySelector('#step1 [name="registration_fees"]').value + ' د.ج',
            'حالة البرنامج': document.querySelector('#step1 [name="is_active"] option:checked').textContent,
            'الوصف': document.querySelector('#step1 [name="description"]').value || 'لا يوجد وصف'
        };

        // Step 2: Students
        let students = [];
        document.querySelectorAll('#step2 input[name="student_ids[]"]:checked').forEach(cb => {
            const label = cb.closest('label');
            const name = label.querySelector('.text-gray-800').innerText;
            const branch = label.querySelector('.text-gray-500')?.innerText || 'بدون شعبة';
            students.push(`${name} - ${branch}`);
        });

        // Step 3: Staff
        let staff = [];
        document.querySelectorAll('#step3 input[name="supervisor_ids[]"]:checked').forEach(cb => {
            const name = cb.closest('label').querySelector('.text-gray-800').innerText;
            staff.push(`مشرف: ${name}`);
        });
        document.querySelectorAll('#step3 input[name="teacher_ids[]"]:checked').forEach(cb => {
            const name = cb.closest('label').querySelector('.text-gray-800').innerText;
            staff.push(`أستاذ: ${name}`);
        });
        document.querySelectorAll('#step3 input[name="admin_ids[]"]:checked').forEach(cb => {
            const name = cb.closest('label').querySelector('.text-gray-800').innerText;
            staff.push(`إداري: ${name}`);
        });
        if (staff.length === 0) staff.push('لم يتم اختيار فريق عمل');

        // Update preview lists
        updatePreviewList('program-data-preview-list', programData);
        updatePreviewList('students-data-preview-list', students);
        updatePreviewList('staff-data-preview-list', staff);

        // Fill hidden fields
        fillHiddenProgramFields();
    }

    function updatePreviewList(listId, data) {
        const list = document.getElementById(listId);
        list.innerHTML = '';

        if (typeof data === 'object' && !Array.isArray(data)) {
            // For object (program data)
            Object.entries(data).forEach(([label, value]) => {
                const li = document.createElement('li');
                li.className = 'text-sm text-gray-700';
                li.innerHTML = `<span class="font-medium text-gray-800">${label}:</span> ${value}`;
                list.appendChild(li);
            });
        } else {
            // For arrays (students, staff)
            data.forEach(item => {
                const li = document.createElement('li');
                li.className = 'text-sm text-gray-700 flex items-start';
                li.innerHTML = `<span class="inline-block bg-primary mt-1.5 mr-2 rounded-full w-2 h-2"></span> ${item}`;
                list.appendChild(li);
            });
        }
    }

    function fillHiddenProgramFields() {
        document.getElementById('hidden_name').value = document.querySelector('#step1 [name="name"]').value;
        document.getElementById('hidden_type').value = document.querySelector('#step1 [name="type"]').value;
        document.getElementById('hidden_start_date').value = document.querySelector('#step1 [name="start_date"]').value;
        document.getElementById('hidden_end_date').value = document.querySelector('#step1 [name="end_date"]').value;
        document.getElementById('hidden_academic_year_id').value = document.querySelector('#step1 [name="academic_year_id"]').value;
        document.getElementById('hidden_level_id').value = document.querySelector('#step1 [name="level_id"]').value;
        document.getElementById('hidden_registration_fees').value = document.querySelector('#step1 [name="registration_fees"]').value;
        document.getElementById('hidden_is_active').value = document.querySelector('#step1 [name="is_active"]').value;
        document.getElementById('hidden_description').value = document.querySelector('#step1 [name="description"]').value;

        // Add hidden inputs for students
        const hiddenStudentsDiv = document.getElementById('hidden-students');
        hiddenStudentsDiv.innerHTML = '';
        document.querySelectorAll('#step2 input[name="student_ids[]"]:checked').forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'student_ids[]';
            input.value = cb.value;
            hiddenStudentsDiv.appendChild(input);
        });

        // Add hidden inputs for staff
        ['supervisor_ids', 'teacher_ids', 'admin_ids'].forEach(type => {
            document.querySelectorAll(`#step3 input[name="${type}[]"]:checked`).forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `${type}[]`;
                input.value = cb.value;
                hiddenStudentsDiv.appendChild(input);
            });
        });
    }

    // DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        // Branch filter for students
        const branchFilter = document.getElementById('branchFilter');
        if (branchFilter) {
            branchFilter.addEventListener('change', function() {
                const selectedBranch = this.value;
                document.querySelectorAll('#students-list label').forEach(label => {
                    label.style.display = (!selectedBranch || label.getAttribute('data-branch') === selectedBranch) ? '' : 'none';
                });
            });
        }

        // Select/Deselect all students
        const selectAllBtn = document.getElementById('selectAllStudents');
        const deselectAllBtn = document.getElementById('deselectAllStudents');
        if (selectAllBtn && deselectAllBtn) {
            selectAllBtn.addEventListener('click', () => {
                document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = true);
            });
            deselectAllBtn.addEventListener('click', () => {
                document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = false);
            });
        }

        // Prevent double submit
        const finalForm = document.getElementById('finalProgramForm');
        if (finalForm) {
            finalForm.addEventListener('submit', function(e) {
                const finalSubmitBtn = document.getElementById('final-submit-btn');
                if (finalSubmitBtn) {
                    finalSubmitBtn.disabled = true;
                    finalSubmitBtn.innerHTML = '<i class="mr-2 fas fa-spinner fa-spin"></i> جاري الحفظ...';
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        function refreshStaffStep() {
            const yearId = document.getElementById('staff_academic_year_id').value;
            const staffType = document.getElementById('staff_type').value;
            fetch("{{ route('admin.programs.create') }}?step=3&staff_academic_year_id=" + yearId + "&staff_type=" + encodeURIComponent(staffType), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('staff-step-content').innerHTML = html;
                    syncStaffCheckboxes();
                });
        }

        document.getElementById('staff_academic_year_id').addEventListener('change', refreshStaffStep);
        document.getElementById('staff_type').addEventListener('change', refreshStaffStep);
    });

    let selectedStaff = {
        supervisor_ids: new Set(),
        teacher_ids: new Set(),
        admin_ids: new Set()
    };

    function syncStaffCheckboxes() {
        // Save checked staff before re-render
        document.querySelectorAll('#staff-step-content input[name="supervisor_ids[]"]').forEach(cb => {
            if (cb.checked) selectedStaff.supervisor_ids.add(cb.value);
            else selectedStaff.supervisor_ids.delete(cb.value);
        });
        document.querySelectorAll('#staff-step-content input[name="teacher_ids[]"]').forEach(cb => {
            if (cb.checked) selectedStaff.teacher_ids.add(cb.value);
            else selectedStaff.teacher_ids.delete(cb.value);
        });
        document.querySelectorAll('#staff-step-content input[name="admin_ids[]"]').forEach(cb => {
            if (cb.checked) selectedStaff.admin_ids.add(cb.value);
            else selectedStaff.admin_ids.delete(cb.value);
        });

        // After AJAX, restore checked state
        setTimeout(() => {
            document.querySelectorAll('#staff-step-content input[name="supervisor_ids[]"]').forEach(cb => {
                cb.checked = selectedStaff.supervisor_ids.has(cb.value);
                cb.addEventListener('change', function() {
                    if (cb.checked) selectedStaff.supervisor_ids.add(cb.value);
                    else selectedStaff.supervisor_ids.delete(cb.value);
                });
            });
            document.querySelectorAll('#staff-step-content input[name="teacher_ids[]"]').forEach(cb => {
                cb.checked = selectedStaff.teacher_ids.has(cb.value);
                cb.addEventListener('change', function() {
                    if (cb.checked) selectedStaff.teacher_ids.add(cb.value);
                    else selectedStaff.teacher_ids.delete(cb.value);
                });
            });
            document.querySelectorAll('#staff-step-content input[name="admin_ids[]"]').forEach(cb => {
                cb.checked = selectedStaff.admin_ids.has(cb.value);
                cb.addEventListener('change', function() {
                    if (cb.checked) selectedStaff.admin_ids.add(cb.value);
                    else selectedStaff.admin_ids.delete(cb.value);
                });
            });
        }, 0);
    }

    document.addEventListener('DOMContentLoaded', function() {
        syncStaffCheckboxes();

        function refreshStaffStep() {
            // Save checked staff before AJAX
            syncStaffCheckboxes();
            const yearId = document.getElementById('staff_academic_year_id').value;
            const staffType = document.getElementById('staff_type').value;
            fetch("{{ route('admin.programs.create') }}?step=3&staff_academic_year_id=" + yearId + "&staff_type=" + encodeURIComponent(staffType), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('staff-step-content').innerHTML = html;
                    // Restore checked state after AJAX
                    syncStaffCheckboxes();
                });
        }

        document.getElementById('staff_academic_year_id').addEventListener('change', refreshStaffStep);
        document.getElementById('staff_type').addEventListener('change', refreshStaffStep);
    });
</script>
@endsection