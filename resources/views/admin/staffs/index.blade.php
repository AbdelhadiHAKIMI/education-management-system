@extends('layouts.app')

@section('title', 'إدارة المؤطرين - برنامج الطالب المتفوق')

@section('content')
@php
// Get the current active academic year for this establishment
$activeAcademicYear = \App\Models\AcademicYear::where('establishment_id', Auth::user()->establishment_id)
->where('status', true)
->first();
@endphp

<div class="flex md:flex-row flex-col md:justify-between md:items-center gap-4 mb-6">
    <div>
        <h1 class="font-bold text-gray-800 text-2xl">إدارة المؤطرين</h1>
        <p class="text-gray-600">قائمة بجميع مؤطري المؤسسة</p>
    </div>
    <div class="flex sm:flex-row flex-col gap-2 sm:gap-3">
        <a href="{{ route('admin.staffs.create') }}"
            class="flex justify-center items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg w-full sm:w-auto text-white">
            <i class="fas fa-plus"></i>
            <span>إضافة مؤطر</span>
        </a>
    </div>
</div>

<div class="bg-white shadow-md mb-6 p-4 rounded-lg">
    <form method="GET" action="{{ route('admin.staffs.index') }}">
        <div class="flex md:flex-row flex-col md:justify-between md:items-center gap-4">
            <div class="relative flex-1">
                <input type="text" name="search" placeholder="ابحث عن مؤطر..."
                    value="{{ request('search') }}"
                    class="py-2 pr-10 pl-4 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-blue-500 w-full">
                <i class="top-3 right-3 absolute text-gray-400 fas fa-search"></i>
            </div>
            <div class="flex sm:flex-row flex-col gap-2 sm:gap-3">
                <select name="branch" class="px-3 py-2 border border-gray-300 rounded-lg w-full sm:w-auto text-gray-700">
                    <option value="">كل الشعب</option>
                    @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}"
                        {{ request('branch') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg w-full sm:w-auto text-white">
                    بحث
                </button>
            </div>
        </div>
    </form>
</div>

<div class="bg-white shadow-md rounded-lg overflow-x-auto">
    <table class="divide-y divide-gray-200 min-w-full text-xs sm:text-sm md:text-base">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-2 sm:px-4 md:px-6 py-3 text-right whitespace-nowrap">#</th>
                <th class="px-2 sm:px-4 md:px-6 py-3 text-right whitespace-nowrap">الاسم الكامل</th>
                <th class="px-2 sm:px-4 md:px-6 py-3 text-right whitespace-nowrap">الشعبة</th>
                <th class="px-2 sm:px-4 md:px-6 py-3 text-right whitespace-nowrap">الهاتف</th>
                <th class="px-2 sm:px-4 md:px-6 py-3 text-right whitespace-nowrap">المواد الدراسية</th>
                <th class="px-2 sm:px-4 md:px-6 py-3 text-right whitespace-nowrap">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @php $rowNumber = 1; @endphp
            @forelse($staffs as $staff)
            @if($activeAcademicYear && $staff->academic_year_id == $activeAcademicYear->id)
            <tr class="hover:bg-gray-50">
                <td class="px-2 sm:px-4 md:px-6 py-4 text-gray-500 whitespace-nowrap">{{ $rowNumber++ }}</td>
                <td class="px-2 sm:px-4 md:px-6 py-4 font-medium whitespace-nowrap">{{ $staff->full_name }}</td>
                <td class="px-2 sm:px-4 md:px-6 py-4 whitespace-nowrap">
                    @if ($staff->branch)
                    <span class="bg-blue-100 px-3 py-1 rounded-full text-blue-800 text-xs">
                        {{ $staff->branch->name }}
                    </span>
                    @else
                    <span class="text-gray-500 text-xs">-</span>
                    @endif
                </td>
                <td class="px-2 sm:px-4 md:px-6 py-4 text-gray-500 whitespace-nowrap">{{ $staff->phone ?? '-' }}</td>
                <td class="px-2 sm:px-4 md:px-6 py-4 text-gray-500 whitespace-nowrap">
                    @if ($staff->type === 'مؤطر دراسي' && $staff->subjects->isNotEmpty())
                    <div class="flex flex-wrap gap-1">
                        @foreach ($staff->subjects as $subject)
                        <span class="bg-green-100 px-2 py-0.5 rounded text-green-800 text-xs">
                            {{ $subject->name }}
                        </span>
                        @endforeach
                    </div>
                    @else
                    -
                    @endif
                </td>
                <td class="px-2 sm:px-4 md:px-6 py-4 whitespace-nowrap">
                    <div class="flex flex-row flex-wrap gap-2">
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
            @endif
            @empty
            <tr>
                <td colspan="6" class="px-2 sm:px-4 md:px-6 py-4 text-gray-500 text-center">لا يوجد مؤطرون مسجلون
                </td>
            </tr>
            @endforelse
            @if($rowNumber === 1)
            <tr>
                <td colspan="6" class="px-2 sm:px-4 md:px-6 py-4 text-gray-500 text-center">لا يوجد مؤطرون للسنة الدراسية الحالية</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="px-2 sm:px-4 md:px-6 py-4 border-gray-200 border-t">
        {{ $staffs->links() }}
    </div>
</div>
@endsection