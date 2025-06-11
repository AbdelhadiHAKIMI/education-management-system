@extends('layouts.app')

@section('title', 'معالج ملفات CSV')

@section('content')
<div class="py-5 container">
    <h1 class="mb-4 text-center">معالج ملفات CSV</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Branches List -->
    @isset($branches)
    <div class="mb-4 card">
        <div class="bg-info text-white card-header">
            قائمة أرقام وأسماء الشعب المتاحة
        </div>
        <div class="p-2 card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm mb-0">
                    <thead>
                        <tr>
                            <th>رقم الشعبة</th>
                            <th>اسم الشعبة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($branches as $branch)
                        <tr>
                            <td>{{ $branch->id }}</td>
                            <td>{{ $branch->name ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2 text-muted" style="font-size:0.95em;">
                يرجى استخدام رقم الشعبة الصحيح في ملف CSV.
            </div>
        </div>
    </div>
    @endisset

    <!-- Upload Section -->
    <div class="mb-4 card">
        <div class="bg-primary text-white card-header">
            رفع ملف CSV
        </div>
        <div class="card-body">
            <form action="{{ route('csv.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input class="form-control" type="file" name="csv_file" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">المستوى الدراسي (سيتم تطبيقه على جميع الطلاب):</label>
                    <select class="form-select" name="level_id" required>
                        <option value="">اختر المستوى</option>
                        @isset($levels)
                        @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->name ?? '-' }}</option>
                        @endforeach
                        @endisset
                    </select>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label class="form-label">الشعبة (اختر رقم الشعبة الصحيح):</label>
                        <select class="form-select" disabled>
                            @isset($branches)
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name ?? '-' }} ({{ $branch->id }})</option>
                            @endforeach
                            @endisset
                        </select>
                        <div class="text-muted form-text">استخدم رقم الشعبة هذا في ملف CSV.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">مستوى حفظ القرآن:</label>
                        <select class="form-select" disabled>
                            <option value="مستظهر">مستظهر</option>
                            <option value="خاتم">خاتم</option>
                        </select>
                        <div class="text-muted form-text">استخدم أحد هذه القيم في ملف CSV.</div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">رفع الملف</button>
            </form>
        </div>
    </div>

    <!-- Download Prototype Button -->
    <div class="mb-4 text-center">
        <a href="{{ route('csv.prototype') }}" class="btn-outline-secondary btn">
            تحميل نموذج CSV للطلاب
        </a>
        <a href="{{ route('csv.prototype.xlsx') }}" class="ms-2 btn-outline-success btn">
            تحميل نموذج Excel للطلاب مع قوائم منسدلة
        </a>
        <div class="mt-2 text-muted" style="font-size: 0.95em;">
            قم بتحميل النموذج، ثم املأه بمعلومات الطلاب، ثم ارفع الملف هنا.
        </div>
    </div>

    @if(isset($headers))
    <!-- Filter Section -->
    <div class="filter-section">
        <form action="{{ route('csv.show') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <select class="form-select" name="filter_type">
                        <option value="none" {{ (isset($filterType) && $filterType == 'none') ? 'selected' : '' }}>بدون تصفية
                        </option>
                        <option value="first_letter" {{ (isset($filterType) && $filterType == 'first_letter') ? 'selected' : '' }}>الحرف الأول من الاسم
                        </option>
                        <option value="name" {{ (isset($filterType) && $filterType == 'name') ? 'selected' : '' }}>بحث بالاسم
                        </option>
                        <option value="branch" {{ (isset($filterType) && $filterType == 'branch') ? 'selected' : '' }}>الشعبة
                        </option>
                        <option value="rate" {{ (isset($filterType) && $filterType == 'rate') ? 'selected' : '' }}>المعدل الأعلى من
                        </option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="filter_value" placeholder="أدخل قيمة التصفية"
                        value="{{ isset($filterValue) ? $filterValue : '' }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="w-100 btn btn-primary">تصفية</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Display -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    @foreach($headers as $header)
                    <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                <tr>
                    @foreach($headers as $header)
                    <td>{{ $row[$header] ?? '' }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $data->links() }}
        </div>
    </div>

    <!-- Download Button -->
    <div class="mt-4 text-center">
        <a href="{{ route('csv.download') }}" class="btn btn-success">
            تحميل البيانات
        </a>
    </div>
    @endif
</div>
@endsection