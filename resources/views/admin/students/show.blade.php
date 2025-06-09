<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلاب</title>
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
    <nav class="bg-green-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4 space-x-reverse">
                <i class="fas fa-graduation-cap text-2xl"></i>
                <span class="text-xl font-semibold">ثانوية الإخوة عمور</span>
            </div>
            <div class="flex items-center space-x-6 space-x-reverse">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name=مدير+المدرسة&background=random" class="w-8 h-8 rounded-full">
                    <span>مدير المدرسة</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <aside class="w-64 bg-white shadow-md h-screen sticky top-0">
            <div class="p-4">
                <ul class="space-y-2 mt-6">
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse p-3 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>لوحة التحكم</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse p-3 bg-green-100 text-green-800 rounded-lg">
                            <i class="fas fa-users"></i>
                            <span>الطلاب</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse p-3 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>الأساتذة</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="font-bold text-gray-800 text-2xl">إدارة الطلاب</h1>
                    <p class="text-gray-600">قائمة الطلاب المعنيين بالبرنامج</p>
                </div>
                <div class="flex space-x-3 space-x-reverse">
                    <!-- CSV Upload Button -->
                    <button onclick="openCSVModal()" class="flex items-center space-x-2 space-x-reverse bg-white hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-lg text-gray-700">
                        <i class="fas fa-file-import"></i>
                        <span>رفع ملف CSV</span>
                    </button>
                    <!-- Add New Teacher Button -->
                    <button onclick="openAddModal()" class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                        <i class="fas fa-plus"></i>
                        <span>أضف طالب</span>
                    </button>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white shadow-md mb-6 p-4 rounded-lg">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="relative flex-1">
                        <input id="student-search" type="text" placeholder="ابحث عن طالب..." 
                               class="w-full pr-10 pl-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                    </div>
                    <div class="flex space-x-3 space-x-reverse">
                        <select class="border border-gray-300 rounded-lg px-3 py-2 text-gray-700">
                            <option>فرز حسب الأقدم</option>
                            <option>فرز حسب الأحدث</option>
                            <option>فرز حسب الاسم</option>
                        </select>
                        <label for="status-filter" class="sr-only">حسب الحالة</label>
                        <select id="status-filter" class="border border-gray-300 rounded-lg px-3 py-2 text-gray-700" name="status-filter">
                            <option value="all">عرض الكل</option>
                            <option value="invited">مرسل له</option>
                            <option value="accepted">مشارك</option>
                            <option value="declined">غير مشارك</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Students Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الرقم</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الاسم الكامل</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الحالة</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">المبلغ المدفوع</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الإجراءات</th>
                            </tr>
                        </thead>
                        @php
                            $program = \App\Models\Program::find(1);
                        @endphp
                        {{-- filepath: resources/views/admin/students/show.blade.php --}}
                        <tbody id="students-table-body" class="divide-y divide-gray-200">
                            @php $i = 1; @endphp
                            @foreach(\App\Models\ProgramInvitation::where('program_id', $program->id)->get() as $invitation)
                                @php
                                    $student = \App\Models\Student::find($invitation->student_id);
                                    $payment = \App\Models\StudentPayment::where('program_invitation_id', $invitation->id)->first();
                                    // Status mapping
                                    $statusText = 'غير معروف';
                                    $statusClass = 'bg-gray-200 text-gray-800';
                                    if ($invitation->status === 'invited') {
                                        $statusText = 'مرسل له';
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                    } elseif ($invitation->status === 'accepted') {
                                        $statusText = 'مشارك';
                                        $statusClass = 'bg-green-100 text-green-800';
                                    } elseif ($invitation->status === 'declined') {
                                        $statusText = 'غير مشارك';
                                        $statusClass = 'bg-red-100 text-red-800';
                                    }
                                @endphp
                                <tr class="hover:bg-gray-50" data-status="{{ $invitation->status }}">
                                    <td class="px-4 py-3">{{ str_pad($i, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-4 py-3 font-medium student-name">{{ $student ? $student->full_name : 'غير معروف' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="student-status {{ $statusClass }} px-2 py-1 rounded-full text-xs">{{ $statusText }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $payment ? number_format($payment->amount, 2) . ' دج' : '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex space-x-2 space-x-reverse">
                                            <a href="#" class="text-blue-600 hover:text-blue-800" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="text-yellow-600 hover:text-yellow-800" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="text-red-600 hover:text-red-800" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                    <div class="text-gray-500 text-sm">
                        عرض <span class="font-medium">1</span> إلى <span class="font-medium">10</span> من <span class="font-medium">{{ $i - 1 }}</span> نتائج
                    </div>
                    <div class="flex space-x-2 space-x-reverse">
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-50">
                            السابق
                        </button>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            1
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-50">
                            التالي
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('student-search');
            const tableBody = document.getElementById('students-table-body');
            const statusFilter = document.getElementById('status-filter');

            function filterTable() {
                const searchValue = searchInput.value.trim().toLowerCase();
                const statusValue = statusFilter.value;
                Array.from(tableBody.querySelectorAll('tr')).forEach(row => {
                    const nameCell = row.querySelector('.student-name');
                    const rowStatus = row.getAttribute('data-status');
                    if (!nameCell) return;
                    const name = nameCell.textContent.trim().toLowerCase();
                    const matchesSearch = name.includes(searchValue);
                    const matchesStatus = (statusValue === 'all') || (rowStatus === statusValue);
                    row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);
        });
    </script>
</body>
</html>