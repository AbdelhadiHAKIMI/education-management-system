<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلاب</title>
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
    <nav class="bg-green-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4 space-x-reverse">
                <i class="fas fa-graduation-cap text-2xl"></i>
                <span class="text-xl font-semibold">ثانوية الإخوة عمور</span>
            </div>
            <div class="flex items-center space-x-6 space-x-reverse">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name=مدير+المدرسة&background=random" class="w-8 h-8 rounded-full">
                    <span>مدير المدرسة</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <aside class="w-64 bg-white shadow-md h-screen sticky top-0">
            <div class="p-4">
                <ul class="space-y-2 mt-6">
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse p-3 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>لوحة التحكم</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse p-3 bg-green-100 text-green-800 rounded-lg">
                            <i class="fas fa-users"></i>
                            <span>الطلاب</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse p-3 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>الأساتذة</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">إدارة الطلاب</h1>
                <a href="#" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 space-x-reverse">
                    <i class="fas fa-plus"></i>
                    <span>إضافة طالب جديد</span>
                </a>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-1">البحث</label>
                        <input type="text" placeholder="ابحث بالاسم أو الرقم..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">المستوى</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">الكل</option>
                            <option>الأولى ثانوي</option>
                            <option>الثانية ثانوي</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">الحالة</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">الكل</option>
                            <option>نشط</option>
                            <option>غير نشط</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg w-full">
                            <i class="fas fa-filter"></i> تصفية
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-right">رقم التسجيل</th>
                            <th class="py-3 px-4 text-right">الاسم الكامل</th>
                            <th class="py-3 px-4 text-right">المستوى</th>
                            <th class="py-3 px-4 text-right">الحالة</th>
                            <th class="py-3 px-4 text-right">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">ST-2023-001</td>
                            <td class="py-3 px-4 font-medium">محمد أحمد عبد الله</td>
                            <td class="py-3 px-4">الثانية ثانوي</td>
                            <td class="py-3 px-4">
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">نشط</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2 space-x-reverse">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-50">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="text-yellow-600 hover:text-yellow-800 p-2 rounded-full hover:bg-yellow-50">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>