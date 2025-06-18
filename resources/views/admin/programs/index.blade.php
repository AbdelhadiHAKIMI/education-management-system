@extends('layouts.app')

@section('title', 'إدارة البرامج التعليمية')

@section('content')
<div class="flex md:flex-row flex-col md:justify-between md:items-center gap-4 mb-6">
    <h1 class="font-bold text-gray-800 text-2xl">البرامج التعليمية</h1>
    <a href="{{ route('admin.programs.create') }}"
        class="flex justify-center items-center gap-2 bg-gradient-to-l from-indigo-600 hover:from-indigo-700 to-blue-500 hover:to-blue-600 shadow px-6 py-2 rounded-lg w-full md:w-auto font-semibold text-white transition-all duration-200">
        <i class="fas fa-plus"></i>
        <span>برنامج جديد</span>
    </a>
</div>

<div class="gap-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mb-8">
    @forelse($programs as $program)
    <div class="flex flex-col bg-white hover:shadow-xl border border-gray-100 rounded-2xl h-full overflow-hidden transition-shadow duration-200">
        <div class="{{ $program->is_active ? 'bg-gradient-to-l from-green-500 to-green-600' : 'bg-gradient-to-l from-indigo-500 to-indigo-600' }} p-5 text-white">
            <div class="flex justify-between items-center">
                <h3 class="font-bold text-lg truncate">{{ $program->name }}</h3>
                @if($program->is_active)
                <span class="bg-green-600 shadow px-3 py-1 rounded-full font-bold text-xs">نشط</span>
                @else
                <span class="bg-indigo-600 shadow px-3 py-1 rounded-full font-bold text-xs">منتهي</span>
                @endif
            </div>
            <p class="mt-2 text-indigo-100 text-sm">
                <i class="ml-1 fas fa-calendar-alt"></i>
                من {{ \Carbon\Carbon::parse($program->start_date)->format('d/m/Y') }}
                إلى {{ \Carbon\Carbon::parse($program->end_date)->format('d/m/Y') }}
            </p>
        </div>
        <div class="flex flex-col flex-1 p-5">
            <div class="flex sm:flex-row flex-col justify-between items-start sm:items-center gap-4 mb-4">
                <div class="flex flex-col flex-1 items-center">
                    <span class="mb-1 text-gray-500 text-xs">الطلاب</span>
                    <span class="font-bold text-blue-700 text-lg">
                        {{ \App\Models\ProgramInvitation::where('program_id', $program->id)->where('status', 'accepted')->count() }}
                    </span>
                </div>
                <div class="flex flex-col flex-1 items-center">
                    <span class="mb-1 text-gray-500 text-xs">الأساتذة</span>
                    <span class="font-bold text-blue-700 text-lg">3</span>
                </div>
                <div class="flex flex-col flex-1 items-center">
                    <span class="mb-1 text-gray-500 text-xs">المبلغ</span>
                    <span class="font-bold text-blue-700 text-lg">
                        {{ is_numeric($program->registration_fees) ? number_format($program->registration_fees, 2, '.', '') : 'غير متوفر' }} د.ج
                    </span>
                </div>
            </div>
            <div class="flex sm:flex-row flex-col gap-2 mt-auto pt-4 border-gray-100 border-t">
                <a href="#"
                    class="flex flex-1 justify-center items-center gap-2 bg-indigo-50 hover:bg-indigo-100 shadow-sm px-4 py-2 rounded-lg font-semibold text-indigo-700 transition-colors duration-150">
                    <i class="fas fa-eye"></i> عرض
                </a>
                <a href="#"
                    class="flex flex-1 justify-center items-center gap-2 bg-gray-50 hover:bg-gray-100 shadow-sm px-4 py-2 rounded-lg font-semibold text-gray-700 transition-colors duration-150">
                    <i class="fas fa-edit"></i> تعديل
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-12 text-gray-500 text-center">
        <i class="mb-2 text-3xl fas fa-info-circle"></i>
        <div>لا توجد برامج تعليمية متاحة حالياً.</div>
    </div>
    @endforelse
</div>
@endsection