@extends('layouts.app')

@section('title', 'توليد واستيراد نتائج الامتحان')

@section('content')
<h1 class="mb-4 text-center section-title">توليد واستيراد نتائج الامتحان</h1>

@php
// Always get the active academic year and its current session
$activeAcademicYear = \App\Models\AcademicYear::where('status', true)->first();
$currentExamSession = $activeAcademicYear
? \App\Models\ExamSession::where('academic_year_id', $activeAcademicYear->id)->where('is_current', true)->first()
: null;
$currentExamSessionId = $currentExamSession ? $currentExamSession->id : null;
$currentSemester = $currentExamSession ? $currentExamSession->semester : null;
@endphp

@if($currentExamSession)
<div class="mb-3 text-center alert alert-info">
    جلسة الامتحان الحالية:
    <strong>
        {{ $currentExamSession->name ?? 'غير محددة' }}
    </strong>
</div>
@endif

@if($currentSemester)
<div class="mb-3 text-center alert alert-info">
    الفصل الحالي:
    <strong>
        @php
        $arabicSemester = match($currentSemester) {
        1, 'first', 'الأول' => 'الأول',
        2, 'second', 'الثاني' => 'الثاني',
        3, 'third', 'الثالث' => 'الثالث',
        default => $currentSemester,
        };
        @endphp
        {{ $arabicSemester }}
    </strong>
</div>
@endif

<!-- Section 1: إدارة المواد للمؤسسة -->
<div class="mb-4 p-4 card">
    <h5 class="mb-3 section-title">إضافة مواد من قائمة جاهزة</h5>
    <form action="{{ route('admin.subjects.store') }}" method="POST">
        @csrf
        <div class="bg-white p-2 border rounded subject-list">
            <div class="flex gap-2 mb-2">
                <button type="button" id="checkAllSubjects" class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white text-sm">تحديد الكل</button>
                <button type="button" id="uncheckAllSubjects" class="bg-gray-300 hover:bg-gray-400 px-3 py-1 rounded text-gray-800 text-sm">إلغاء التحديد</button>
            </div>
            @php
            // Example: group preset subjects by branch
            $presetSubjectsByBranch = [
            'علوم تجريبية' => [
            ['name' => 'ع.الطبيعة والحياة', 'coefficient' => 6],
            ['name' => 'علوم فيزيائية', 'coefficient' => 5],
            ['name' => 'رياضيات', 'coefficient' => 5],
            ['name' => 'ل.عربية وآدابها', 'coefficient' => 3],
            ['name' => 'لغة فرنسية', 'coefficient' => 2],
            ['name' => 'لغة إنجليزية', 'coefficient' => 2],
            ['name' => 'فلسفة', 'coefficient' => 2],
            ['name' => 'تاريخ وجغرافيا', 'coefficient' => 2],
            ['name' => 'علوم إسلامية', 'coefficient' => 2],
            ['name' => 'تربية بدنية', 'coefficient' => 1],
            ],
            'رياضيات' => [
            ['name' => 'رياضيات', 'coefficient' => 7],
            ['name' => 'علوم فيزيائية', 'coefficient' => 6],
            ['name' => 'ل.عربية وآدابها', 'coefficient' => 3],
            ['name' => 'ع.الطبيعة والحياة', 'coefficient' => 2],
            ['name' => 'تاريخ وجغرافيا', 'coefficient' => 2],
            ['name' => 'لغة فرنسية', 'coefficient' => 2],
            ['name' => 'لغة إنجليزية', 'coefficient' => 2],
            ['name' => 'فلسفة', 'coefficient' => 2],
            ['name' => 'علوم إسلامية', 'coefficient' => 2],
            ['name' => 'تربية بدنية', 'coefficient' => 1],
            ],
            'آداب وفلسفة' => [
            ['name' => 'ل.عربية وآدابها', 'coefficient' => 6],
            ['name' => 'فلسفة', 'coefficient' => 6],
            ['name' => 'تاريخ وجغرافيا', 'coefficient' => 4],
            ['name' => 'لغة فرنسية', 'coefficient' => 3],
            ['name' => 'لغة إنجليزية', 'coefficient' => 3],
            ['name' => 'رياضيات', 'coefficient' => 2],
            ['name' => 'علوم إسلامية', 'coefficient' => 2],
            ['name' => 'تربية بدنية', 'coefficient' => 1],
            ],
            ];
            $branchMap = $branches->pluck('id', 'name');
            @endphp
            @foreach($presetSubjectsByBranch as $branchName => $subjects)
            <div class="mb-3">
                <div class="mb-2 fw-bold" style="font-weight:bold;">
                    <span class="text-primary">{{ $branchName }}</span>
                    <span class="text-muted" style="font-size:0.95em;"> (المعاملات)</span>
                </div>
                <div class="row">
                    @foreach($subjects as $i => $subj)
                    <div class="mb-2 col-md-6">
                        <div class="form-check">
                            <input class="form-check-input subject-checkbox" type="checkbox"
                                name="subjects[{{ $branchName }}][{{ $i }}][add]"
                                id="preset_subject_{{ $branchName }}_{{ $i }}">
                            <label class="form-check-label" for="preset_subject_{{ $branchName }}_{{ $i }}">
                                {{ $subj['name'] }} (معامل: {{ $subj['coefficient'] }})
                            </label>
                            <input type="hidden" name="subjects[{{ $branchName }}][{{ $i }}][name]" value="{{ $subj['name'] }}">
                            <input type="hidden" name="subjects[{{ $branchName }}][{{ $i }}][coefficient]" value="{{ $subj['coefficient'] }}">
                            <input type="hidden" name="subjects[{{ $branchName }}][{{ $i }}][branch_id]" value="{{ $branchMap[$branchName] ?? '' }}">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
            <div class="mt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white">إضافة المواد المحددة إلى قاعدة البيانات</button>
            </div>
        </div>
    </form>
    <div class="mt-3">
        <label class="form-label">قائمة المواد الحالية:</label>
        <div class="bg-white p-2 border rounded subject-list">
            @foreach(\App\Models\Subject::with('branch')->whereIn('branch_id', $branches->pluck('id'))->get() as $subject)
            <span class="bg-secondary mb-1 badge">{{ $subject->name }} ({{ $subject->branch->name ?? '-' }}, معامل: {{ $subject->coefficient }})</span>
            @endforeach
        </div>
    </div>
