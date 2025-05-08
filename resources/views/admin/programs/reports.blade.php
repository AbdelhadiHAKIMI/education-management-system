<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التقارير والإحصائيات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');
        body { font-family: 'Tajawal', sans-serif; }
        .report-card { transition: all 0.3s ease; }
        .report-card:hover { transform: translateY(-3px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-purple-800 shadow-lg text-white">
        <div class="flex justify-between items-center mx-auto px-4 py-3 container">
            <div class="flex items-center space-x-4 space-x-reverse">
                <i class="text-2xl fas fa-graduation-cap"></i>
                <span class="font-semibold text-xl">ثانوية الإخوة عمور</span>
            </div>
            <div class="flex items-center space-x-6 space-x-reverse">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name=مدير+التقارير&background=random" class="rounded-full w-8 h-8">
                    <span>مدير التقارير</span>
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
                        <a href="#" class="flex items-center space-x-2 space-x-reverse bg-purple-100 p-3 rounded-lg text-purple-800">
                            <i class="fas fa-chart-bar"></i>
                            <span>التقارير</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-file-export"></i>
                            <span>تصدير البيانات</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="font-bold text-gray-800 text-2xl">التقارير والإحصائيات</h1>
                <button class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg text-white">
                    <i class="mr-2 fas fa-plus"></i> إنشاء تقرير جديد
                </button>
            </div>

            <div class="gap-6 grid grid-cols-1 md:grid-cols-3 mb-8">
                <!-- Report Card 1 -->
                <div class="bg-white shadow-md border border-gray-200 rounded-lg overflow-hidden report-card">
                    <div class="bg-blue-600 p-4 text-white">
                        <h3 class="font-bold text-lg">تقرير الحضور الشهري</h3>
                        <p class="mt-1 text-blue-100 text-sm">أكتوبر 2023</p>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <p class="text-gray-500 text-sm">نسبة الحضور</p>
                                <p class="font-medium text-2xl">89%</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="text-blue-600 fas fa-user-check"></i>
                            </div>
                        </div>
                        <div class="pt-3 border-gray-200 border-t">
                            <a href="#" class="block bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded w-full text-blue-600 text-sm text-center">
                                <i class="mr-1 fas fa-eye"></i> عرض التقرير
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Report Card 2 -->
                <div class="bg-white shadow-md border border-gray-200 rounded-lg overflow-hidden report-card">
                    <div class="bg-green-600 p-4 text-white">
                        <h3 class="font-bold text-lg">تقرير المدفوعات</h3>
                        <p class="mt-1 text-green-100 text-sm">الفصل الأول 2023</p>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <p class="text-gray-500 text-sm">إجمالي المدفوعات</p>
                                <p class="font-medium text-2xl">2,450,000 د.ج</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="text-green-600 fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                        <div class="pt-3 border-gray-200 border-t">
                            <a href="#" class="block bg-green-50 hover:bg-green-100 px-3 py-2 rounded w-full text-green-600 text-sm text-center">
                                <i class="mr-1 fas fa-file-pdf"></i> PDF
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Report Card 3 -->
                <div class="bg-white shadow-md border border-gray-200 rounded-lg overflow-hidden report-card">
                    <div class="bg-amber-600 p-4 text-white">
                        <h3 class="font-bold text-lg">تقرير النتائج</h3>
                        <p class="mt-1 text-amber-100 text-sm">اختبار منتصف الفصل</p>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <p class="text-gray-500 text-sm">معدل النجاح</p>
                                <p class="font-medium text-2xl">85%</p>
                            </div>
                            <div class="bg-amber-100 p-3 rounded-full">
                                <i class="text-amber-600 fas fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="pt-3 border-gray-200 border-t">
                            <a href="#" class="block bg-amber-50 hover:bg-amber-100 px-3 py-2 rounded w-full text-amber-600 text-sm text-center">
                                <i class="mr-1 fas fa-file-excel"></i> Excel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md mb-8 p-6 rounded-lg">
                <h2 class="mb-4 font-semibold text-gray-800 text-xl">منشئ التقارير</h2>
                <form>
                    <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                        <div>
                            <label class="block mb-2 text-gray-700">نوع التقرير</label>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 w-full">
                                <option value="">اختر نوع التقرير</option>
                                <option>الحضور</option>
                                <option>النتائج</option>
                                <option>المدفوعات</option>
                                <option>البرامج</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700">من تاريخ</label>
                            <input type="date" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 w-full">
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700">إلى تاريخ</label>
                            <input type="date" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 w-full">
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700">الصف</label>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 w-full">
                                <option value="">الكل</option>
                                <option>الأولى ثانوي</option>
                                <option>الثانية ثانوي</option>
                                <option>الثالثة ثانوي</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700">صيغة التقرير</label>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 w-full">
                                <option>PDF</option>
                                <option>Excel</option>
                                <option>Word</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg w-full text-white">
                                <i class="mr-2 fas fa-download"></i> إنشاء التقرير
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4 border-gray-200 border-b">
                    <h2 class="font-semibold text-gray-800 text-xl">آخر التقارير المولدة</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-right">#</th>
                                <th class="px-4 py-3 text-right">اسم التقرير</th>
                                <th class="px-4 py-3 text-right">النوع</th>
                                <th class="px-4 py-3 text-right">الفترة</th>
                                <th class="px-4 py-3 text-right">تاريخ الإنشاء</th>
                                <th class="px-4 py-3 text-right">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">1</td>
                                <td class="px-4 py-3 font-medium">تقرير الحضور الشهري</td>
                                <td class="px-4 py-3">الحضور</td>
                                <td class="px-4 py-3">أكتوبر 2023</td>
                                <td class="px-4 py-3">01/11/2023</td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <a href="#" class="hover:bg-blue-50 p-2 rounded-full text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="hover:bg-purple-50 p-2 rounded-full text-purple-600 hover:text-purple-800">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">2</td>
                                <td class="px-4 py-3 font-medium">تقرير نتائج اختبار الرياضيات</td>
                                <td class="px-4 py-3">النتائج</td>
                                <td class="px-4 py-3">نوفمبر 2023</td>
                                <td class="px-4 py-3">20/11/2023</td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <a href="#" class="hover:bg-blue-50 p-2 rounded-full text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="hover:bg-purple-50 p-2 rounded-full text-purple-600 hover:text-purple-800">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>