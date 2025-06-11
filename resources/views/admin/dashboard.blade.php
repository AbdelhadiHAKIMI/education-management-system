=======
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
    <!-- Main Content -->
    <div class="flex">
        <!-- Content Area -->
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="font-bold text-gray-800 text-2xl">لوحة تحكم مدير المؤسسة</h1>
                    <p class="text-gray-600">مرحباً بعودتك، {{ Auth::user()->name ?? 'اسم المستخدم' }}</p>
                </div>
                <div class="flex space-x-3 space-x-reverse">
                    <button class="flex items-center space-x-2 space-x-reverse bg-white hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-lg text-gray-700">
                        <i class="fas fa-file-export"></i>
                        <span>تصدير البيانات</span>
                    </button>
                    <a href="{{ route('admin.programs.create') }}" class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                        <i class="fas fa-plus"></i>
                        <span>برنامج جديد</span>
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="gap-6 grid grid-cols-1 md:grid-cols-4 mb-8">
                <div class="bg-white shadow-md p-6 border-r-4 border-blue-500 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">الطلاب المسجلين</p>
                            <h3 class="font-bold text-2xl">324</h3>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="text-blue-600 fas fa-users"></i>
                        </div>
                    </div>
                    <p class="mt-2 text-green-500 text-sm">
                        <i class="fas fa-arrow-up"></i> 8% عن الشهر الماضي
                    </p>
                </div>

                <div class="bg-white shadow-md p-6 border-green-500 border-r-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">البرامج النشطة</p>

                            <h3 class="font-bold text-2xl">{{ \App\Models\Program::where('is_active', true)->count() }}</h3>

                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="text-green-600 fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <p class="mt-2 text-green-500 text-sm">
                        <i class="fas fa-arrow-up"></i> 2 برامج جديدة
                    </p>
                </div>

                <div class="bg-white shadow-md p-6 border-yellow-500 border-r-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">المدفوعات الشهرية</p>
                            <h3 class="font-bold text-2xl">2,450,000 د.ج</h3>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <i class="text-yellow-600 fas fa-donate"></i>
                        </div>
                    </div>
                    <p class="mt-2 text-red-500 text-sm">
                        <i class="fas fa-arrow-down"></i> 12% عن الشهر الماضي
                    </p>
                </div>

                <div class="bg-white shadow-md p-6 border-purple-500 border-r-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">نسبة الحضور</p>
                            <h3 class="font-bold text-2xl">89%</h3>
                        </div>
                    </div>
                    <p class="mt-2 text-green-500 text-sm">
                        <i class="fas fa-arrow-up"></i> 5% عن الأسبوع الماضي
                    </p>
                </div>
            </div>

            <!-- Programs Section -->
            @php
            use App\Models\Program;
            $programs = Program::all();
            @endphp
            @forelse($programs as $program)
            <div class="bg-white shadow-md mb-8 p-6 border-accent border-r-4 rounded-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="font-semibold text-dark text-xl">{{ $program->name ?? 'اسم البرنامج غير متوفر' }}</h2>
                        <p class="mt-1 text-gray-600">2023/2024 - الفصل الثاني</p>
                        <div class="flex items-center space-x-4 space-x-reverse mt-3">
                            <div>
                                <span class="text-gray-500 text-sm">تاريخ البدء</span>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($program->start_date ?? '2023-09-05')->translatedFormat('d F Y') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500 text-sm">الحالة</span>
                                @if($program->is_active ?? true)
                                <p class="font-medium text-green-600">جارية</p>
                                @else
                                <p class="font-medium text-red-600">منتهية</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-3 space-x-reverse">
                        <button class="flex items-center bg-primary hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                            <i class="mr-2 fas fa-archive"></i> أرشفة السنة
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-4 text-gray-500 text-center">لا توجد برامج متاحة حالياً.</td>
            </tr>
            @endforelse

            <!-- Recent Activities -->
            <div class="bg-white shadow-md p-6 rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-semibold text-gray-800 text-xl">أحدث الأنشطة</h2>
                    <a href="#" class="text-blue-600 hover:underline">عرض الكل</a>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start space-x-3 space-x-reverse">
                        <div class="bg-blue-100 p-2 rounded-full">
                            <i class="text-blue-600 fas fa-user-plus"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium">تم تسجيل 5 طلاب جدد</p>
                            <p class="text-gray-500 text-sm">في برنامج اللغة الإنجليزية</p>
                            <p class="text-gray-400 text-xs">منذ ساعتين</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 space-x-reverse">
                        <div class="bg-green-100 p-2 rounded-full">
                            <i class="text-green-600 fas fa-money-bill-wave"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium">تم تسديد 3 مدفوعات</p>
                            <p class="text-gray-500 text-sm">إجمالي المبلغ: 75,000 د.ج</p>
                            <p class="text-gray-400 text-xs">منذ 5 ساعات</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 space-x-reverse">
                        <div class="bg-purple-100 p-2 rounded-full">
                            <i class="text-purple-600 fas fa-user-check"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium">تقرير الحضور اليومي</p>
                            <p class="text-gray-500 text-sm">نسبة الحضور: 92%</p>
                            <p class="text-gray-400 text-xs">منذ يوم</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @endsection
</body>

</html>

