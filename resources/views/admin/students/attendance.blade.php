<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الحضور</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');
        body { font-family: 'Tajawal', sans-serif; }
        .attendance-present { background-color: #d1fae5; color: #065f46; }
        .attendance-absent { background-color: #fee2e2; color: #b91c1c; }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-amber-800 shadow-lg text-white">
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
                        <a href="#" class="flex items-center space-x-2 space-x-reverse bg-amber-100 p-3 rounded-lg text-amber-800">
                            <i class="fas fa-user-check"></i>
                            <span>الحضور</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-graduation-cap"></i>
                            <span>الدرجات</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="font-bold text-gray-800 text-2xl">تسجيل الحضور اليومي</h1>
                <div class="flex items-center space-x-3 space-x-reverse">
                    <span class="text-gray-600">اليوم: الأحد 15 أكتوبر 2023</span>
                    <button class="bg-amber-600 hover:bg-amber-700 px-4 py-2 rounded-lg text-white">
                        <i class="fas fa-save"></i> حفظ
                    </button>
                </div>
            </div>

            <div class="bg-white shadow-md mb-6 rounded-lg overflow-hidden">
                <div class="p-4 border-gray-200 border-b">
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="text-blue-600 fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <h3 class="font-bold">برنامج الرياضيات المكثف</h3>
                            <p class="text-gray-500 text-sm">الفترة الصباحية - القاعة 12</p>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-right">#</th>
                                <th class="px-4 py-3 text-right">اسم الطالب</th>
                                <th class="px-4 py-3 text-right">الحضور</th>
                                <th class="px-4 py-3 text-right">ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">1</td>
                                <td class="px-4 py-3 font-medium">محمد أحمد عبد الله</td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <button class="px-3 py-1 rounded-full text-sm attendance-present">
                                            <i class="mr-1 fas fa-check"></i> حاضر
                                        </button>
                                        <button class="px-3 py-1 border border-gray-300 rounded-full text-sm">
                                            <i class="mr-1 fas fa-times"></i> غائب
                                        </button>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" class="px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-amber-500 w-full" placeholder="ملاحظات">
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">2</td>
                                <td class="px-4 py-3 font-medium">آمنة خالد قاسم</td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <button class="px-3 py-1 border border-gray-300 rounded-full text-sm">
                                            <i class="mr-1 fas fa-check"></i> حاضر
                                        </button>
                                        <button class="px-3 py-1 rounded-full text-sm attendance-absent">
                                            <i class="mr-1 fas fa-times"></i> غائب
                                        </button>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" class="px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-amber-500 w-full" placeholder="ملاحظات">
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