<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المؤسسة - نظام الإدارة التعليمية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');

        body {
            font-family: 'Tajawal', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation (Same as WebMaster Dashboard) -->

    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar (Same as WebMaster Dashboard) -->

        <!-- Content Area -->
        <main class="flex-1 p-8">
            @if(isset($establishment))
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="font-bold text-gray-800 text-2xl">{{ $establishment->name }}</h1>
                    <p class="text-gray-600">تفاصيل المؤسسة التعليمية</p>
                </div>
                <a href="{{ route('webmaster.dashboard') }}" class="flex items-center space-x-2 space-x-reverse bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-gray-800">
                    <i class="fa-arrow-right fas"></i>
                    <span>رجوع</span>
                </a>
            </div>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                        <div>
                            <h3 class="mb-4 pb-2 border-gray-200 border-b font-semibold text-gray-800 text-lg">معلومات المؤسسة</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-gray-500">الاسم</p>
                                    <p class="font-medium">{{ $establishment->name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">العنوان</p>
                                    <p class="font-medium">{{ $establishment->location }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">رمز التسجيل</p>
                                    <p class="font-medium">{{ $establishment->registration_code }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">الشعار</p>
                                    @if($establishment->logo)
                                    <img src="{{ asset('storage/' . $establishment->logo) }}" alt="شعار المؤسسة" class="mt-2 border rounded-full w-24 h-24">
                                    @else
                                    <span class="text-gray-400">لا يوجد شعار</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="mb-4 pb-2 border-gray-200 border-b font-semibold text-gray-800 text-lg">معلومات الاتصال</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-gray-500">الولاية</p>
                                    <p class="font-medium">{{ $establishment->wilaya ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">رقم الهاتف</p>
                                    <p class="font-medium">{{ $establishment->phone ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">البريد الإلكتروني</p>
                                    <p class="font-medium">{{ $establishment->email ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">الحالة</p>
                                    <p class="font-medium">
                                        @if($establishment->is_active)
                                        <span class="bg-green-100 px-2 py-1 rounded-full text-green-800 text-sm">نشطة</span>
                                        @else
                                        <span class="bg-red-100 px-2 py-1 rounded-full text-red-800 text-sm">معلقة</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <h3 class="mb-4 pb-2 border-gray-200 border-b font-semibold text-gray-800 text-lg">مدير المؤسسة</h3>
                            <div class="flex items-center space-x-4 space-x-reverse bg-gray-50 p-4 rounded-lg">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($establishment->manager->name ?? '-') }}&background=random"
                                    class="rounded-full w-16 h-16"
                                    alt="صورة المدير">
                                <div>
                                    <p class="font-bold">{{ $establishment->manager->name ?? '-' }}</p>
                                    <p class="text-gray-600">مدير المؤسسة</p>
                                    <p class="mt-1 text-gray-500 text-sm"><i class="mr-1 fas fa-phone"></i> {{ $establishment->manager->phone ?? '-' }}</p>
                                    <p class="text-gray-500 text-sm"><i class="mr-1 fas fa-envelope"></i> {{ $establishment->manager->email ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 space-x-reverse mt-8 pt-6 border-gray-200 border-t">
                        <a href="{{ route('webmaster.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg text-gray-800">
                            رجوع
                        </a>
                        <a href="{{ route('webmaster.establishments.edit', $establishment->id) }}" class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg text-white">
                            <i class="fas fa-edit"></i>
                            <span>تعديل</span>
                        </a>
                    </div>
                </div>
            </div>
            @else
            {{-- ...existing code for the list of establishments... --}}
            @endif
        </main>
    </div>
</body>

</html>