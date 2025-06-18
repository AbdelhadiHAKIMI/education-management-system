@extends('layouts.app')

@section('title', 'معالج ملفات CSV')

@section('content')
<div class="mx-auto py-8 max-w-4xl container">
    <h1 class="mb-6 font-bold text-blue-800 text-2xl text-center">معالج ملفات CSV</h1>

    @if(session('success'))
    <div class="shadow mb-6 alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Upload Section -->
    <div class="bg-white shadow mb-6 border rounded-xl">
        <div class="bg-gradient-to-l from-indigo-600 to-blue-500 px-4 py-3 rounded-t-xl font-semibold text-white">
            رفع ملف CSV
        </div>
        <div class="p-4">
            <form action="{{ route('csv.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="font-medium text-gray-700 form-label">اختر ملف CSV</label>
                    <input class="form-control" type="file" name="csv_file" required>
                </div>
                <div class="mb-4">
                    <label class="font-medium text-gray-700 form-label">المستوى الدراسي (سيتم تطبيقه على جميع الطلاب):</label>
                    <select class="form-select" name="level_id" required>
                        <option value="">اختر المستوى</option>
                        @isset($levels)
                        @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->name ?? '-' }}</option>
                        @endforeach
                        @endisset
                    </select>
                </div>
                <div class="mb-4 row">


                </div>
                <button type="submit" class="shadow-sm mt-4 py-2 w-100 btn btn-gradient-blue fw-bold">
                    <i class="ms-2 fas fa-upload"></i> رفع الملف
                </button>
            </form>
        </div>
    </div>

    <!-- Download Prototype Button -->
    <div class="flex flex-col items-center mb-6 text-center">
        <div class="flex sm:flex-row flex-col justify-center gap-3 mb-2">
            <a href="{{ route('csv.prototype') }}"
                class="flex items-center gap-2 shadow-sm px-5 py-2 rounded-pill btn-outline-secondary btn btn-lg">
                <i class="fas fa-download"></i>
                تحميل نموذج CSV للطلاب
            </a>
            <a href="{{ route('csv.prototype.xlsx') }}"
                class="flex items-center gap-2 shadow-sm px-5 py-2 rounded-pill btn-outline-success btn btn-lg">
                <i class="fas fa-file-excel"></i>
                تحميل نموذج Excel للطلاب مع قوائم منسدلة
            </a>
        </div>
        <div class="bg-gray-50 mx-auto mt-2 px-3 py-2 rounded-lg w-fit text-muted text-base">
            قم بتحميل النموذج، ثم املأه بمعلومات الطلاب، ثم ارفع الملف هنا.
        </div>
    </div>

    @if(isset($headers))
    <!-- Filter Section -->
    <div class="bg-white shadow mb-4 p-4 border rounded-xl">
        <form action="{{ route('csv.show') }}" method="GET" class="align-items-end row g-3">
            <div class="col-md-4">
                <label class="text-gray-700 form-label">نوع التصفية</label>
                <select class="form-select" name="filter_type">
                    <option value="none" {{ (isset($filterType) && $filterType == 'none') ? 'selected' : '' }}>بدون تصفية</option>
                    <option value="first_letter" {{ (isset($filterType) && $filterType == 'first_letter') ? 'selected' : '' }}>الحرف الأول من الاسم</option>
                    <option value="name" {{ (isset($filterType) && $filterType == 'name') ? 'selected' : '' }}>بحث بالاسم</option>
                    <option value="branch" {{ (isset($filterType) && $filterType == 'branch') ? 'selected' : '' }}>الشعبة</option>
                    <option value="rate" {{ (isset($filterType) && $filterType == 'rate') ? 'selected' : '' }}>المعدل الأعلى من</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="text-gray-700 form-label">قيمة التصفية</label>
                <input type="text" class="form-control" name="filter_value" placeholder="أدخل قيمة التصفية"
                    value="{{ isset($filterValue) ? $filterValue : '' }}">
            </div>
            <div class="d-grid col-md-2">
                <button type="submit" class="shadow-sm btn btn-gradient-blue fw-bold">
                    <i class="ms-2 fas fa-filter"></i>تصفية
                </button>
            </div>
        </form>
    </div>

    <!-- Data Display -->
    <div class="table-responsive bg-white shadow border rounded-xl">
        <table class="table table-bordered table-striped mb-0 align-middle">
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
        <a href="{{ route('csv.download') }}" class="shadow-sm rounded-pill btn btn-gradient-green btn-lg">
            <i class="ms-2 fas fa-file-csv"></i>تحميل البيانات
        </a>
    </div>
    @endif
</div>

<style>
    .btn-gradient-blue {
        background: linear-gradient(to left, #6366f1, #2563eb);
        color: #fff !important;
        border: none;
    }

    .btn-gradient-blue:hover {
        background: linear-gradient(to left, #4338ca, #1d4ed8);
        color: #fff !important;
    }

    .btn-gradient-green {
        background: linear-gradient(to left, #22c55e, #16a34a);
        color: #fff !important;
        border: none;
    }

    .btn-gradient-green:hover {
        background: linear-gradient(to left, #15803d, #22c55e);
        color: #fff !important;
    }
</style>
@endsection