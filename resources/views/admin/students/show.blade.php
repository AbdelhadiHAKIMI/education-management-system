@extends('layouts.app')

@section('title', 'إدارة الطلاب')

@section('content')
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
            <tbody id="students-table-body" class="divide-y divide-gray-200">
                @php $i = 1; @endphp
                @if($program)
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
                @else
                <tr>
                    <td colspan="100%" class="py-4 text-gray-500 text-center">البرنامج غير موجود.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center px-6 py-4 border-gray-200 border-t">
        <div class="text-gray-500 text-sm">
            عرض <span class="font-medium">1</span> إلى <span class="font-medium">10</span> من <span class="font-medium">{{ $i - 1 }}</span> نتائج
        </div>
        <div class="flex space-x-2 space-x-reverse">
            <button class="hover:bg-gray-50 px-3 py-1 border border-gray-300 rounded-md text-gray-500">
                السابق
            </button>
            <button class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded-md text-white">
                1
            </button>
            <button class="hover:bg-gray-50 px-3 py-1 border border-gray-300 rounded-md text-gray-500">
                التالي
            </button>
        </div>
    </div>
</div>

<!-- Sidebar or Navigation Section -->
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
                <a href="{{ route('admin.students.index') }}" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-users"></i>
                    <span>عرض الطلاب</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.students.create') }}" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-user-plus"></i>
                    <span>إضافة طالب جديد</span>
                </a>
            </li>
            <li>
                <a href="{{ route('csv.processor') }}" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-file-csv"></i>
                    <span>استيراد الطلاب (CSV)</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.exam_results.prototype', [
                    'establishment_id' => auth()->user()->establishment_id,
                    'academic_year_id' => \App\Models\AcademicYear::where('establishment_id', auth()->user()->establishment_id)->where('status', true)->first()?->id
                ]) }}" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg font-semibold text-blue-700">
                    <i class="fas fa-upload"></i>
                    <span>رفع نتائج الامتحان</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.exam_results.dashboard', [
                    'establishment_id' => auth()->user()->establishment_id,
                    'academic_year_id' => \App\Models\AcademicYear::where('establishment_id', auth()->user()->establishment_id)->where('status', true)->first()?->id,
                    'exam_session_id' => \App\Models\ExamSession::where('academic_year_id', \App\Models\AcademicYear::where('establishment_id', auth()->user()->establishment_id)->where('status', true)->first()?->id)->where('is_current', true)->first()?->id
                ]) }}" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg font-semibold text-blue-700">
                    <i class="fas fa-chart-bar"></i>
                    <span>إحصائيات الامتحانات</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
@endsection