</div>

<!-- Section 2: تحميل نموذج النتائج -->
<form action="{{ route('exam_results.prototype.download') }}" method="GET" class="mb-4 p-4 card">
    <h5 class="mb-3 section-title">تحميل نموذج النتائج</h5>
    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label">المستوى الدراسي</label>
            <select name="level_id" class="form-select">
                <option value="">كل المستويات</option>
                @foreach($levels as $level)
                <option value="{{ $level->id }}">{{ $level->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">الشعب (جميع الشعب محددة افتراضياً)</label>
            <select name="branch_ids[]" class="form-select" id="branchSelect" multiple readonly style="background:#e9ecef; pointer-events:none;" tabindex="-1">
                @foreach($branches as $branch)
                <option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
                @endforeach
            </select>
            <div class="text-muted form-text" style="font-size:0.95em;">سيتم إنشاء صفحة لكل شعبة في ملف Excel. جميع الشعب مفعلة افتراضياً.</div>
        </div>
        <div class="col-md-3">
            <label class="form-label">القسم (Section)</label>
            <select name="section" class="form-select" id="sectionSelect">
                <option value="">اختر القسم</option>
                @php
                $sections = $students->pluck('initial_classroom')->unique()->filter()->values();
                @endphp
                @foreach($sections as $section)
                <option value="{{ $section }}">{{ $section }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">تحديد الطلاب بالاسم (اختياري)</label>
            <select name="student_ids[]" class="form-select" multiple size="4">
                @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->full_name }} (شعبة: {{ $student->branch_id }}, قسم: {{ $student->initial_classroom }})</option>
                @endforeach
            </select>
        </div>
    </div>
    <input type="hidden" name="academic_year_id" value="{{ $activeAcademicYearId }}">
    <input type="hidden" name="exam_session_id" value="{{ $currentExamSessionId }}">
    <div class="mb-3 text-center alert alert-info">
        جلسة الامتحان الحالية:
        <strong>{{ $currentExamSessionId ? \App\Models\ExamSession::find($currentExamSessionId)->name : 'غير محددة' }}</strong>
    </div>
    <div class="flex gap-2 mt-3">
        <button type="submit" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded text-white">تحميل نموذج النتائج (كل الشعب في ملف واحد)</button>
        <a href="{{ route('exam_results.prototype.form') }}" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded text-gray-800">إعادة تعيين التحديد</a>
    </div>
</form>

<!-- Section 3: رفع النتائج -->
<form action="{{ route('exam_results.import') }}" method="POST" enctype="multipart/form-data" class="mb-4 p-4 card">
    @csrf
    <h5 class="mb-3 section-title">رفع ملف نتائج الامتحان</h5>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">الشعب (جميع الشعب افتراضيًا)</label>
            <select name="branch_ids[]" class="form-select" multiple readonly style="background:#e9ecef; pointer-events:none;" tabindex="-1">
                @foreach($branches as $branch)
                <option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
                @endforeach
            </select>
            <div class="text-muted form-text" style="font-size:0.95em;">سيتمكن النظام من مطابقة النتائج لجميع الشعب افتراضيًا.</div>
        </div>
        <div class="col-md-4">
            <label class="form-label">اختر القسم (Section)</label>
            <select name="section" class="form-select">
                <option value="">اختر القسم</option>
                @foreach($sections as $section)
                <option value="{{ $section }}">{{ $section }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">ملف النتائج (XLSX)</label>
            <input type="file" name="results_file" class="form-control" required>
        </div>
    </div>
    <input type="hidden" name="academic_year_id" value="{{ $activeAcademicYearId }}">
    <input type="hidden" name="exam_session_id" value="{{ $currentExamSessionId }}">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 mt-3 px-4 py-2 rounded text-white">إضافة النتائج إلى قاعدة البيانات</button>
</form>

@if(session('success'))
<div class="bg-green-100 mt-3 px-4 py-3 border border-green-300 rounded text-green-800">{!! session('success') !!}</div>
@endif

<script>
    // Prepare sections data for each branch in PHP and pass to JS

    document.addEventListener('DOMContentLoaded', function() {
        var branchSelect = document.getElementById('branchSelect');
        var sectionSelect = document.getElementById('sectionSelect');
        if (branchSelect && sectionSelect) {
            branchSelect.addEventListener('change', function() {
                var branchId = this.value;
                sectionSelect.innerHTML = '<option value="">اختر القسم</option>';
                if (branchId && branchSectionsMap[branchId]) {
                    branchSectionsMap[branchId].forEach(function(section) {
                        if (section && section !== '') {
                            var option = document.createElement('option');
                            option.value = section;
                            option.textContent = section;
                            sectionSelect.appendChild(option);
                        }
                    });
                }
            });
        }

        // Check all/uncheck all for subjects
        document.getElementById('checkAllSubjects').onclick = function() {
            document.querySelectorAll('.subject-checkbox').forEach(cb => cb.checked = true);
        };
        document.getElementById('uncheckAllSubjects').onclick = function() {
            document.querySelectorAll('.subject-checkbox').forEach(cb => cb.checked = false);
        };
    });
</script>
@endsection