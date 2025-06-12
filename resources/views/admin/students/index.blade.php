@extends('layouts.app')

@section('title', 'إدارة الطلاب')

@section('content')
{{-- Success or Error Alerts --}}
@if(session('success'))
<div class="bg-green-100 mb-4 px-4 py-3 border border-green-200 rounded text-green-800 text-right">
    {{ session('success') }}
</div>
@endif
@if($errors->any())
<div class="bg-red-100 mb-4 px-4 py-3 border border-red-200 rounded text-red-800 text-right">
    <ul class="pr-5 list-disc">
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
    <div class="flex md:flex-row flex-col md:justify-between md:items-center gap-4">
        <div class="relative flex-1">
            <input id="student-search" type="text" placeholder="ابحث عن طالب..."
                class="py-2 pr-10 pl-4 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-blue-500 w-full">
            <i class="top-3 right-3 absolute text-gray-400 fas fa-search"></i>
        </div>
        <div class="flex space-x-3 space-x-reverse">
            <select class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700">
                <option>فرز حسب الأقدم</option>
                <option>فرز حسب الأحدث</option>
                <option>فرز حسب الاسم</option>
            </select>
            <label for="status-filter" class="sr-only">حسب الحالة</label>
            <select id="status-filter" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700" name="status-filter">
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
                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">الحالة</th>
                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="students-table-body">
                @forelse($students as $student)
                <tr class="hover:bg-gray-50" data-status="{{ $student->status }}">
                    <td class="px-4 py-3">{{ $student->id }}</td>
                    <td class="px-4 py-3 font-medium student-name">{{ $student->full_name }}</td>
                    <td class="px-4 py-3">{{ $student->birth_date }}</td>
                    <td class="px-4 py-3">{{ $student->level?->name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $student->branch?->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="bg-green-100 px-2 py-1 rounded-full text-green-800 text-xs">
                            {{ $student->status === 'accepted' ? 'مشارك' : ($student->status === 'invited' ? 'مرسل له' : 'غير مشارك') }}
                        </span>
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
                    <td colspan="7" class="px-4 py-4 text-gray-500 text-center">لا يوجد طلاب مسجلين في السنة الدراسية الحالية.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center px-6 py-4 border-gray-200 border-t">
        <div class="text-gray-500 text-sm">
            عرض
            <span class="font-medium">{{ $students->firstItem() ?? 0 }}</span>
            إلى
            <span class="font-medium">{{ $students->lastItem() ?? 0 }}</span>
            من
            <span class="font-medium">{{ $students->total() }}</span>
            نتائج
        </div>
        <div>
            {{ $students->links() }}
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div id="addStudentModal" class="hidden z-50 fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 p-4">
    <div class="flex flex-col bg-white shadow-xl rounded-lg w-full max-w-md max-h-[90vh]">
        <div class="flex justify-between items-center p-4 border-gray-200 border-b">
            <h3 class="font-bold text-lg">إضافة طالب جديد</h3>
            <button onclick="closeAddStudentModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form class="flex-1 space-y-4 p-6 overflow-y-auto" style="max-height:60vh;" method="POST" action="{{ route('students.store') }}">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block mb-2 font-medium text-gray-700 text-right">الاسم الكامل</label>
                    <input name="full_name" type="text" required
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full text-right">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700 text-right">تاريخ الميلاد</label>
                    <input name="birth_date" type="date" required
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full text-right">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700 text-right">المدرسة الأصلية</label>
                    <input name="origin_school" type="text"
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full text-right">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700 text-right">الحالة الصحية</label>
                    <input name="health_conditions" type="text"
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full text-right">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700 text-right">هاتف الولي</label>
                    <input name="parent_phone" type="text"
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full text-right">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700 text-right">هاتف الطالب</label>
                    <input name="student_phone" type="text"
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full text-right">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700 text-right">مستوى حفظ القرآن</label>
                    <input name="quran_level" type="text"
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full text-right">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700 text-right">الشعبة</label>
                    <select name="branch_id"
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full text-right">
                        @foreach(\App\Models\Branch::all() as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="bottom-0 sticky flex justify-end space-x-3 space-x-reverse bg-white pt-4 border-gray-200 border-t">
                <button type="button" onclick="closeAddStudentModal()"
                    class="hover:bg-gray-50 px-6 py-2 border border-gray-300 rounded-lg font-medium text-gray-700">
                    إلغاء
                </button>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg font-medium text-white">
                    حفظ الطالب
                </button>
            </div>
        </form>
    </div>
</div>

<!-- CSV Upload Modal (Popup) -->
<div id="csvModal" class="hidden z-50 fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 p-4">
    <div class="bg-white shadow-xl p-6 rounded-lg w-full max-w-md">
        <h3 class="mb-4 font-bold text-lg">رفع ملف CSV</h3>
        <form id="csv-upload-form" action="{{ route('csv.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="csv_file" class="block mb-2 font-medium text-gray-700 text-right">اختر ملف CSV</label>
                <input id="csv_file" name="csv_file" type="file" accept=".csv,.xlsx" required
                    class="border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full text-right">
            </div>
            <div class="mb-4">
                <label for="level_id" class="block mb-2 font-medium text-gray-700 text-right">المستوى الدراسي</label>
                <select id="level_id" name="level_id" class="border border-gray-300 rounded-lg w-full" required>
                    <option value="">اختر المستوى</option>
                    @foreach(\App\Models\Level::all() as $level)
                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-between items-center">
                <button type="button" onclick="closeCSVModal()"
                    class="hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-lg font-medium text-gray-700">
                    إلغاء
                </button>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg font-medium text-white">
                    رفع الملف
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

        // Modals
        window.openAddStudentModal = function() {
            document.getElementById('addStudentModal').classList.remove('hidden');
        }
        window.closeAddStudentModal = function() {
            document.getElementById('addStudentModal').classList.add('hidden');
        }

        // CSV Modal logic
        window.openCSVModal = function() {
            document.getElementById('csvModal').classList.remove('hidden');
        }
        window.closeCSVModal = function() {
            document.getElementById('csvModal').classList.add('hidden');
        }
    });
</script>
@endsection