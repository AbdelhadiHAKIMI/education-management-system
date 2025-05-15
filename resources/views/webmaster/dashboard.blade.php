<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - مدير النظام</title>
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
    <!-- Navigation -->
    <nav class="bg-blue-800 shadow-lg text-white">
        <div class="flex justify-between items-center mx-auto px-4 py-3 container">
            <div class="flex items-center space-x-4 space-x-reverse">
                <i class="text-2xl fas fa-graduation-cap"></i>
                <span class="font-semibold text-xl">نظام الإدارة التعليمية</span>
            </div>
            
            <div class="flex items-center space-x-6 space-x-reverse">
                <a href="#" class="relative hover:text-blue-200">
                    <i class="fas fa-bell"></i>
                    <span class="-top-2 -right-2 absolute flex justify-center items-center bg-red-500 rounded-full w-5 h-5 text-white text-xs">3</span>
                </a>
                <div class="flex items-center space-x-2 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" 
                         class="rounded-full w-8 h-8" 
                         alt="صورة المستخدم">
                    <span>مدير النظام</span>
                    <i class="text-xs fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <aside class="top-0 sticky bg-white shadow-md w-64 h-screen">
            <div class="p-4 border-gray-200 border-b">
                <div class="flex items-center space-x-3 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" 
                         class="rounded-full w-10 h-10" 
                         alt="صورة المستخدم">
                    <div>
                        <p class="font-medium">مدير النظام</p>
                        <p class="text-gray-500 text-xs">{{ Auth::user()->name }}</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4">
                <ul class="space-y-2 mt-4">
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse bg-blue-100 p-3 rounded-lg text-blue-800">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>لوحة التحكم</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-school"></i>
                            <span>إدارة المؤسسات</span>
                            <span class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">5</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-users-cog"></i>
                            <span>مديرو المؤسسات</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-cog"></i>
                            <span>إعدادات النظام</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-history"></i>
                            <span>سجل الأحداث</span>
                        </a>
                    </li>
                </ul>
                
                <div class="mt-8 pt-4 border-gray-200 border-t">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 space-x-reverse hover:bg-red-50 p-3 rounded-lg w-full text-red-600">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>تسجيل الخروج</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside> 

        <!-- Content Area -->
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="font-bold text-gray-800 text-2xl">إدارة المؤسسات التعليمية</h1>
                    <p class="text-gray-600">قائمة بجميع المؤسسات المسجلة في النظام</p>
                </div>
                <a href="{{ route('webmaster.establishments.create') }}" class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                    <i class="fas fa-plus"></i>
                    <span>إضافة مؤسسة جديدة</span>
                </a>
            </div>
            
            <!-- Stats Cards -->
            <div class="gap-6 grid grid-cols-1 md:grid-cols-3 mb-8">
                <div class="bg-white shadow-md p-6 border-r-4 border-blue-500 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">المؤسسات النشطة</p>
                            <h3 class="font-bold text-2xl">{{ \App\Models\Establishment::where('is_active', '1')->count() }}</h3>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="text-blue-600 text-xl fas fa-school"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white shadow-md p-6 border-green-500 border-r-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">المؤسسات المعلقة</p>
                            <h3 class="font-bold text-2xl">{{ \App\Models\Establishment::where('is_active', '0')->count() }}</h3>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="text-green-600 text-xl fas fa-pause-circle"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white shadow-md p-6 border-purple-500 border-r-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">إجمالي الطلاب</p>
                            <h3 class="font-bold text-2xl">2,487</h3>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <i class="text-purple-600 text-xl fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Establishments Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">#</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">المؤسسة</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">المدير</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الطلاب</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الحالة</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">1</td>
                                <td class="px-4 py-3 font-medium">
                                    <div class="flex items-center space-x-3 space-x-reverse">
                                        <div class="bg-blue-100 p-2 rounded-full">
                                            <i class="text-blue-600 fas fa-school"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold">ثانوية الإخوة عمور</p>
                                            <p class="text-gray-500 text-sm">البليدة</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">عبد القادر بن عمر</td>
                                <td class="px-4 py-3">324</td>
                                <td class="px-4 py-3">
                                    <span class="bg-green-100 px-3 py-1 rounded-full text-green-800 text-sm">نشطة</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <a href="#" class="hover:bg-blue-50 p-2 rounded-full text-blue-600 hover:text-blue-800" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="hover:bg-yellow-50 p-2 rounded-full text-yellow-600 hover:text-yellow-800" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="hover:bg-red-50 p-2 rounded-full text-red-600 hover:text-red-800" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- More rows... -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="flex justify-between items-center px-4 py-3 border-gray-200 border-t">
                    <div class="flex flex-1 justify-between items-center">
                        <button class="inline-flex relative items-center bg-white hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-md font-medium text-gray-700 text-sm">
                            السابق
                        </button>
                        <div class="hidden md:flex space-x-1 space-x-reverse">
                            <button class="bg-blue-600 px-3 py-1 rounded-md text-white">1</button>
                            <button class="hover:bg-gray-100 px-3 py-1 rounded-md">2</button>
                            <button class="hover:bg-gray-100 px-3 py-1 rounded-md">3</button>
                            <span class="px-3 py-1">...</span>
                            <button class="hover:bg-gray-100 px-3 py-1 rounded-md">8</button>
                        </div>
                        <button class="inline-flex relative items-center bg-white hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-md font-medium text-gray-700 text-sm">
                            التالي
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>