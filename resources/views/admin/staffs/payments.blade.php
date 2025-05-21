<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المدفوعات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');
        body { font-family: 'Tajawal', sans-serif; }
        .payment-paid { background-color: #d1fae5; color: #065f46; }
        .payment-pending { background-color: #fef3c7; color: #92400e; }
        .payment-overdue { background-color: #fee2e2; color: #b91c1c; }
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
                    <img src="https://ui-avatars.com/api/?name=مدير+المالية&background=random" class="rounded-full w-8 h-8">
                    <span>مدير المالية</span>
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
                            <i class="fas fa-money-bill-wave"></i>
                            <span>المدفوعات</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>رواتب الأساتذة</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="font-bold text-gray-800 text-2xl">سجل المدفوعات</h1>
                <div class="flex space-x-3 space-x-reverse">
                    <button class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg text-white">
                        <i class="mr-2 fas fa-file-export"></i> تصدير
                    </button>
                    <button class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-white">
                        <i class="mr-2 fas fa-plus"></i> دفع جديد
                    </button>
                </div>
            </div>

            <div class="bg-white shadow-md mb-6 rounded-lg overflow-hidden">
                <div class="p-4 border-gray-200 border-b">
                    <div class="gap-4 grid grid-cols-1 md:grid-cols-4">
                        <div>
                            <label class="block mb-1 text-gray-700">البرنامج</label>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 w-full">
                                <option value="">الكل</option>
                                <option>الرياضيات المكثف</option>
                                <option>اللغة الإنجليزية</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700">الحالة</label>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 w-full">
                                <option value="">الكل</option>
                                <option>مدفوع</option