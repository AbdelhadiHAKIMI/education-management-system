<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلاب - نظام الإدارة التعليمية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-tajawal">
    <!-- Navigation (Same as Dashboard) -->
    
    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar (Same as Dashboard) -->
        
        <!-- Content Area -->
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="font-bold text-gray-800 text-2xl">إدارة الطلاب</h1>
                <a href="#" class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                    <i class="fas fa-plus"></i>
                    <span>إضافة طالب جديد</span>
                </a>
            </div>
            
            <!-- Filters -->
            <div class="bg-white shadow-md mb-6 p-4 rounded-lg">
                <div class="gap-4 grid grid-cols-1 md:grid-cols-4">
                    <div>
                        <label class="block mb-1 text-gray-700">البحث</label>
                        <input type="text" placeholder="ابحث بالاسم أو الرقم..." class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700">المستوى</label>
                        <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                            <option value="">الكل</option>
                            <option>الأولى ثانوي</option>
                            <option>الثانية ثانوي</option>
                            <option>الثالثة ثانوي</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700">الحالة</label>
                        <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                            <option value="">الكل</option>
                            <option>نشط</option>
                            <option>موقوف</option>
                            <option>متخرج</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg w-full text-white">
                            <i class="fas fa-filter"></i> تصفية
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Students Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">رقم التسجيل</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الاسم الكامل</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">المستوى</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الحالة</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">آخر دفع</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-right">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">ST-2023-001</td>
                                <td class="px-4 py-3 font-medium">محمد أحمد عبد الله</td>
                                <td class="px-4 py-3">الثانية ثانوي</td>
                                <td class="px-4 py-3">
                                    <span class="bg-green-100 px-2 py-1 rounded-full text-green-800 text-xs">نشط</span>
                                </td>
                                <td class="px-4 py-3">25,000 د.ج - 10/09/2023</td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <a href="#" class="text-blue-600 hover:text-blue-800" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="text-yellow-600 hover:text-yellow-800" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="text-red-600 hover:text-red-800" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">ST-2023-002</td>
                                <td class="px-4 py-3 font-medium">آمنة خالد قاسم</td>
                                <td class="px-4 py-3">الثالثة ثانوي</td>
                                <td class="px-4 py-3">
                                    <span class="bg-green-100 px-2 py-1 rounded-full text-green-800 text-xs">نشط</span>
                                </td>
                                <td class="px-4 py-3">30,000 د.ج - 05/09/2023</td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <a href="#" class="text-blue-600 hover:text-blue-800" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="text-yellow-600 hover:text-yellow-800" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="text-red-600 hover:text-red-800" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">ST-2023-003</td>
                                <td class="px-4 py-3 font-medium">يوسف أمين صالح</td>
                                <td class="px-4 py-3">الأولى ثانوي</td>
                                <td class="px-4 py-3">
                                    <span class="bg-red-100 px-2 py-1 rounded-full text-red-800 text-xs">غير مدفوع</span>
                                </td>
                                <td class="px-4 py-3">-</td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <a href="#" class="text-blue-600 hover:text-blue-800" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="text-yellow-600 hover:text-yellow-800" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="text-red-600 hover:text-red-800" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">ST-2022-045</td>
                                <td class="px-4 py-3 font-medium">سارة عبد الرحيم</td>
                                <td class="px-4 py-3">الثالثة ثانوي</td>
                                <td class="px-4 py-3">
                                    <span class="bg-purple-100 px-2 py-1 rounded-full text-purple-800 text-xs">متخرج</span>
                                </td>
                                <td class="px-4 py-3">-</td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <a href="#" class="text-blue-600 hover:text-blue-800" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="text-yellow-600 hover:text-yellow-800" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="text-red-600 hover:text-red-800" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
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