<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلاب - نظام الإدارة التعليمية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 font-tajawal">
    <!-- Navigation (Same as Dashboard) -->

    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar (Same as Dashboard) -->

        <!-- Content Area -->
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="font-bold text-gray-800 text-2xl">إدارة الطلاب</h1>
                <a href="{{ route('admin.students.create') }}" class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                    <i class="fas fa-plus"></i>
                    <span>إضافة طالب جديد</span>
                </a>
            </div>

            <!-- Filters (optional, not functional in this snippet) -->
            <!-- ...existing code for filters... -->

            <!-- Students Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">رقم التسجيل</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الاسم الكامل</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">المستوى</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الشعبة</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الحالة</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($students as $student)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $student->id }}</td>
                                <td class="px-4 py-3 font-medium">{{ $student->full_name }}</td>
                                <td class="px-4 py-3">{{ $student->level->name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $student->branch->name ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="bg-green-100 px-2 py-1 rounded-full text-green-800 text-xs">نشط</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <a href="{{ route('admin.students.show', $student) }}" class="text-blue-600 hover:text-blue-800" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.students.edit', $student) }}" class="text-yellow-600 hover:text-yellow-800" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف الطالب؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-gray-500 text-center">لا يوجد طلاب مسجلين في السنة الدراسية الحالية.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex justify-between items-center px-4 py-3 border-gray-200 border-t">
                    {{ $students->links() }}
                </div>
            </div>
        </main>
    </div>
</body>

</html>