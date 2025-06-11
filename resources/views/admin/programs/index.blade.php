@extends('layouts.app')

@section('title', 'إدارة البرامج التعليمية')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="font-bold text-gray-800 text-2xl">البرامج التعليمية</h1>
    <a href="{{ route('admin.programs.create') }}" class="flex items-center space-x-2 space-x-reverse bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg text-white">
        <i class="fas fa-plus"></i>
        <span>برنامج جديد</span>
    </a>
</div>

<div class="gap-6 grid grid-cols-1 md:grid-cols-3 mb-8">
    @foreach($programs as $program)
    <div class="hover:shadow-lg border border-gray-200 rounded-lg overflow-hidden program-card">
        <div class="{{ $program->is_active ? 'bg-green-600' : 'bg-indigo-600' }} p-4 text-white">
            <div class="flex justify-between items-center">
                <h3 class="font-bold text-lg">{{ $program->name }}</h3>
                @if($program->is_active)
                <span class="bg-green-600 px-2 py-1 rounded-full text-xs">نشط</span>
                @else
                <span class="bg-indigo-600 px-2 py-1 rounded-full text-xs">منتهي</span>
                @endif
            </div>
            <p class="mt-1 text-indigo-100 text-sm">
                من {{ \Carbon\Carbon::parse($program->start_date)->format('d/m/Y') }}
                إلى {{ \Carbon\Carbon::parse($program->end_date)->format('d/m/Y') }}
            </p>
        </div>
        <div class="p-4">
            <div class="flex justify-between items-center mb-3">
                <div>
                    <p class="text-gray-500 text-sm">الطلاب</p>
                    <p class="font-medium">
                        {{ \App\Models\ProgramInvitation::where('program_id', $program->id)->where('status', 'accepted')->count() }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">الأساتذة</p>
                    <p class="font-medium">3</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">المبلغ</p>
                    <p class="font-medium">
                        {{ is_numeric($program->registration_fees) ? number_format($program->registration_fees, 2, '.', '') : 'غير متوفر' }} د.ج
                    </p>
                </div>
            </div>
            <div class="flex space-x-2 space-x-reverse pt-3 border-gray-200 border-t">
                <a href="#" class="flex-1 bg-indigo-50 hover:bg-indigo-100 px-3 py-2 rounded text-indigo-600 text-sm text-center">
                    <i class="mr-1 fas fa-eye"></i> عرض
                </a>
                <a href="#" class="flex-1 bg-gray-50 hover:bg-gray-100 px-3 py-2 rounded text-gray-600 text-sm text-center">
                    <i class="mr-1 fas fa-edit"></i> تعديل
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection