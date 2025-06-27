@extends('layouts.app')

@section('content')
@php
// Defensive: fallback if not passed
$program = $program ?? null;
$invitations = $program?->invitations ?? collect();
$studentsCount = $invitations->count();
$acceptedCount = $invitations->where('status', 'accepted')->count();
$rejectedCount = $invitations->where('status', 'rejected')->count();
$pendingCount = $invitations->where('status', 'invited')->count();

// Fetch staff from program_staff table using eager loading
$supervisors = $program?->supervisors?->map->staff->filter() ?? collect();
$teachers = $program?->teachers?->map->staff->filter() ?? collect();
$admins = $program?->admins?->map->staff->filter() ?? collect();
$staffCount = $supervisors->count() + $teachers->count() + $admins->count();
@endphp

<div class="py-4 container">
    <a href="{{ route('admin.programs.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 mb-4 px-4 py-2 rounded font-semibold text-gray-700">
        <i class="fa-arrow-right fas"></i> رجوع
    </a>
    <h1 class="mb-4 font-bold text-gray-800 text-2xl">عرض البرنامج: {{ $program?->name ?? '-' }}</h1>

    <!-- Program Info Card -->
    <div class="bg-white shadow mb-6 p-4 rounded-lg">
        <h2 class="mb-2 font-semibold text-primary text-lg">معلومات البرنامج</h2>
        <div class="gap-4 grid grid-cols-1 md:grid-cols-2 text-gray-700">
            <div><strong>الوصف:</strong> {{ $program?->description ?? '-' }}</div>
            <div><strong>الفترة:</strong> {{ $program?->start_date }} إلى {{ $program?->end_date }}</div>
            <div><strong>السنة الدراسية:</strong> {{ $program?->academicYear?->name ?? '-' }}</div>
            <div><strong>المستوى:</strong> {{ $program?->level?->name ?? '-' }}</div>
            <div><strong>رسوم التسجيل:</strong> {{ number_format($program?->registration_fees ?? 0) }} د.ج</div>
            <div>
                <strong>الحالة:</strong>
                @if($program?->is_active)
                <span class="font-semibold text-green-600">نشط</span>
                @else
                <span class="font-semibold text-red-600">غير نشط</span>
                @endif
            </div>
            <div><strong>أنشئ بواسطة:</strong> {{ $program?->creator?->name ?? '-' }}</div>
            <div><strong>تاريخ الإنشاء:</strong> {{ $program?->created_at?->format('Y-m-d H:i') ?? '-' }}</div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="gap-4 grid grid-cols-1 md:grid-cols-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg text-center">
            <div class="font-bold text-blue-700 text-3xl">{{ $studentsCount }}</div>
            <div class="mt-1 text-gray-700">عدد الطلاب المدعوين</div>
        </div>
        <div class="bg-green-50 p-4 rounded-lg text-center">
            <div class="font-bold text-green-700 text-3xl">{{ $acceptedCount }}</div>
            <div class="mt-1 text-gray-700">قبلوا الدعوة</div>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg text-center">
            <div class="font-bold text-yellow-700 text-3xl">{{ $pendingCount }}</div>
            <div class="mt-1 text-gray-700">بانتظار الرد</div>
        </div>
        <div class="bg-red-50 p-4 rounded-lg text-center">
            <div class="font-bold text-red-700 text-3xl">{{ $rejectedCount }}</div>
            <div class="mt-1 text-gray-700">رفضوا الدعوة</div>
        </div>
    </div>

    <!-- Students List -->
    <div class="bg-white shadow mb-6 p-4 rounded-lg">
        <h2 class="mb-2 font-semibold text-primary text-lg">الطلاب المدعوون</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-right">
                <thead>
                    <tr>
                        <th class="px-3 py-2 border-b">#</th>
                        <th class="px-3 py-2 border-b">اسم الطالب</th>
                        <th class="px-3 py-2 border-b">الشعبة</th>
                        <th class="px-3 py-2 border-b">الحالة</th>
                        <th class="px-3 py-2 border-b">تاريخ الدعوة</th>
                        <th class="px-3 py-2 border-b">تاريخ الرد</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invitations as $i => $inv)
                    <tr>
                        <td class="px-3 py-2 border-b">{{ $i+1 }}</td>
                        <td class="px-3 py-2 border-b">{{ $inv->student?->full_name ?? '-' }}</td>
                        <td class="px-3 py-2 border-b">{{ $inv->student?->branch?->name ?? '-' }}</td>
                        <td class="px-3 py-2 border-b">
                            @if($inv->status == 'accepted')
                            <span class="font-semibold text-green-600">مقبول</span>
                            @elseif($inv->status == 'rejected')
                            <span class="font-semibold text-red-600">مرفوض</span>
                            @else
                            <span class="font-semibold text-yellow-600">بانتظار الرد</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 border-b">{{ $inv->invited_at?->format('Y-m-d') ?? '-' }}</td>
                        <td class="px-3 py-2 border-b">{{ $inv->responded_at?->format('Y-m-d') ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-4 text-gray-500 text-center">لا يوجد طلاب مدعوين.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
</div>
@endsection