<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة البرامج التعليمية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');
        body { font-family: 'Tajawal', sans-serif; }
        .program-card { transition: all 0.3s ease; }
        .program-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-indigo-800 shadow-lg text-white">
        <div class="flex justify-between items-center mx-auto px-4 py-3 container">
            <div class="flex items-center space-x-4 space-x-reverse">
                <i class="text-2xl fas fa-graduation-cap"></i>
                <span class="font-semibold text-xl">ثانوية الإخوة عمور</span>
            </div>
            <div class="flex items-center space-x-6 space-x-reverse">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name=مدير+المدرسة&background=random" class="rounded-full w-8 h-8">
                    <span>مدير المدرسة</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <aside class="top-0 sticky bg-white shadow-md w-64 h-screen">
            <div class="p-4">
                <ul class="space-y-2 mt-6">
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>لوحة التحكم</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse bg-indigo-100 p-3 rounded-lg text-indigo-800">
                            <i class="fas fa-calendar-alt"></i>
                            <span>البرامج التعليمية</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-user-check"></i>
                            <span>الحضور</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-8">
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
        </main>
    </div>
</body>
</html>