<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>نموذج تصدير نتائج الامتحان</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="py-5 container">
        <h1 class="mb-4 text-center">توليد نموذج نتائج الامتحان (XLSX)</h1>
        @if(isset($currentSemester))
        <div class="mb-3 text-center alert alert-info">
            الفصل الحالي: <strong>{{ $currentSemester == 'first' ? 'الأول' : 'الثاني' }}</strong>
        </div>
        @endif
        <form action="{{ route('exam_results.prototype.download') }}" method="GET" class="mb-4 p-4 card">
            <div class="mb-3 row">
                <div class="col-md-4">
                    <label class="form-label">المستوى الدراسي</label>
                    <select name="level_id" class="form-select">
                        <option value="">كل المستويات</option>
                        @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">الشعبة</label>
                    <select name="branch_id" class="form-select">
                        <option value="">كل الشعب</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">القسم الأولي</label>
                    <input type="text" name="initial_classroom" class="form-control" placeholder="مثال: أ">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">تحديد الطلاب بالاسم (اختياري)</label>
                <select name="student_ids[]" class="form-select" multiple size="8">
                    @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->full_name }} (شعبة: {{ $student->branch_id }}, قسم: {{ $student->initial_classroom }})</option>
                    @endforeach
                </select>
                <div class="form-text">يمكنك اختيار أكثر من طالب بالضغط على Ctrl أو Shift.</div>
            </div>
            <div class="d-flex gap-2 mb-3">
                <button type="submit" class="btn btn-success">تحميل النموذج</button>
                <a href="{{ route('exam_results.prototype.form') }}" class="btn btn-secondary">إعادة تعيين التحديد</a>
            </div>
        </form>

        <!-- Upload results form -->
        <form action="{{ route('exam_results.import') }}" method="POST" enctype="multipart/form-data" class="mb-4 p-4 card">
            @csrf
            <div class="mb-3">
                <label class="form-label">رفع ملف نتائج الامتحان (XLSX)</label>
                <input type="file" name="results_file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">إضافة النتائج إلى قاعدة البيانات</button>
        </form>

        @if(session('success'))
        <div class="mt-3 alert alert-success">{!! session('success') !!}</div>
        @endif
    </div>
</body>

</html>