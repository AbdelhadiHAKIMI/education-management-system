@extends('layouts.app')

@section('title', 'تفاصيل المؤطر: ' . $staff->full_name)

@section('content')
@php
// Get the current active academic year for this establishment
$activeAcademicYear = \App\Models\AcademicYear::where('establishment_id', $staff->establishment_id)
->where('status', true)
->first();
@endphp

@if($activeAcademicYear && $staff->academic_year_id == $activeAcademicYear->id)
<div class="bg-white shadow-md mx-auto p-6 rounded-lg max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-bold text-gray-800 text-2xl">تفاصيل المؤطر: {{ $staff->full_name }}</h1>
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
                {{ \Carbon\Carbon::parse($staff->birth_date)->translatedFormat('d F Y') }}
            </p>
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
                <span class="bg-green-100 px-3 py-1 rounded-full text-green-800 text-sm">
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

    <div class="flex justify-end space-x-3 space-x-reverse mt-8 pt-4 border-gray-200 border-t">
        <a href="{{ route('admin.staffs.edit', $staff->id) }}"
            class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
            <i class="ml-2 fas fa-edit"></i> تعديل
        </a>
        <form action="{{ route('admin.staffs.destroy', $staff->id) }}" method="POST"
            onsubmit="return confirm('هل أنت متأكد من حذف هذا المؤطر؟');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-white">
                <i class="ml-2 fas fa-trash-alt"></i> حذف
            </button>
        </form>
    </div>
</div>
@else
<div class="bg-white shadow-md mx-auto p-6 rounded-lg max-w-3xl font-bold text-red-600 text-center">
    لا يوجد مؤطر مطابق للسنة الدراسية الحالية.
</div>
@endif
@endsection
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
    <div class="bg-white shadow-md mx-auto p-6 rounded-lg max-w-3xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="font-bold text-gray-800 text-2xl">تفاصيل المؤطر: {{ $staff->full_name }}</h1>
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
                    {{ \Carbon\Carbon::parse($staff->birth_date)->translatedFormat('d F Y') }}
                </p>
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
                    <span class="bg-green-100 px-3 py-1 rounded-full text-green-800 text-sm">
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

        <div class="flex justify-end space-x-3 space-x-reverse mt-8 pt-4 border-gray-200 border-t">
            <a href="{{ route('admin.staffs.edit', $staff->id) }}"
                class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                <i class="ml-2 fas fa-edit"></i> تعديل
            </a>
            <form action="{{ route('admin.staffs.destroy', $staff->id) }}" method="POST"
                onsubmit="return confirm('هل أنت متأكد من حذف هذا المؤطر؟');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-white">
                    <i class="ml-2 fas fa-trash-alt"></i> حذف
                </button>
            </form>
        </div>
    </div>
</main>
</div>
</body>

</html>