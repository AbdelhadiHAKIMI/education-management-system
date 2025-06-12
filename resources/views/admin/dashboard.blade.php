<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - مدير المؤسسة</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');

        body {
            font-family: 'Tajawal', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    @extends('layouts.app')

    @section('title', 'لوحة التحكم - مدير المؤسسة')

    @section('content')
    <div class="flex flex-col gap-8">
        <!-- Header -->
        <div class="flex md:flex-row flex-col md:justify-between md:items-center gap-4 mb-6">
            <div>
                <h1 class="mb-1 font-bold text-gray-800 text-2xl">لوحة تحكم مدير المؤسسة</h1>
                <p class="text-gray-500">مرحباً بعودتك، {{ Auth::user()->name ?? 'اسم المستخدم' }}</p>
            </div>
            <div class="flex gap-2">
                <a href="#" class="flex items-center gap-2 bg-white hover:bg-gray-100 shadow-sm px-4 py-2 border border-gray-300 rounded-lg text-gray-700 transition">
                    <i class="fas fa-file-export"></i>
                    <span>تصدير البيانات</span>
                </a>
                <a href="{{ route('admin.programs.create') }}" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 shadow px-4 py-2 rounded-lg text-white transition">
                    <i class="fas fa-plus"></i>
                    <span>برنامج جديد</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="gap-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            <div class="flex flex-col gap-2 bg-white shadow p-6 border-t-4 border-blue-500 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="text-blue-600 fas fa-users fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">الطلاب المسجلين</p>
                        <h3 class="font-bold text-2xl">{{ $studentsCount ?? 0 }}</h3>
                    </div>
                </div>
                <p class="mt-2 text-green-500 text-xs"><i class="fas fa-arrow-up"></i> 8% عن الشهر الماضي</p>
            </div>
            <div class="flex flex-col gap-2 bg-white shadow p-6 border-green-500 border-t-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="text-green-600 fas fa-calendar-check fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">البرامج النشطة</p>
                        <h3 class="font-bold text-2xl">{{ \App\Models\Program::where('is_active', true)->count() }}</h3>
                    </div>
                </div>
                <p class="mt-2 text-green-500 text-xs"><i class="fas fa-arrow-up"></i> 2 برامج جديدة</p>
            </div>
            <div class="flex flex-col gap-2 bg-white shadow p-6 border-yellow-500 border-t-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="text-yellow-600 fas fa-donate fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">المدفوعات الشهرية</p>
                        <h3 class="font-bold text-2xl">2,450,000 د.ج</h3>
                    </div>
                </div>
                <p class="mt-2 text-red-500 text-xs"><i class="fas fa-arrow-down"></i> 12% عن الشهر الماضي</p>
            </div>
            <div class="flex flex-col gap-2 bg-white shadow p-6 border-purple-500 border-t-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="text-purple-600 fas fa-user-check fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">نسبة الحضور</p>
                        <h3 class="font-bold text-2xl">89%</h3>
                    </div>
                </div>
                <p class="mt-2 text-green-500 text-xs"><i class="fas fa-arrow-up"></i> 5% عن الأسبوع الماضي</p>
            </div>
        </div>

        <!-- Programs Section -->
        @php
        use App\Models\Program;
        $programs = Program::orderByDesc('is_active')->orderByDesc('start_date')->take(4)->get();
        @endphp
        <div>
            <h2 class="mb-4 font-semibold text-gray-700 text-lg">البرامج التعليمية الأخيرة</h2>
            <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                @forelse($programs as $program)
                <div class="bg-white shadow rounded-lg p-5 flex flex-col gap-2 border-r-4 {{ $program->is_active ? 'border-green-500' : 'border-gray-300' }}">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-semibold text-dark text-xl">{{ $program->name ?? 'اسم البرنامج غير متوفر' }}</h3>
                        <span class="px-3 py-1 rounded-full text-xs {{ $program->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $program->is_active ? 'نشط' : 'منتهي' }}
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-4 text-gray-500 text-sm">
                        <div>
                            <i class="mr-1 fas fa-calendar-alt"></i>
                            {{ \Carbon\Carbon::parse($program->start_date)->format('d/m/Y') }}
                            -
                            {{ \Carbon\Carbon::parse($program->end_date)->format('d/m/Y') }}
                        </div>
                        <div>
                            <i class="mr-1 fas fa-users"></i>
                            {{ \App\Models\ProgramInvitation::where('program_id', $program->id)->where('status', 'accepted')->count() }} طالب
                        </div>
                        <div>
                            <i class="mr-1 fas fa-coins"></i>
                            {{ is_numeric($program->registration_fees) ? number_format($program->registration_fees, 2, '.', '') : 'غير متوفر' }} د.ج
                        </div>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <a href="#" class="flex-1 bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded text-blue-600 text-sm text-center transition">
                            <i class="mr-1 fas fa-eye"></i> عرض
                        </a>
                        <a href="#" class="flex-1 bg-gray-50 hover:bg-gray-100 px-3 py-2 rounded text-gray-600 text-sm text-center transition">
                            <i class="mr-1 fas fa-edit"></i> تعديل
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-2 py-8 text-gray-400 text-center">لا توجد برامج متاحة حالياً.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Activities -->
        <div>
            <h2 class="mb-4 font-semibold text-gray-700 text-lg">أحدث الأنشطة</h2>
            <div class="space-y-5 bg-white shadow p-6 rounded-lg">
                <div class="flex items-start gap-3">
                    <div class="bg-blue-100 p-2 rounded-full">
                        <i class="text-blue-600 fas fa-user-plus"></i>
                    </div>
                    <div>
                        <p class="font-medium">تم تسجيل 5 طلاب جدد</p>
                        <p class="text-gray-500 text-sm">في برنامج اللغة الإنجليزية</p>
                        <p class="text-gray-400 text-xs">منذ ساعتين</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="bg-green-100 p-2 rounded-full">
                        <i class="text-green-600 fas fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <p class="font-medium">تم تسديد 3 مدفوعات</p>
                        <p class="text-gray-500 text-sm">إجمالي المبلغ: 75,000 د.ج</p>
                        <p class="text-gray-400 text-xs">منذ 5 ساعات</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="bg-purple-100 p-2 rounded-full">
                        <i class="text-purple-600 fas fa-user-check"></i>
                    </div>
                    <div>
                        <p class="font-medium">تقرير الحضور اليومي</p>
                        <p class="text-gray-500 text-sm">نسبة الحضور: 92%</p>
                        <p class="text-gray-400 text-xs">منذ يوم</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>

</html>