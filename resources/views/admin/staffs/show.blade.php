<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المؤطر: {{ $staff->full_name }}</title>
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
    <nav class="bg-blue-800 shadow-lg text-white">
        <div class="flex justify-between items-center mx-auto px-4 py-3 container">
            <div class="flex items-center space-x-4 space-x-reverse">
                <i class="text-2xl fas fa-graduation-cap"></i>
                <span class="font-semibold text-xl">برنامج الطالب المتفوق</span>
            </div>
            <div class="flex items-center space-x-6 space-x-reverse">
                <a href="#" class="relative hover:text-blue-200">
                    <i class="fas fa-bell"></i>
                    <span
                        class="-top-2 -right-2 absolute flex justify-center items-center bg-red-500 rounded-full w-5 h-5 text-white text-xs">5</span>
                </a>
                <div class="flex items-center space-x-2 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random"
                        class="rounded-full w-8 h-8" alt="صورة المستخدم">
                    <span>{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <aside class="top-0 sticky bg-white shadow-md w-64 h-screen">
            <div class="p-4 border-gray-200 border-b">
                <div class="flex items-center space-x-3 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random"
                        class="rounded-full w-10 h-10" alt="صورة المستخدم">
                    <div>
                        <p class="font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500 text-xs">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4">
                <ul class="space-y-2 mt-4">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>لوحة التحكم</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fa-layer-group fas"></i>
                            <span>المستويات الدراسية</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-users"></i>
                            <span>الطلبة</span>
                            <span
                                class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">{{ App\Models\Student::count() }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.staffs.index') }}"
                            class="flex items-center space-x-2 space-x-reverse bg-blue-100 p-3 rounded-lg text-blue-800">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>المؤطرين</span>
                            <span
                                class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">{{ App\Models\Staff::count() }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-calendar-alt"></i>
                            <span>البرامج التعليمية</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-user-check"></i>
                            <span>الحضور والغياب</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>المدفوعات المالية</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-chart-bar"></i>
                            <span>التقارير والإحصائيات</span>
                        </a>
                    </li>

                    <div class="mt-8 pt-4 border-gray-200 border-t">
                        <a href="#"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-red-50 p-3 rounded-lg text-red-600">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>تسجيل الخروج</span>
                        </a>
                    </div>
                </ul>
            </div>
        </aside>


        <main class="flex-1 p-8">
            <div class="bg-white shadow-md p-6 rounded-lg max-w-3xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">تفاصيل المؤطر: {{ $staff->full_name }}</h1>
                    <a href="{{ route('admin.staffs.index') }}" class="text-blue-600 hover:underline">العودة
                        للقائمة</a>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-gray-500 text-sm">الاسم الكامل:</p>
                        <p class="font-medium text-lg">{{ $staff->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">تاريخ الميلاد:</p>
                        <p class="font-medium">
                            {{ \Carbon\Carbon::parse($staff->birth_date)->translatedFormat('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">رقم الهاتف:</p>
                        <p class="font-medium">{{ $staff->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">سنة البكالوريا:</p>
                        <p class="font-medium">{{ $staff->bac_year ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">التخصص الجامعي:</p>
                        <p class="font-medium">{{ $staff->univ_specialty ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">نوع الموظف:</p>
                        <p class="font-medium">{{ $staff->type }}</p>
                    </div>
                    @if ($staff->type === 'مؤطر دراسي')
                        <div>
                            <p class="text-gray-500 text-sm">الشعبة:</p>
                            <p class="font-medium">{{ $staff->branch->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">المواد الدراسية:</p>
                            <div class="flex flex-wrap gap-2">
                                @forelse($staff->subjects as $subject)
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                        {{ $subject->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-500">- لا توجد مواد -</span>
                                @endforelse
                            </div>
                        </div>
                    @endif
                    {{-- Add more staff details here as needed --}}
                </div>

                <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end space-x-3 space-x-reverse">
                    <a href="{{ route('admin.staffs.edit', $staff->id) }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-edit ml-2"></i> تعديل
                    </a>
                    <form action="{{ route('admin.staffs.destroy', $staff->id) }}" method="POST"
                        onsubmit="return confirm('هل أنت متأكد من حذف هذا المؤطر؟');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            <i class="fas fa-trash-alt ml-2"></i> حذف
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
