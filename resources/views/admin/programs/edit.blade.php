@extends('layouts.app')

@section('content')
@php
$program = $program ?? null;
$invitations = $program?->invitations ?? collect();
$studentsCount = $invitations->count();
$acceptedCount = $invitations->where('status', 'accepted')->count();
$pendingCount = $invitations->where('status', 'invited')->count() + $invitations->where('status', 'waiting_list')->count();
$rejectedCount = $invitations->where('status', 'declined')->count() + $invitations->where('status', 'rejected')->count();

// Fetch staff from program_staff table and join with staff table
$programStaff = \App\Models\ProgramStaff::with('staff')
->where('program_id', $program->id)
->get();

$supervisors = $programStaff->filter(function($ps) {
return $ps->staff && $ps->staff->type === 'مؤطر دراسي';
})->map(function($ps) { return $ps->staff; });

$teachers = $programStaff->filter(function($ps) {
return $ps->staff && $ps->staff->type === 'أستاذ';
})->map(function($ps) { return $ps->staff; });

$admins = $programStaff->filter(function($ps) {
return $ps->staff && $ps->staff->type === 'إداري';
})->map(function($ps) { return $ps->staff; });

$staffCount = $supervisors->count() + $teachers->count() + $admins->count();
@endphp

<div class="py-4 container">
    <a href="{{ route('admin.programs.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 mb-4 px-4 py-2 rounded font-semibold text-gray-700">
        <i class="fa-arrow-right fas"></i> رجوع
    </a>
    <h1 class="mb-4 font-bold text-gray-800 text-2xl">تعديل البرنامج: {{ $program?->name ?? '-' }}</h1>

    <!-- Program Edit Form -->
    <form method="POST" action="{{ route('admin.programs.update', $program->id) }}">
        @csrf
        @method('PUT')
        <div class="bg-white shadow mb-6 p-4 rounded-lg">
            <h2 class="mb-2 font-semibold text-primary text-lg">معلومات البرنامج</h2>
            <div class="gap-4 grid grid-cols-1 md:grid-cols-2 text-gray-700">
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">اسم البرنامج</label>
                    <input type="text" name="name" value="{{ old('name', $program->name) }}" class="px-4 py-2.5 border border-gray-300 rounded-lg w-full" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">الوصف</label>
                    <input type="text" name="description" value="{{ old('description', $program->description) }}" class="px-4 py-2.5 border border-gray-300 rounded-lg w-full">
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">تاريخ البدء</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $program->start_date ? \Carbon\Carbon::parse($program->start_date)->format('Y-m-d') : '') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg w-full" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">تاريخ الانتهاء</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $program->end_date ? \Carbon\Carbon::parse($program->end_date)->format('Y-m-d') : '') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg w-full" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">السنة الدراسية</label>
                    <select name="academic_year_id" class="px-4 py-2.5 border border-gray-300 rounded-lg w-full" required>
                        @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ (old('academic_year_id', $program->academic_year_id) == $year->id) ? 'selected' : '' }}>{{ $year->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">المستوى</label>
                    <select name="level_id" class="px-4 py-2.5 border border-gray-300 rounded-lg w-full" required>
                        @foreach($levels as $level)
                        <option value="{{ $level->id }}" {{ (old('level_id', $program->level_id) == $level->id) ? 'selected' : '' }}>{{ $level->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">رسوم التسجيل</label>
                    <input type="number" name="registration_fees" value="{{ old('registration_fees', $program->registration_fees) }}" class="px-4 py-2.5 border border-gray-300 rounded-lg w-full" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">الحالة</label>
                    <select name="is_active" class="px-4 py-2.5 border border-gray-300 rounded-lg w-full">
                        <option value="1" {{ (old('is_active', $program->is_active) == 1) ? 'selected' : '' }}>نشط</option>
                        <option value="0" {{ (old('is_active', $program->is_active) == 0) ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 shadow-md hover:shadow-lg px-8 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 font-bold text-white text-base transition-all duration-200">
                    <i class="fas fa-save"></i>
                    حفظ جميع معلومات البرنامج
                </button>
            </div>
        </div>
    </form>
    <!-- END Program Edit Form -->



    <!-- Statistics -->
    <div class="gap-4 grid grid-cols-1 md:grid-cols-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg text-center">
            <div class="font-bold text-blue-700 text-3xl">{{ $studentsCount }}</div>
            <div class="mt-1 text-gray-700">عدد الطلبة المدعوين</div>
        </div>
        <div class="bg-green-50 p-4 rounded-lg text-center">
            <div class="font-bold text-green-700 text-3xl">{{ $acceptedCount }}</div>
            <div class="mt-1 text-gray-700"> موافق </div>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg text-center">
            <div class="font-bold text-yellow-700 text-3xl">{{ $pendingCount }}</div>
            <div class="mt-1 text-gray-700">بانتظار الرد</div>
        </div>
        <div class="bg-red-50 p-4 rounded-lg text-center">
            <div class="font-bold text-red-700 text-3xl">{{ $rejectedCount }}</div>
            <div class="mt-1 text-gray-700">غير موافق</div>
        </div>
    </div>

    <!-- Students List -->
    <div class="bg-white shadow mb-6 p-4 rounded-lg">
        <h2 class="mb-2 font-semibold text-primary text-lg">الطلاب المدعوون</h2>
        <div class="flex sm:flex-row flex-col sm:items-center gap-2 mb-3">
            <input type="text" id="student-search-input" class="px-3 py-2 border rounded w-full sm:w-64" placeholder="بحث بالاسم...">
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-right" id="students-table">
                <thead>
                    <tr>
                        <th class="px-3 py-2 border-b cursor-pointer" data-sort="index">
                            <i class="ml-1 text-gray-400 text-xs fas fa-sort"></i> #
                        </th>
                        <th class="px-3 py-2 border-b cursor-pointer" data-sort="name">
                            <i class="ml-1 text-gray-400 text-xs fas fa-sort"></i> اسم الطالب
                        </th>
                        <th class="px-3 py-2 border-b cursor-pointer" data-sort="branch">
                            <i class="ml-1 text-gray-400 text-xs fas fa-sort"></i> الشعبة
                        </th>
                        <th class="px-3 py-2 border-b cursor-pointer" data-sort="status">
                            <i class="ml-1 text-gray-400 text-xs fas fa-sort"></i> الحالة
                        </th>
                        <th class="px-3 py-2 border-b cursor-pointer" data-sort="invited_at">
                            <i class="ml-1 text-gray-400 text-xs fas fa-sort"></i> تاريخ الدعوة
                        </th>
                        <th class="px-3 py-2 border-b cursor-pointer" data-sort="responded_at">
                            <i class="ml-1 text-gray-400 text-xs fas fa-sort"></i> تاريخ الرد
                        </th>
                    </tr>
                </thead>
                <tbody id="students-table-body">
                    @foreach($invitations as $i => $inv)
                    <tr data-name="{{ $inv->student?->full_name ?? '' }}"
                        data-branch="{{ $inv->student?->branch?->name ?? '' }}"
                        data-status="{{ $inv->status }}"
                        data-invited_at="{{ $inv->invited_at ? $inv->invited_at->format('Y-m-d') : '' }}"
                        data-responded_at="{{ $inv->responded_at ? $inv->responded_at->format('Y-m-d') : '' }}">
                        <td class="px-3 py-2 border-b">{{ $i+1 }}</td>
                        <td class="px-3 py-2 border-b">{{ $inv->student?->full_name ?? '-' }}</td>
                        <td class="px-3 py-2 border-b">{{ $inv->student?->branch?->name ?? '-' }}</td>
                        <td class="px-3 py-2 border-b">
                            <select class="px-2 py-1 border rounded invitation-status-select" name="statuses[{{ $inv->id }}]" data-invitation-id="{{ $inv->id }}">
                                <option value="invited" {{ $inv->status == 'invited' ? 'selected' : '' }}>مدعو</option>
                                <option value="accepted" {{ $inv->status == 'accepted' ? 'selected' : '' }}>موافق</option>
                                <option value="declined" {{ $inv->status == 'declined' ? 'selected' : '' }}> غير موافق </option>
                                <option value="waiting_list" {{ $inv->status == 'waiting_list' ? 'selected' : '' }}>قائمة الانتظار</option>
                            </select>
                        </td>
                        <td class="px-3 py-2 border-b">{{ $inv->invited_at?->format('Y-m-d') ?? '-' }}</td>
                        <td class="px-3 py-2 border-b">{{ $inv->responded_at?->format('Y-m-d') ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination controls -->
            <div class="flex justify-center mt-4" id="students-pagination"></div>
            <div class="flex justify-end mt-4">
                <button type="button" id="save-invitation-statuses" class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg font-semibold text-white">
                    حفظ التغييرات وتحديث الصفحة
                </button>
            </div>
        </div>
    </div>

    <!-- Staff List -->
    <div class="bg-white shadow mb-6 p-4 rounded-lg">
        <h2 class="mb-2 font-semibold text-primary text-lg">الفريق العامل</h2>
        <div class="gap-4 grid grid-cols-1 md:grid-cols-3">
            <div>
                <h3 class="mb-2 font-medium text-gray-700">المشرفون</h3>
                <ul class="pr-5 list-disc">
                    @forelse($supervisors as $staff)
                    <li>{{ $staff->full_name }}</li>
                    @empty
                    <li class="text-gray-400">لا يوجد مشرفون</li>
                    @endforelse
                </ul>
            </div>
            <div>
                <h3 class="mb-2 font-medium text-gray-700">الأساتذة</h3>
                <ul class="pr-5 list-disc">
                    @forelse($teachers as $staff)
                    <li>{{ $staff->full_name }}</li>
                    @empty
                    <li class="text-gray-400">لا يوجد أساتذة</li>
                    @endforelse
                </ul>
            </div>
            <div>
                <h3 class="mb-2 font-medium text-gray-700">الإداريون</h3>
                <ul class="pr-5 list-disc">
                    @forelse($admins as $staff)
                    <li>{{ $staff->full_name }}</li>
                    @empty
                    <li class="text-gray-400">لا يوجد إداريون</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="mt-4 text-gray-700">
            <strong>إجمالي الفريق:</strong> {{ $staffCount }}
        </div>
    </div>

    <div class="flex justify-end mt-8">
        <form method="GET" action="{{ route('admin.programs.index') }}">
            <button type="submit" class="bg-gray-500 hover:bg-gray-700 px-6 py-2 rounded-lg font-semibold text-white">
                العودة إلى قائمة البرامج
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('invitation-status-select')) {
                let invitationId = e.target.getAttribute('data-invitation-id');
                let status = e.target.value;
                fetch('/admin/programs/invitations/' + invitationId + '/status', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        // Optionally show a success message or update the row
                    });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('save-invitation-statuses').addEventListener('click', function() {
                const selects = document.querySelectorAll('.invitation-status-select');
                let updates = [];
                selects.forEach(function(sel) {
                    updates.push({
                        id: sel.getAttribute('data-invitation-id'),
                        status: sel.value
                    });
                });
                // Send all updates in parallel, then reload
                Promise.all(updates.map(u =>
                    fetch('/admin/programs/invitations/' + u.id + '/status', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            status: u.status
                        })
                    })
                )).then(() => {
                    location.reload();
                });
            });
        });

        // --- Pagination, Sorting, and Searching ---
        document.addEventListener('DOMContentLoaded', function() {
            let sortDirection = {};
            const table = document.getElementById('students-table');
            const tbody = document.getElementById('students-table-body');
            let allRows = Array.from(tbody.querySelectorAll('tr'));
            const rowsPerPage = 10;
            let currentPage = 1;

            function renderTablePage(page, filteredRows = null) {
                let rows = filteredRows || allRows;
                const totalPages = Math.ceil(rows.length / rowsPerPage);
                if (page < 1) page = 1;
                if (page > totalPages) page = totalPages;
                currentPage = page;
                tbody.innerHTML = '';
                rows.slice((page - 1) * rowsPerPage, page * rowsPerPage).forEach(tr => tbody.appendChild(tr));
                renderPagination(totalPages, page, rows);
            }

            function renderPagination(totalPages, page, rows) {
                const pagDiv = document.getElementById('students-pagination');
                pagDiv.innerHTML = '';
                if (totalPages <= 1) return;
                let html = '';
                if (page > 1) {
                    html += `<button class="mx-1 px-3 py-1 border rounded" data-page="${page-1}">&laquo;</button>`;
                }
                for (let i = 1; i <= totalPages; i++) {
                    html += `<button class="mx-1 px-3 py-1 rounded border ${i === page ? 'bg-blue-600 text-white' : ''}" data-page="${i}">${i}</button>`;
                }
                if (page < totalPages) {
                    html += `<button class="mx-1 px-3 py-1 border rounded" data-page="${page+1}">&raquo;</button>`;
                }
                pagDiv.innerHTML = html;
                pagDiv.querySelectorAll('button[data-page]').forEach(btn => {
                    btn.onclick = function() {
                        renderTablePage(parseInt(this.getAttribute('data-page')), getFilteredRows());
                    };
                });
            }

            function getFilteredRows() {
                const search = document.getElementById('student-search-input').value.trim().toLowerCase();
                return allRows.filter(tr => {
                    const name = (tr.dataset.name || '').toLowerCase();
                    return !search || name.includes(search);
                });
            }

            // Sorting
            table.querySelectorAll('th[data-sort]').forEach(function(th) {
                th.addEventListener('click', function() {
                    const key = th.getAttribute('data-sort');
                    sortDirection[key] = !sortDirection[key];
                    let rows = getFilteredRows();
                    rows.sort((a, b) => {
                        let aVal, bVal;
                        if (key === 'index') {
                            aVal = parseInt(a.children[0].textContent.trim());
                            bVal = parseInt(b.children[0].textContent.trim());
                        } else {
                            aVal = (a.dataset[key] || '').toLowerCase();
                            bVal = (b.dataset[key] || '').toLowerCase();
                        }
                        if (aVal < bVal) return sortDirection[key] ? -1 : 1;
                        if (aVal > bVal) return sortDirection[key] ? 1 : -1;
                        return 0;
                    });
                    allRows = rows;
                    renderTablePage(1, allRows);
                });
            });

            // Search by name
            document.getElementById('student-search-input').addEventListener('input', function() {
                renderTablePage(1, getFilteredRows());
            });

            // Initial render
            renderTablePage(1, allRows);
        });
    </script>
    @endsection