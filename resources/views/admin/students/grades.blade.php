<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدخال الدرجات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');
        body { font-family: 'Tajawal', sans-serif; }
        .grade-excellent { background-color: #d1fae5; color: #065f46; }
        .grade-good { background-color: #f0fdf4; color: #166534; }
        .grade-average { background-color: #fef9c3; color: #854d0e; }
        .grade-poor { background-color: #fee2e2; color: #991b1b; }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-rose-800 shadow-lg text-white">
        <div class="flex justify-between items-center mx-auto px-4 py-3 container">
            <div class="flex items-center space-x-4 space-x-reverse">
                <i class="text-2xl fas fa-graduation-cap"></i>
                <span class="font-semibold text-xl">ثانوية الإخوة عمور</span>
            </div>
            <div class="flex items-center space-x-6 space-x-reverse">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name=أستاذ+رياضيات&background=random" class="rounded-full w-8 h-8">
                    <span>أ. محمد القاسمي</span>
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
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-user-check"></i>
                            <span>الحضور</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse bg-rose-100 p-3 rounded-lg text-rose-800">
                            <i class="fas fa-graduation-cap"></i>
                            <span>الدرجات</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-calendar-alt"></i>
                            <span>البرامج</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="font-bold text-gray-800 text-2xl">إدخال الدرجات</h1>
                <div class="flex items-center space-x-3 space-x-reverse">
                    <span class="text-gray-600">اختبار منتصف الفصل - الرياضيات</span>
                    <button class="bg-rose-600 hover:bg-rose-700 px-4 py-2 rounded-lg text-white">
                        <i class="mr-2 fas fa-save"></i> حفظ التغييرات
                    </button>
                </div>
            </div>

            <div class="bg-white shadow-md mb-6 rounded-lg overflow-hidden">
                <div class="p-4 border-gray-200 border-b">
                    <div class="gap-4 grid grid-cols-1 md:grid-cols-4">
                        <div>
                            <label class="block mb-1 text-gray-700">الصف</label>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 w-full">
                                <option>الثانية ثانوي - شعبة علوم</option>
                                <option>الثانية ثانوي - شعبة آداب</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700">نوع التقييم</label>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 w-full">
                                <option>اختبار منتصف الفصل</option>
                                <option>اختبار نهاية الفصل</option>
                                <option>اختبار عملي</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700">تاريخ الاختبار</label>
                            <input type="date" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 w-full" value="2023-11-15">
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700">الدرجة الكاملة</label>
                            <input type="number" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 w-full" value="20">
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-right">#</th>
                                <th class="px-4 py-3 text-right">اسم الطالب</th>
                                <th class="px-4 py-3 text-right">الدرجة</th>
                                <th class="px-4 py-3 text-right">التقدير</th>
                                <th class="px-4 py-3 text-right">ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">1</td>
                                <td class="px-4 py-3 font-medium">محمد أحمد عبد الله</td>
                                <td class="px-4 py-3">
                                    <input type="number" class="px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-rose-500 w-20" value="18">
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-full text-sm grade-excellent">ممتاز</span>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" class="px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-rose-500 w-full" placeholder="ملاحظات">
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">2</td>
                                <td class="px-4 py-3 font-medium">آمنة خالد قاسم</td>
                                <td class="px-4 py-3">
                                    <input type="number" class="px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-rose-500 w-20" value="15">
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-full text-sm grade-good">جيد جداً</span>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" class="px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-rose-500 w-full" placeholder="ملاحظات">
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">3</td> 