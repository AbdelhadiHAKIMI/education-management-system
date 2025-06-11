<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المؤطرين - برنامج الطالب المتفوق</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');

        body {
            font-family: 'Tajawal', sans-serif;
        }

        .teacher-table th {
            /* This class is on the <table>, not the <th>, so it's not applying styles. Removing it from here */
            background-color: #f3f4f6;
            font-weight: 600;
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
                                class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">{{ $studentCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.staffs.index') }}"
                            class="flex items-center space-x-2 space-x-reverse bg-blue-100 p-3 rounded-lg text-blue-800">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>المؤطرين</span>
                            <span
                                class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">{{ $staffCount }}</span>
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
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="font-bold text-gray-800 text-2xl">إدارة المؤطرين</h1>
                    <p class="text-gray-600">قائمة بجميع مؤطري المؤسسة</p>
                </div>
                <div class="flex space-x-3 space-x-reverse">
                    <a href="{{ route('admin.staffs.create') }}"
                        class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                        <i class="fas fa-plus"></i>
                        <span>إضافة مؤطر</span>
                    </a>
                </div>
            </div>

            <div class="bg-white shadow-md mb-6 p-4 rounded-lg">
                <form method="GET" action="{{ route('admin.staffs.index') }}">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="relative flex-1">
                            <input type="text" name="search" placeholder="ابحث عن مؤطر..."
                                value="{{ request('search') }}"
                                class="w-full pr-10 pl-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                        </div>
                        <div class="flex space-x-3 space-x-reverse">
                            <select name="branch" class="border border-gray-300 rounded-lg px-3 py-2 text-gray-700">
                                <option value="">كل الشعب</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                بحث
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-md overflow-hidden rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-right">#</th>
                            <th class="px-6 py-3 text-right">الاسم الكامل</th>
                            <th class="px-6 py-3 text-right">الشعبة</th>
                            <th class="px-6 py-3 text-right">الهاتف</th>
                            {{-- REMOVED: <th class="px-6 py-3 text-right">التخصص الجامعي</th> --}}
                            <th class="px-6 py-3 text-right">المواد الدراسية</th>
                            <th class="px-6 py-3 text-right">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($staffs as $index => $staff)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium">{{ $staff->full_name }}</td>
                                <td class="px-6 py-4">
                                    @if ($staff->branch)
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">
                                            {{ $staff->branch->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-500 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $staff->phone ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-500">
                                    @if ($staff->type === 'مؤطر دراسي' && $staff->subjects->isNotEmpty())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($staff->subjects as $subject)
                                                <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded text-xs">
                                                    {{ $subject->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2 space-x-reverse">
                                        {{-- NEW: View Action --}}
                                        <a href="{{ route('admin.staffs.show', $staff->id) }}"
                                            class="text-gray-600 hover:text-gray-800" title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.staffs.edit', $staff->id) }}"
                                            class="text-blue-600 hover:text-blue-800" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.staffs.destroy', $staff->id) }}" method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا المؤطر؟');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800"
                                                title="حذف">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">لا يوجد مؤطرون مسجلون
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="border-t border-gray-200 px-6 py-4">
                    {{ $staffs->links() }}
                </div>
            </div>
        </main>
    </div>
</body>

</html>
