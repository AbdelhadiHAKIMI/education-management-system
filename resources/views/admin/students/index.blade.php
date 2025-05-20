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
    <x-admin.navigation />
    <div class="flex">
        <x-admin.sidebar />
        <main class="flex-1 p-8">
            {{-- Success or Error Alerts --}}
            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800 border border-green-200 text-right">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-800 border border-red-200 text-right">
                    <ul class="list-disc pr-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="font-bold text-gray-800 text-2xl">إدارة الطلاب</h1>
                    <p class="text-gray-600">قائمة طلاب {{ $students->first()?->branch?->level?->academicYear?->establishment?->name ?? '' }}</p>
                </div>
                <div class="flex space-x-3 space-x-reverse">
                    <!-- CSV Upload Button -->
                    <button onclick="openCSVModal()" class="flex items-center space-x-2 space-x-reverse bg-white hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-lg text-gray-700">
                        <i class="fas fa-file-import"></i>
                        <span>رفع ملف CSV</span>
                    </button>
                    <!-- Add New Student Button -->
                    <button onclick="openAddStudentModal()" class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
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
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">معرف الطالب</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الاسم الكامل</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">تاريخ الميلاد</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">المستوى</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الشعبة</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody id="students-table-body" class="divide-y divide-gray-200">
                            {{-- $students is now defined above --}}
                            @foreach($students as $student)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $student->id }}</td>
                                    <td class="px-4 py-3 font-medium student-name">{{ $student->full_name }}</td>
                                    <td class="px-4 py-3">{{ $student->birth_date }}</td>
                                    <td class="px-4 py-3">
                                        {{ $student->branch && $student->branch->level ? $student->branch->level->name : '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $student->branch ? $student->branch->name : '-' }}
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                    <div class="text-gray-500 text-sm">
                        عرض <span class="font-medium" id="from-num">1</span> إلى <span class="font-medium" id="to-num">25</span> من <span class="font-medium" id="total-num">{{ $students->count() }}</span> نتائج
                    </div>
                    <div class="flex space-x-2 space-x-reverse">
                        <button id="prev-btn" class="px-3 py-1 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-50">
                            السابق
                        </button>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700" id="page-num">
                            1
                        </button>
                        <button id="next-btn" class="px-3 py-1 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-50">
                            التالي
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Student Modal -->
<div id="addStudentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] flex flex-col">
        <div class="flex justify-between items-center border-b border-gray-200 p-4">
            <h3 class="font-bold text-lg">إضافة طالب جديد</h3>
            <button onclick="closeAddStudentModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form class="p-6 space-y-4 overflow-y-auto flex-1" style="max-height:60vh;" method="POST" action="{{ route('students.store') }}">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-right text-gray-700 mb-2 font-medium">الاسم الكامل</label>
                    <input name="full_name" type="text" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right">
                </div>
                
                <div>
                    <label class="block text-right text-gray-700 mb-2 font-medium">تاريخ الميلاد</label>
                    <input name="birth_date" type="date" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right">
                </div>
                
                <div>
                    <label class="block text-right text-gray-700 mb-2 font-medium">المدرسة الأصلية</label>
                    <input name="origin_school" type="text" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right">
                </div>
                
                <div>
                    <label class="block text-right text-gray-700 mb-2 font-medium">الحالة الصحية</label>
                    <input name="health_conditions" type="text" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right">
                </div>
                
                <div>
                    <label class="block text-right text-gray-700 mb-2 font-medium">هاتف الولي</label>
                    <input name="parent_phone" type="text" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right">
                </div>
                
                <div>
                    <label class="block text-right text-gray-700 mb-2 font-medium">هاتف الطالب</label>
                    <input name="student_phone" type="text" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right">
                </div>
                
                <div>
                    <label class="block text-right text-gray-700 mb-2 font-medium">مستوى حفظ القرآن</label>
                    <input name="quran_level" type="text" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right">
                </div>
                
                <div>
                    <label class="block text-right text-gray-700 mb-2 font-medium">الشعبة</label>
                    <select name="branch_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right">
                        @foreach(\App\Models\Branch::all() as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="pt-4 border-t border-gray-200 flex justify-end space-x-3 space-x-reverse bg-white sticky bottom-0">
                <button type="button" onclick="closeAddStudentModal()" 
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    إلغاء
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    حفظ الطالب
                </button>
            </div>
        </form>
    </div>
</div>

    <!-- CSV Upload Modal -->
    <div id="csvModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h3 class="font-bold text-lg mb-4">رفع ملف CSV</h3>
            <form id="csv-upload-form" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="csv_file" class="block text-right text-gray-700 mb-2 font-medium">اختر ملف CSV</label>
                    <input id="csv_file" name="csv_file" type="file" accept=".csv" required 
                           class="w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right">
                </div>
                
                <div class="flex justify-between items-center">
                    <button type="button" onclick="closeCSVModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                        إلغاء
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                        رفع الملف
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Search and filter functionality
            const searchInput = document.getElementById('student-search');
            const statusFilter = document.getElementById('status-filter');
            const rows = Array.from(document.querySelectorAll('#students-table-body tr'));

            function filterStudents() {
                const searchTerm = searchInput.value.toLowerCase();
                const status = statusFilter.value;

                rows.forEach(row => {
                    const studentName = row.querySelector('.student-name').textContent.toLowerCase();
                    const matchesSearch = studentName.includes(searchTerm);
                    let matchesStatus = true;

                    if (status !== 'all') {
                        const studentStatus = row.dataset.status;
                        matchesStatus = (status === 'accepted' && studentStatus === 'مشارك') ||
                                        (status === 'invited' && studentStatus === 'مرسل له') ||
                                        (status === 'declined' && studentStatus === 'غير مشارك');
                    }

                    if (matchesSearch && matchesStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', filterStudents);
            statusFilter.addEventListener('change', filterStudents);

            // Pagination logic
            const perPage = 25;
            let currentPage = 1;

            function showPage(page) {
                const start = (page - 1) * perPage;
                const end = start + perPage;

                rows.forEach((row, index) => {
                    if (index >= start && index < end) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                document.getElementById('from-num').textContent = start + 1;
                document.getElementById('to-num').textContent = Math.min(end, rows.length);
                document.getElementById('total-num').textContent = rows.length;
                document.getElementById('page-num').textContent = page;

                document.getElementById('prev-btn').disabled = page === 1;
                document.getElementById('next-btn').disabled = end >= rows.length;
            }

            document.getElementById('prev-btn').addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                }
            });
            document.getElementById('next-btn').addEventListener('click', function() {
                if (currentPage * perPage < rows.length) {
                    currentPage++;
                    showPage(currentPage);
                }
            });

            // Initial display
            showPage(currentPage);

            // Modals
            window.openAddStudentModal = function() {
                document.getElementById('addStudentModal').classList.remove('hidden');
            }
            window.closeAddStudentModal = function() {
                document.getElementById('addStudentModal').classList.add('hidden');
            }
            window.openCSVModal = function() {
                document.getElementById('csvModal').classList.remove('hidden');
            }
            window.closeCSVModal = function() {
                document.getElementById('csvModal').classList.add('hidden');
            }
        });
    </script>
</body>
</html>