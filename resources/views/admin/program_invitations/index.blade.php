@extends('layouts.app')

@section('title', 'دعوات البرامج')

@section('content')
@if(session('success'))
<div class="bg-green-100 mb-4 px-4 py-3 border border-green-200 rounded text-green-800 text-right">
    {{ session('success') }}
</div>
@endif

<div class="flex justify-between items-center mb-6">
    <h1 class="font-bold text-gray-800 text-2xl">دعوات البرامج</h1>
    <a href="{{ route('admin.program_invitations.create') }}" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
        <i class="fas fa-plus"></i> دعوة جديدة
    </a>
</div>

<!-- Level Filter -->
<form method="GET" class="mb-4">
    <div class="flex items-center space-x-2 space-x-reverse">
        <label for="level_id" class="font-medium text-gray-700">المستوى:</label>
        <select name="level_id" id="level_id" class="px-3 py-2 border border-gray-300 rounded-lg" onchange="this.form.submit()">
            <option value="">كل المستويات</option>
            @foreach($levels as $level)
            <option value="{{ $level->id }}" {{ ($levelId == $level->id) ? 'selected' : '' }}>{{ $level->name }}</option>
            @endforeach
        </select>
    </div>
</form>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">#</th>
                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">اسم الطالب</th>
                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">المستوى</th>
                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">البرنامج</th>
                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">الحالة</th>
                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">معفى؟</th>
                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">تاريخ الدعوة</th>
                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">تاريخ الرد</th>
                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($programInvitations as $invitation)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $invitation->id }}</td>
                    <td class="px-4 py-3">{{ $invitation->student?->full_name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $invitation->student?->level?->name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $invitation->program?->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="bg-green-100 px-2 py-1 rounded-full text-green-800 text-xs">
                            {{ $invitation->status === 'accepted' ? 'مشارك' : ($invitation->status === 'invited' ? 'مرسل له' : 'غير مشارك') }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        {{ $invitation->is_exempt ? 'نعم' : 'لا' }}
                    </td>
                    <td class="px-4 py-3">{{ $invitation->invited_at }}</td>
                    <td class="px-4 py-3">{{ $invitation->responded_at ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex space-x-2 space-x-reverse">
                            <a href="{{ route('admin.program_invitations.show', $invitation) }}" class="text-blue-600 hover:text-blue-800" title="عرض">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.program_invitations.edit', $invitation) }}" class="text-yellow-600 hover:text-yellow-800" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.program_invitations.destroy', $invitation) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف الدعوة؟');">
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
                    <td colspan="9" class="px-4 py-4 text-gray-500 text-center">لا توجد دعوات برامج.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection